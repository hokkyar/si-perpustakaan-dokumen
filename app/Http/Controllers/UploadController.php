<?php

namespace App\Http\Controllers;

use App\Models\Document;
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
    $link = true;
    return view('pages.upload', compact('link'));
  }

  public function store(Request $request)
  {

    if (!isInternetConnected()) {
      return redirect('/upload')->with('errors', 'Upload Gagal. Anda sedang offline');
    }

    $documentName = $request->input('documentName');
    $description = $request->input('description');
    $documentDate = $request->input('documentDate');
    $catalog = $request->input('catalog');
    $fileDocument = $request->file('fileDocument');

    try {
      Storage::disk('google')->put($fileDocument->getClientOriginalName(), File::get($fileDocument->path()));
    } catch (\Exception $e) {
      return redirect('/upload')->with('errors', 'Terjadi kesalahan');
    }

    $newDocument = new Document([
      'drive_id' => $fileDocument->getClientOriginalName(),
      'title' => $documentName,
      'description' => $description,
      'doc_date' => $documentDate,
      'catalog' => $catalog,
    ]);
    $newDocument->save();
    return redirect('/upload')->with('toast_success', 'Data berhasil disimpan');
  }
}
