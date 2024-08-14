@extends('master')
@section('navbar-title', 'Histori Reminder')
@section('content')
<!DOCTYPE html>
<html>

<head>
    <title>Histori Reminder</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- TableExport Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.2.0/js/tableexport.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.2.0/css/tableexport.min.css">
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

        /* Define colors for icons */
        .icon-edit {
            color: #FFC107;
        }

        .icon-delete {
            color: #DC3545;
        }

        /* Style for action buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        /* Search input styling */
        .search-container {
            margin-bottom: 20px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .search-input {
            width: 30%;
            padding: 6px;
            font-size: 14px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        /* Export button styling */
        .export-btn {
            padding: 6px 12px;
            font-size: 14px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

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

                    <!-- Search input and Export button -->
                    <div class="search-container">
                        <input type="text" id="searchInput" class="search-input" placeholder="Cari Histori Reminder...">
                        <a href="{{ route('export.pdf') }}" class="btn btn-danger mb-3">
                            <i class="fas fa-file-pdf"></i> Export to PDF
                        </a>
                    </div>

                    <div class="table-container">
                        <table id="tabelHistoriReminder" class="display" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Telepon</th>
                                    <th>Nomor Penerbangan</th>
                                    <th>Tanggal Keberangkatan</th>
                                    <th>Status Tiket</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($historiReminders as $index => $historiReminder)
                                <tr>
                                    <td>{{ $startIndex + $index }}</td>
                                    <td>{{ $historiReminder->reminder->no_hp }}</td>
                                    <td>{{ $historiReminder->penerbangan->nomor_penerbangan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($historiReminder->reminder->tgl_berangkat)->translatedFormat('d F Y') }}</td>
                                    <td>{{ $historiReminder->reminder->status_tiket }}</td>
                                    <td>{{ $historiReminder->reminder->ket_pesan }}</td>
                                    <td class="action-buttons">
                                        <!-- Edit button -->
                                        <a href="{{ route('reminder.index') }}" class="btn-action">
                                            <i class="fas fa-edit icon-edit"></i>
                                        </a>
                                        <!-- Delete button -->
                                        <form action="{{ route('reminder.destroy', $historiReminder->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action">
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
                            {{ $historiReminders->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#tabelHistoriReminder').DataTable({
                "paging": false // Disable DataTables pagination since we're using Laravel's pagination
            });

            // Initialize TableExport
            var table = TableExport(document.getElementById('tabelHistoriReminder'), {
                formats: ['xlsx'],
                filename: 'Histori_Reminder',
                exportButtons: false // We will trigger export manually
            });

            // Trigger export to Excel on button click
            $('#exportBtn').click(function() {
                table.export2file(table.getExportData()['tabelHistoriReminder']['xlsx'].data, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'Histori_Reminder');
            });
        });

        // Custom search function
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tabelHistoriReminder tbody tr');
            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                let found = false;
                for (let i = 0; i < cells.length; i++) {
                    if (cells[i].textContent.toLowerCase().includes(searchValue)) {
                        found = true;
                        break;
                    }
                }
                row.style.display = found ? '' : 'none';
            });
        });

        // Confirmation for delete
        function confirmDelete() {
            return confirm('Apakah anda yakin ingin menghapus data ini?');
        }
    </script>
</body>

</html>
@endsection
