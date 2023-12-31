<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

class UploadController extends Controller
{
  public function index()
  {
    return view('pages.upload');
  }

  public function store(Request $request)
  {
    if (!isInternetConnected()) {
      return redirect('/upload')->with('errors', 'Upload Gagal. Anda sedang offline');
    }

    try {
      $documentName = $request->input('documentName');
      $description = $request->input('description');
      $documentDate = $request->input('documentDate');
      $catalog = $request->input('catalog');
      $fileDocument = $request->file('fileDocument');

      // $filename = uniqid('drive') . '-' . Carbon::now()->format('YmHisu') . '.' . $fileDocument->getClientOriginalExtension();
      $filename = $documentDate . ' ' . '[' . $catalog . ']' . ' ' . $documentName . '.' . $fileDocument->getClientOriginalExtension();
      Storage::disk('google')->put($filename, File::get($fileDocument->path()));
      $newDocument = new Document([
        'drive_id' => $filename,
        'title' => $documentName,
        'description' => $description,
        'doc_date' => $documentDate,
        'catalog' => $catalog,
      ]);
      $newDocument->save();
      return redirect('/upload')->with('toast_success', 'Data berhasil disimpan');
    } catch (\Exception $e) {
      if ($e->getCode() == 401) {
        return redirect('/dashboard')->with('errors', 'Tambah gagal. Kredensial atau token tidak valid');
      }
      return redirect('/upload')->with('errors', 'Terjadi kesalahan');
    }
  }
}
