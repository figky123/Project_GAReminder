<!-- resources/views/penerbangan.blade.php -->
@extends('master')
@section('navbar-title', 'Data Jadwal Penerbangan')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Data Penerbangan</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- DataTables JS -->

    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        /* Define colors for icons */
        .icon-edit {
            color: #FFC107;
            /* Yellow for edit icon */
        }

        .icon-delete {
            color: #DC3545;
            /* Red for delete icon */
        }

        /* Style for action buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            /* Adjust gap between icons */
            justify-content: center;
        }

        .btn-action {
            border: none;
            background: none;
            cursor: pointer;
        }

        .btn-action:hover {
            opacity: 0.8;
            /* Slight opacity on hover */
        }

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
            /* Margin for spacing */
        }

        .add-button {
            margin-bottom: 15px;
            padding: 10px 20px;
            background-color: #28a745;
            /* Green for add button */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .add-button:hover {
            background-color: #218838;
            /* Darker green on hover */
        }
        /* Improved pagination styling */
        .pagination {
            margin: 20px 0;
            /* Margin for spacing */
        }
        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }
        .pagination .page-link {
            color: #007bff;
            /* Primary color for links */
        }
        .pagination .page-link:hover {
            background-color: #e9ecef;
            /* Light grey background on hover */
            border-color: #007bff;
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if (session('pesan'))
                    <div class="alert alert-success">
                        {{ session('pesan') }}
                    </div>
                    @endif
                    <button type="button" class="add-button" id="tombolTambahData" data-toggle="modal" data-target="#tambahDataModal">Tambah Data</button>
                    <table id="tabelPenerbangan" class="display" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>Nomor Penerbangan</th>
                                <th>Rute Destinasi</th>
                                <th>Jam Keberangkatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penerbangans as $penerbangan)
                            <tr>
                                <td>{{ $penerbangan->nomor_penerbangan }}</td>
                                <td>{{ $penerbangan->rute_penerbangan }}</td>
                                <td>{{ substr($penerbangan->jam_penerbangan, 0, 5) }}</td>
                                <td class="action-buttons">
                                    <!-- Edit button -->
                                    <a href="{{ route('penerbangan.edit', $penerbangan->id) }}" class="btn-action">
                                        <i class="fas fa-edit icon-edit"></i>
                                    </a>
                                    <!-- Delete button -->
                                    <form action="{{ route('penerbangan.destroy', $penerbangan->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action" onclick="return confirm('Are you sure you want to delete this item?')">
                                            <i class="fas fa-trash icon-delete"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                        <!-- Improved pagination links -->
                        <div class="pagination">
                            {{ $penerbangans->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding data -->
    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Penerbangan</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('penerbangan.store') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyimpan data ini?')">
                        @csrf
                        <div class="form-group">
                            <label for="nomor_penerbangan">Nomor Penerbangan</label>
                            <select name="nomor_penerbangan" id="nomor_penerbangan" class="form-control">
                                <option value="GA175">GA175</option>
                                <option value="GA177">GA177</option>
                                <option value="GA179">GA179</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rute_penerbangan">Rute Destinasi</label>
                            <input type="text" class="form-control" id="rute_penerbangan" name="rute_penerbangan" value="Pekanbaru-Jakarta" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="jam_penerbangan">Jam Keberangkatan</label>
                            <input type="time" class="form-control" id="jam_penerbangan" name="jam_penerbangan" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

@endsection
