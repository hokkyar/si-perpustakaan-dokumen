@extends('layouts.app')

@section('title', 'Detail')

@section('page', 'Detail')

@section('content')
    <div>
        <div class="card card-body w-75 mb-3 mx-auto">
            <div class="d-flex justify-content-between">
                <a href="/dashboard" type="button" class="btn btn-sm btn-secondary">Kembali</a>
                <div>
                    <a href="{{ route('dashboard.edit', $document->id) }}" type="button"
                        class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('dashboard.destroy', $document->id) }}" class="btn btn-danger btn-sm"
                        data-confirm-delete="true">Hapus</a>
                </div>
            </div>
            <div class="d-flex flex-column h-100 p-0">
                <p href="" class="font-weight-bolder fs-4 text-center">{{ $document->title }}</p>
                <p class="mb-2 fs-5">{{ $document->description }}</p>
                <p style="font-size: 15px;" class="my-0">Diupload pada: <span
                        style="color: blue;">{{ $document->created_at }}</span></p>
                <p style="font-size: 15px;" class="my-0">Tanggal Surat: <span
                        style="color: blue;">{{ $document->doc_date }}</span></p>
                <p style="font-size: 15px;" class="my-0">Katalog: <span
                        style="color: blue;">{{ $document->catalog }}</span></p>
            </div>
            <div class="mt-3">
                <a href="{{ route('dashboard.download', $document->drive_id) }}" type="button"
                    class="btn btn-primary btn-sm">Download</a>
            </div>
        </div>

        <div class="card card-body w-75 mb-3 mx-auto">
            <h5 class="text-bold text-center mb-3">Preview</h5>
            <iframe src="https://drive.google.com/file/d/{{ $fileId }}/preview" width="100%" height="480"
                allow="autoplay"></iframe>
        </div>

    </div>
@endsection
