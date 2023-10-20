<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
use App\Models\Token;

function isInternetConnected()
{
  $connected = @fsockopen("www.example.com", 80);
  if ($connected) {
    fclose($connected);
    return true; // Koneksi internet ada
  }
  return false; // Tidak ada koneksi internet
}

class SettingController extends Controller
{
  public function index()
  {
    $profiles = Profile::find(1);
    return view('pages.pengaturan.index', compact('profiles'));
  }

  public function changeProfile(Request $request)
  {
    if (!isInternetConnected()) {
      return redirect('/settings')->with('errors', 'Proses gagal. Anda sedang offline');
    }

    $profiles = Profile::find(1);
    $filePicture = $request->file('filePicture');

    if ($filePicture) {
      $path = $filePicture->store('public/img');
      $profiles->image_url = $path;
    }

    $profiles->name = $request->input('instansiName');
    $profiles->save();

    return redirect('/settings')->with('toast_success', 'Profil berhasil diubah');
  }

  public function updateToken(Request $request)
  {
    if (!isInternetConnected()) {
      return redirect('/settings')->with('errors', 'Proses gagal. Anda sedang offline');
    }
    return redirect('/settings')->with('toast_success', 'Token berhasil diperbarui');
  }

  public function changePassword(Request $request)
  {

    if (!isInternetConnected()) {
      return redirect('/settings')->with('errors', 'Proses gagal. Anda sedang offline');
    }

    $oldPassword = $request->input('oldPassword');
    $newPassword = $request->input('newPassword');

    $user = auth()->user();

    if (password_verify($oldPassword, $user->password)) {
      $user->password = bcrypt($newPassword);
      $user->save();
      return redirect('/settings')->with('toast_success', 'Password berhasil diubah');
    } else {
      return redirect('/settings')->with('errors', 'Password lama salah');
    }
  }
}
