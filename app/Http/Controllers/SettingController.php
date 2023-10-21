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
    $secretKey = [env('GOOGLE_DRIVE_CLIENT_ID'), env('GOOGLE_DRIVE_CLIENT_SECRET')];
    $profiles = Profile::find(1);
    confirmDelete('Warning', 'Perbarui token?');
    return view('pages.pengaturan.index', compact('profiles', 'secretKey'));
  }

  public function changeProfile(Request $request)
  {
    if (!isInternetConnected()) {
      return redirect('/settings')->with('errors', 'Proses gagal. Anda sedang offline');
    }

    try {
      $profiles = Profile::find(1);
      $filePicture = $request->file('filePicture');

      if ($filePicture) {
        $path = $filePicture->store('public/img');
        $profiles->image_url = $path;
      }

      $profiles->name = $request->input('instansiName');
      $profiles->save();

      return redirect('/settings')->with('toast_success', 'Profil berhasil diubah');
    } catch (\Exception $e) {
      return redirect('/settings')->with('errors', 'Terjadi kesalahan');
    }
  }

  public function updateToken(Request $request)
  {
    if (!isInternetConnected()) {
      return redirect('/settings')->with('errors', 'Proses gagal. Anda sedang offline');
    }
    try {
      $newRefreshToken = $request->input('refreshToken');

      // save to db
      $token = Token::find(1);
      $token->drive_refresh_token = $newRefreshToken;
      $token->save();

      // change .env drive
      $envContents = file_get_contents(base_path('.env'));
      $envContents = preg_replace("/^GOOGLE_DRIVE_REFRESH_TOKEN=.*\n/m", "GOOGLE_DRIVE_REFRESH_TOKEN={$newRefreshToken}\n", $envContents);
      file_put_contents(base_path('.env'), $envContents);

      return redirect('/settings')->with('toast_success', 'Token berhasil diperbarui');
    } catch (\Exception $e) {
      return redirect('/settings')->with('errors', 'Terjadi kesalahan');
    }
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
