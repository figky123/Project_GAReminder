<!-- resources/views/edit_penerbangan.blade.php -->

@extends('master')

@section('content')

<!DOCTYPE html>
<html>

<head>
    <title>Edit Data Penerbangan</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Edit Data Penerbangan</h2>
                <form action="{{ route('penerbangan.update', $penerbangan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengupdate data ini?')">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nomor_penerbangan">Nomor Penerbangan</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">GA</span>
                            </div>
                            <input type="text" name="nomor_penerbangan" id="nomor_penerbangan" class="form-control" maxlength="3" pattern="\d{3}" value="{{ old('nomor_penerbangan', $penerbangan->nomor_penerbangan ? substr($penerbangan->nomor_penerbangan, 2) : '') }}" required>
                        </div>
                        @if ($errors->has('nomor_penerbangan'))
                        <span class="text-danger">{{ $errors->first('nomor_penerbangan') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="rute_penerbangan">Rute Destinasi</label>
                        <input type="text" class="form-control" id="rute_penerbangan" name="rute_penerbangan" value="{{ $penerbangan->rute_penerbangan }}" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="jam_penerbangan">Jam Keberangkatan</label>
                        <input type="time" class="form-control" id="jam_penerbangan" name="jam_penerbangan" value="{{ substr($penerbangan->jam_penerbangan, 0, 5) }}" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Update</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>

@endsection