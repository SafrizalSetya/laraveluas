@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Edit Penilaian') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('penilaian.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="alternative_id" value="{{ $alternatif->id }}">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kode Kriteria</th>
                                <th>Nama Kriteria</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriterias as $kriteria)
                                @php
                                    $penilaian = $forms->where('kriteria_id', $kriteria->id)->first();
                                @endphp
                                <tr>
                                    <td>{{ $kriteria->kode_kriteria }}</td>
                                    <td>{{ $kriteria->nama_kriteria }}</td>
                                    <td>
                                        <input type="number" name="{{ $penilaian->id }}" value="{{ $penilaian ? $penilaian->nilai : 0 }}" class="form-control" required>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
