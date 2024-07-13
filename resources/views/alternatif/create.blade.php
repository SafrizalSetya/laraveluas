@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Create Penilaian') }}</h1>

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
            <form action="{{ route('penilaian.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="alternative_id">Alternatif</label>
                    <select name="alternative_id" class="form-control" required>
                        <option value="">Pilih Alternatif</option>
                        @foreach ($alternatifs as $alternatif)
                            <option value="{{ $alternatif->id }}">{{ $alternatif->kode_alternatif }} - {{ $alternatif->nama_alternatif }}</option>
                        @endforeach
                    </select>
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
                                <tr>
                                    <td>{{ $kriteria->kode_kriteria }}</td>
                                    <td>{{ $kriteria->nama_kriteria }}</td>
                                    <td>
                                        <input type="number" name="{{ $kriteria->id }}" class="form-control" required>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
@endsection