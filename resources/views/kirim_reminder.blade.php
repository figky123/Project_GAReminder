@extends('master')
@section('navbar-title', 'Kirim Reminder')
@section('content')
<!DOCTYPE html>
<html>

<head>
    <title>Kirim Reminder</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        /* Center align header text and data */
        table.dataTable thead th,
        table.dataTable tbody td {
            text-align: center;
        }

        /* Center the table on the page */
        .table-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
        }

        .add-button {
            margin-bottom: 15px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .add-button:hover {
            background-color: #218838;
        }

        /* Improved pagination styling */
        .pagination {
            margin: 20px 0;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .pagination .page-link {
            color: #007bff;
        }

        .pagination .page-link:hover {
            background-color: #e9ecef;
            border-color: #007bff;
        }

        /* Center modal content */
        .modal-content {
            margin: auto;
            float: none;
        }

        /* Custom styles for form */
        .card {
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            text-align: center;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 0.25rem;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert-success {
            text-align: center;
        }

        .remove-phone {
            color: red;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @if (session('pesan'))
                    <div class="alert alert-success">
                        {{ session('pesan') }}
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Form Kirim Reminder</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('reminder.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="no_hp">Nomor Telepon</label>
                                    <div id="phone-group">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="no_hp[]" required>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-success add-phone"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_penerbangan">Nomor Penerbangan</label>
                                    <select name="nomor_penerbangan" id="nomor_penerbangan" class="form-control">
                                        @foreach ($penerbanganValues as $nomor_penerbangan)
                                        <option value="{{ $nomor_penerbangan }}">{{ $nomor_penerbangan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tgl_berangkat">Tanggal Keberangkatan</label>
                                    <input type="date" class="form-control" id="tgl_berangkat" name="tgl_berangkat" required>
                                </div>
                                <div class="form-group">
                                    <label for="gambar_pesan">Gambar</label>
                                    <input type="file" class="form-control" id="gambar_pesan" name="gambar_pesan" required>
                                </div>
                                <div class="form-group">
                                    <label for="isi_pesan">Pesan Teks</label>
                                    <textarea class="form-control" id="isi_pesan" name="isi_pesan" rows="10" required>
Yth. Penumpang GA177. 
Pastikan dokumen penerbangan anda sudah sesuai dengan regulasi terbaru di bit.ly/InfoCovid19GA
Info lebih lanjut hub Live Chat bit.ly/livechatgaruda atau Call Center 08041807807. 

Dapatkan potongan hingga 80% untuk pembelian bagasi di awal. Harga mulai dari Rp 38.800/kg

Terima kasih atas kepercayaan Anda untuk selalu terbang bersama Garuda Indonesia.
    </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="status_tiket">Status Tiket</label>
                                    <select name="status_tiket" id="status_tiket" class="form-control">
                                        <option value="OK">OK</option>
                                        <option value="Irregularity">Irregular</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ket_pesan">Keterangan</label>
                                    <textarea class="form-control" id="ket_pesan" name="ket_pesan" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery Script to add and remove phone inputs -->
    <script>
        $(document).ready(function() {
            // Add new phone input
            $('.add-phone').click(function() {
                let newPhoneInput = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="no_hp[]" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger remove-phone"><i class="fas fa-minus"></i></button>
                    </div>
                </div>`;
                $('#phone-group').append(newPhoneInput);
            });

            // Remove phone input
            $(document).on('click', '.remove-phone', function() {
                $(this).closest('.input-group').remove();
            });
        });
    </script>
</body>

</html>
@endsection