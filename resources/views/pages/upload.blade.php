@extends('layouts.app')

@section('title', 'Upload')

@section('page', 'Upload')

@section('content')
    <div class="card p-3">
        <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label for="documentName" class="form-label">Nama Dokumen</label>
                <input type="text" class="form-control" id="documentName" name="documentName"
                    aria-describedby="documentNameHelp" autocomplete="off" required>
                <div id="documentNameHelp" class="form-text">Contoh: Dokumen SMA N 1 Singaraja</div>
            </div>
            <div class="mb-3">
                <label for="documentDate" class="form-label">Tanggal Dokumen</label>
                <input type="date" class="form-control" id="documentDate" name="documentDate"
                    aria-describedby="documentDateHelp" required>
                <div id="documentDateHelp" class="form-text">Contoh: 20/01/2022</div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" rows="3" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="catalog" class="form-label">Katalog</label>
                <input type="text" class="form-control" id="catalog" name="catalog" aria-describedby="catalogHelp"
                    autocomplete="off" required>
                <div id="catalogHelp" class="form-text">Contoh: Sekretriat</div>
            </div>
            <div class="mb-4">
                <label for="fileDocument" class="form-label">Upload File</label>
                <input type="file" class="form-control" id="fileDocument" name="fileDocument"
                    aria-describedby="fileDocumentHelp" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
