<?php

namespace App\Http\Controllers;

use App\Models\Document;
// use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yaza\LaravelGoogleDriveStorage\Gdrive;
use Illuminate\Support\Facades\File;

function isInternetConnected()
{
  $connected = @fsockopen("www.example.com", 80);
  if ($connected) {
    fclose($connected);
    return true; // Koneksi internet ada
  }
  return false; // Tidak ada koneksi internet
}

class DashboardController extends Controller
{
  public function index()
  {
    $documents = Document::all();
    return view('pages.dashboard', compact('documents'));
  }

  public function download(string $drive_id)
  {
    if (!isInternetConnected()) {
      return redirect('/dashboard')->with('errors', 'Download gagal. Anda sedang offline');
    }

    try {
      $data = Gdrive::get($drive_id);
      return response($data->file, 200)
        ->header('Content-Type', $data->ext)
        ->header('Content-disposition', 'attachment; filename="' . $data->filename . '"');
    } catch (\Exception $e) {
      if ($e->getCode() == 401) {
        return redirect('/dashboard')->with('errors', 'Download gagal. Token tidak valid');
      }
    }
  }

  public function show(string $id)
  {

    if (!isInternetConnected()) {
      return redirect('/dashboard')->with('errors', 'Gagal memuat. Anda sedang offline');
    }

    try {
      $document = Document::find($id);
      $file = Gdrive::all('/')->where('path', '=', $document->drive_id)->first();
      // dd(Gdrive::all('/'));
      $fileId = $file['extraMetadata']['id'];
      $visibility = $file['visibility'];

      if ($visibility == "private") {
        $service = Storage::disk('google')->getAdapter()->getService();
        $permission = new \Google_Service_Drive_Permission();
        $permission->setRole('reader');
        $permission->setType('anyone');
        $permission->setAllowFileDiscovery(false);
        $permissions = $service->permissions->create($fileId, $permission);
      }

      confirmDelete('Warning', 'Yakin ingin menghapus file ini?');
    } catch (\Exception $e) {
      if ($e->getCode() == 401) {
        return redirect('/dashboard')->with('errors', 'Token tidak valid');
      }
      return redirect('/dashboard')->with('errors', 'Terjadi kesalahan');
    }
    return view('pages.detail', compact('document', 'fileId'));
  }

  public function edit(string $id)
  {

    if (!isInternetConnected()) {
      return redirect('/dashboard')->with('errors', 'Gagal memuat. Anda sedang offline');
    }

    try {
      $document = Document::find($id);
      $file = Gdrive::all('/')->where('path', '=', $document->drive_id)->first();
      $fileId = $file['extraMetadata']['id'];
      return view('pages.edit', compact('document', 'fileId'));
    } catch (\Exception $e) {
      if ($e->getCode() == 401) {
        return redirect('/dashboard')->with('errors', 'Token tidak valid');
      }
      return redirect('/dashboard')->with('errors', 'Terjadi kesalahan');
    }
  }

  public function update(Request $request, string $id)
  {
    if (!isInternetConnected()) {
      return redirect('dashboard/' . $id)->with('errors', 'Update gagal. Anda sedang offline');
    }

    $document = Document::find($id);
    try {
      $document->title = $request->input('documentName');
      $document->doc_date = $request->input('documentDate');
      $document->description = $request->input('description');
      $document->catalog = $request->input('catalog');
      if ($request->file('fileDocument')) {
        $fileDocument = $request->file('fileDocument');
        Gdrive::delete($document->drive_id); // delete old file in drive
        // $filename = uniqid('drive') . '-' . Carbon::now()->format('YmHisu') . '.' . $fileDocument->getClientOriginalExtension();
        $filename = $request->input('documentDate') . ' ' . '[' . $request->input('catalog') . ']' . ' ' . $request->input('documentName') . '.' . $fileDocument->getClientOriginalExtension();
        $document->drive_id = $filename;
        Storage::disk('google')->put($filename, File::get($fileDocument->path())); // upload new file
      }
      $document->save();
    } catch (\Exception $e) {
      if ($e->getCode() == 401) {
        return redirect('/dashboard')->with('errors', 'Update gagal. Token tidak valid');
      }
      return redirect('dashboard/' . $id)->with('errors', 'Terjadi kesalahan');
    }

    return redirect('dashboard/' . $id)->with('toast_success', 'Data berhasil diedit');
  }

  public function destroy(string $id)
  {
    if (!isInternetConnected()) {
      return redirect('/dashboard')->with('errors', 'Gagal menghapus. Anda sedang offline');
    }
    try {
      $document = Document::find($id);
      $document->delete();
      Gdrive::delete($document->drive_id);
    } catch (\Exception $e) {
      if ($e->getCode() == 401) {
        return redirect('/dashboard')->with('errors', 'Hapus gagal. Token tidak valid');
      }
      return redirect('dashboard/' . $id)->with('errors', 'Terjadi kesalahan');
    }
    return redirect('/dashboard')->with('toast_success', 'Data berhasil dihapus');
  }
}
