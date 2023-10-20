@extends('layouts.app')

@section('title', 'Edit')

@section('page', 'Edit')

@section('content')
    <div class="card p-3">
        <form action="{{ route('dashboard.update', $document->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="documentName" class="form-label">Nama Dokumen</label>
                <input type="text" class="form-control" id="documentName" name="documentName"
                    aria-describedby="documentNameHelp" autocomplete="off" value="{{ $document->title }}">
                <div id="documentNameHelp" class="form-text">Contoh: Dokumen SMA N 1 Singaraja</div>
            </div>
            <div class="mb-3">
                <label for="documentDate" class="form-label">Tanggal Dokumen</label>
                <input type="date" class="form-control" id="documentDate" name="documentDate"
                    aria-describedby="documentDateHelp" value="{{ $document->doc_date }}">
                <div id="documentDateHelp" class="form-text">Contoh: 20/01/2022</div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" rows="3" name="description">{{ $document->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="catalog" class="form-label">Katalog</label>
                <input type="text" class="form-control" id="catalog" name="catalog" aria-describedby="catalogHelp"
                    autocomplete="off" value="{{ $document->catalog }}" required>
                <div id="catalogHelp" class="form-text">Contoh: Sekretriat</div>
            </div>
            <div class="mb-3">
                <label for="oldFile" class="form-label">File Lama : </label>
                <a href="{{ route('dashboard.download', $document->drive_id) }}">{{ $document->title }}</a>
            </div>
            <div class="mb-4">
                <label for="fileDocument" class="form-label">Ganti File</label>
                <input type="file" class="form-control" id="fileDocument" name="fileDocument"
                    aria-describedby="fileDocumentHelp">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
