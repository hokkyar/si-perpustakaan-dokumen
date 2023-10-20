@extends('layouts.app')

@section('title', 'Pengaturan')

@section('page', 'Pengaturan')

@section('content')
    <div>
        <div class="card card-body w-100 mb-3 mx-auto">
            <div class="d-flex justify-content-between flex-wrap">

                <div class="w-100 p-3">
                    <p>Ubah Profil Instansi</p>
                    <form action="{{ route('page.setting.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-2">
                            <label for="instansiName" class="form-label">Nama Instansi</label>
                            <input value="{{ $profiles->name }}" type="text" class="form-control" id="instansiName"
                                name="instansiName" aria-describedby="instansiNameHelp" autocomplete="off" required
                                placeholder="Masukkan nama instansi">
                        </div>
                        <label for="filePicture" class="form-label">Logo Instansi</label>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 10%;">
                                <img id="imagePreview" width="100%" style="border-radius: 5px;"
                                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSvf9wn1WvKWCp2eCV0atTl56ONzL6TyTPh702UMXqeHag2ZUG0YPch6-XWd2o4S_dK1J4&usqp=CAU"
                                    alt="">
                            </div>
                            <div class="mb-2" style="width: 90%;">
                                <input type="file" class="form-control" id="filePicture" name="filePicture"
                                    aria-describedby="filePictureHelp" accept="image/*" onchange="previewImage(event)">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-info mt-2">Ubah</button>
                        </div>
                    </form>
                </div>

                <div class="w-50 p-3">
                    <p>Perbarui Token</p>
                    <form action="{{ route('page.setting.token') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-2">
                            <label for="refreshToken" class="form-label">Token Baru</label>
                            <input type="text" class="form-control" id="refreshToken" name="refreshToken"
                                aria-describedby="refreshTokenHelp" autocomplete="off" required
                                placeholder="Masukkan token baru">
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Perbarui</button>
                    </form>
                </div>

                <div class="w-50 p-3">
                    <p>Ganti Password</p>
                    <form action="{{ route('page.setting.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        {{-- <div class="mb-2">
                            <label for="username" class="form-label">Username</label>
                            <input value="admin" type="text" class="form-control" id="username" name="username"
                                aria-describedby="usernameHelp" autocomplete="off" required
                                placeholder="Masukkan username baru">
                        </div> --}}
                        <div class="mb-2">
                            <label for="oldPassword" class="form-label">Password Lama</label>
                            <input type="password" class="form-control" id="oldPassword" name="oldPassword"
                                aria-describedby="oldPasswordHelp" autocomplete="off" required
                                placeholder="Masukkan password lama">
                        </div>
                        <div class="mb-2">
                            <label for="newPassword" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword"
                                aria-describedby="newPasswordHelp" autocomplete="off" required
                                placeholder="Masukkan password baru">
                        </div>
                        <button type="submit" class="btn btn-danger mt-3">Ganti Password</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const imagePreview = document.getElementById('imagePreview');
            const fileInput = event.target;
            const file = fileInput.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };

                reader.readAsDataURL(file);
            } else {
                imagePreview.src =
                    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSvf9wn1WvKWCp2eCV0atTl56ONzL6TyTPh702UMXqeHag2ZUG0YPch6-XWd2o4S_dK1J4&usqp=CAU';
            }
        }
    </script>

@endsection
