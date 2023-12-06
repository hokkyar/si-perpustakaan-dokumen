@extends('layouts.app')

@section('title', 'Dashboard')

@section('page', 'Dashboard')

@section('content')

    <style>
        @media (max-width: 600px) {
            .card-container {
                flex-direction: column;
            }

            .card-item {
                width: 100%
            }
        }
    </style>

    @php
        $uniqueYears = $documents
            ->pluck('doc_date')
            ->map(function ($date) {
                return date('Y', strtotime($date));
            })
            ->unique();

        $uniqueCatalog = $documents
            ->pluck('catalog')
            ->map(function ($ctl) {
                return $ctl;
            })
            ->unique();
    @endphp

    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Dokumen</p>
                                <h5 class="font-weight-bolder mb-0">{{ count($documents) }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-archive-2 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Jumlah Katalog</p>
                                <h5 class="font-weight-bolder mb-0">{{ count($uniqueCatalog) }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-collection text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center flex-wrap">
        <div class="search-btn input-group w-50 mt-3">
            <span class="input-group-text bg-primary" style="width: 40px;" id="basic-addon1">
                <svg class="text-white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-calendar-event" viewBox="0 0 16 16">
                    <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                    <path
                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                </svg>
            </span>
            <select id="search-input-year" class="form-select">
                <option value="">Semua tahun</option>
                @foreach ($uniqueYears as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <div class="search-btn input-group w-50 mt-3">
            <span class="input-group-text bg-primary" style="width: 40px;" id="basic-addon1">
                <svg class="text-white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-funnel" viewBox="0 0 16 16">
                    <path
                        d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z" />
                </svg>
            </span>
            <input id="search-input-katalog" list="opsi-katalog" name="search-input" class="form-control me-2 p-2"
                placeholder="Cari katalog">
            <datalist id="opsi-katalog">
                @foreach ($uniqueCatalog as $catalog)
                    <option value="{{ $catalog }}">{{ $catalog }}</option>
                @endforeach
            </datalist>
        </div>

        <div class="search-btn my-2 input-group w-100">
            <span class="input-group-text bg-primary" style="width: 40px;" id="basic-addon1">
                <svg class="text-white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-search" viewBox="0 0 16 16">
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg>
            </span>
            <input id="search-input" class="form-control me-2 p-2" type="search" placeholder="Cari nama dokumen"
                aria-label="Search">
        </div>

    </div>

    <div class="card-container mt-2 gap-3">
        @include('partials.list', $documents)
    </div>

@endsection
