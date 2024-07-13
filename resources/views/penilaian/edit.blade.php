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
            <form action="{{ route('penilaian.update', $alternatif->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="alternative_id">Alternatif</label>
                    <input type="text" id="alternative_id" name="alternative_id" class="form-control" value="{{ $alternatif->kode_alternatif }} - {{ $alternatif->nama_alternatif }}" readonly>
                </div>
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
                                    $penilaian = $forms->firstWhere('kriteria_id', $kriteria->id);
                                    $nilai = $penilaian ? $penilaian->nilai : '';
                                @endphp
                                <tr>
                                    <td>{{ $kriteria->kode_kriteria }}</td>
                                    <td>{{ $kriteria->nama_kriteria }}</td>
                                    <td>
                                        <input type="number" name="nilai[{{ $kriteria->id }}]" class="form-control" value="{{ $nilai }}" required>
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
