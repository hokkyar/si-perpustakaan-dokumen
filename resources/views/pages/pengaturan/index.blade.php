@extends('layouts.app')

@section('title', 'Pengaturan')

@section('page', 'Pengaturan')

@section('content')
    <style>
        .modal-content {
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-content table {
            width: 100%;
        }

        .modal-content table tbody tr {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 5px 0;
        }
    </style>

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
                            <svg data-bs-toggle="modal" data-bs-target="#secretKey" xmlns="http://www.w3.org/2000/svg"
                                width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                                <path
                                    d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z" />
                                <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                            </svg>
                            <label for="refreshToken" class="form-label">Token Baru</label>
                            <input type="text" class="form-control" id="refreshToken" name="refreshToken"
                                aria-describedby="refreshTokenHelp" autocomplete="off" required
                                placeholder="Masukkan token baru">
                        </div>
                        <button onclick="return confirm('Perbarui token?')" type="submit"
                            class="btn btn-success mt-3">Perbarui</button>
                    </form>
                </div>

                <div class="w-50 p-3">
                    <p> Ganti Password</p>
                    <form action="{{ route('page.setting.password') }}" method="POST">
                        @csrf
                        @method('PUT')
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

    <!-- Modal -->
    <div class="modal fade" id="secretKey" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>OAuth Client ID : </th>
                                <td style="border: none;"> {{ $secretKey[0] }}</td>
                            </tr>
                            <tr>
                                <th>OAuth Client Secret : </th>
                                <td>{{ $secretKey[1] }}</td>
                            </tr>
                        </tbody>
                    </table>
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
