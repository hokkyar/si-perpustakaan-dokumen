@extends('layouts.app')

@section('title', 'Ganti Drive')

@section('page', 'Ganti Drive')

@section('content')
    <div>
        <div class="card card-body w-100 mb-3 mx-auto p-3">
            <h6>Ganti Akun Google Drive</h6>
            <p>Sebelum <span class="text-danger text-bold">mengganti akun google drive</span> saat ini, pastikan anda
                memahami beberapa informasi berikut.</p>
            <ol type="1">
                <li>Seluruh data dokumen yang ada pada sistem <span class="text-danger text-bold">akan dihapus</span>, namun
                    data pada
                    google drive akan tetap ada.
                </li>
                <li>Pastikan anda <span class="text-danger text-bold">menyimpan kredensial</span> seperti email dan password
                    dari akun google drive saat ini.</li>
                <li>Penggantian akun membutuhkan <span class="text-bold">OAuth Client ID</span> dan <span
                        class="text-bold">OAuth Client Secret</span> dari
                    akun google yang baru. Untuk mendapatkannya dapat melihat tutorial pada <a
                        style="text-decoration: none; color: rgb(60, 60, 255);" class="text-bold"
                        href="https://support.google.com/cloud/answer/6158849">Setting up OAuth 2.0</a>.
                </li>
                <li>Pastikan <span class="text-bold">OAuth Client ID</span> dan <span class="text-bold">OAuth Client
                        Secret</span> yang baru dimasukkan dengan benar. Jika tidak,
                    <span class="text-danger text-bold">anda tidak dapat melakukan upload dokumen</span> pada sistem.
                </li>
                <li>Jika terdapat <span class="text-danger text-bold">kesalahan dalam penginputan</span> dan sudah terlanjur
                    submit, anda dapat memasukkan kembali
                    <span class="text-bold">OAuth Client ID</span> dan <span class="text-bold">OAuth
                        Client Secret</span> pada kolom input di bawah.
                </li>
                <li>Setelah mengganti akun google drive, silahkan untuk memperbarui token di <a class="text-bold"
                        href="{{ route('page.setting') }}" style="text-decoration: none; color: rgb(60, 60, 255);">Halaman
                        Pengaturan</a>.</li>
            </ol>
            <form action="{{ route('changeDrive') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-2">
                    <label for="clientId" class="form-label">OAuth Client ID Baru: </label>
                    <input type="text" class="form-control" id="clientId" name="clientId"
                        aria-describedby="clientIdHelp" autocomplete="off" required
                        placeholder="Contoh : 1107xxxxxxx-xxxxxxx.apps.googleusercontent.com" required>
                </div>
                <div class="mb-2">
                    <label for="clientSecret" class="form-label">OAuth Client Secret Baru: </label>
                    <input type="text" class="form-control" id="clientSecret" name="clientSecret"
                        aria-describedby="clientSecretHelp" autocomplete="off" required placeholder="Contoh : G0XXXX-xxxxx"
                        required>
                </div>
                <div class="d-flex justify-content-end">
                    <button onclick="return confirm('Ganti Akun?')" type="submit" class="btn btn-danger mt-2">Ganti
                        Akun</button>
                </div>
            </form>
        </div>
    </div>

@endsection
