<?php

namespace App\Http\Controllers;

use App\Models\Document;
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
    $data = Gdrive::get($drive_id);
    return response($data->file, 200)
      ->header('Content-Type', $data->ext)
      ->header('Content-disposition', 'attachment; filename="' . $data->filename . '"');
  }

  public function show(string $id)
  {

    if (!isInternetConnected()) {
      return redirect('/dashboard')->with('errors', 'Gagal memuat. Anda sedang offline');
    }

    try {
      $document = Document::find($id);
      $file = Gdrive::all('/')->where('path', '=', $document->drive_id)->first();
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
      dd($e);
      if ($e->getCode() == 401) {
        dd("ERROR MISSING AUTHENTICATION INI WOI");
      }
      return redirect('/dashboard')->with('errors', 'Terjadi kesalahan');
    }
    return view('pages.detail', compact('document', 'fileId'));
  }

  public function edit(string $id)
  {
    $document = Document::find($id);
    $file = Gdrive::all('/')->where('path', '=', $document->drive_id)->first();
    $fileId = $file['extraMetadata']['id'];
    return view('pages.edit', compact('document', 'fileId'));
  }

  public function update(Request $request, string $id)
  {
    $document = Document::find($id);
    try {
      if ($request->file('fileDocument')) {
        $fileDocument = $request->file('fileDocument');
        Gdrive::delete($document->drive_id); // delete old file in drive
        $document->drive_id = $fileDocument->getClientOriginalName();
        Storage::disk('google')->put($fileDocument->getClientOriginalName(), File::get($fileDocument->path())); // upload new one
      }
      $document->title = $request->input('documentName');
      $document->doc_date = $request->input('documentDate');
      $document->description = $request->input('description');
      $document->catalog = $request->input('catalog');
      $document->save();
    } catch (\Exception $e) {
      return redirect('dashboard/' . $id)->with('errors', 'Terjadi kesalahan');
    }

    return redirect('dashboard/' . $id)->with('toast_success', 'Data berhasil diedit');
  }

  public function destroy(string $id)
  {
    try {
      $document = Document::find($id);
      $document->delete();
      Gdrive::delete($document->drive_id);
    } catch (\Exception $e) {
      return redirect('dashboard/' . $id)->with('errors', 'Terjadi kesalahan');
    }
    return redirect('/dashboard')->with('toast_success', 'Data berhasil dihapus');
  }
}