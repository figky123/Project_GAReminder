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
            /* Margin for spacing */
        }

        /* Search input styling */
        .search-container {
            margin-bottom: 20px;
            width: 100%;
            /* Set container width */
            display: flex;
            justify-content: space-between;
            /* Align search input and export button */
        }

        .search-input {
            width: 30%;
            /* Adjusted width for search input */
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

                    <!-- Search input and Export button -->
                    <div class="search-container">
                        <input type="text" id="searchInput" class="search-input" placeholder="Cari Histori Reminder...">
                        <a href="{{ route('historiReminder.export') }}" class="btn btn-success mb-3">
                            <i class="fas fa-file-excel"></i> Export to Excel
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($historiReminders as $index => $historiReminder)
                                <tr>
                                    <td>{{ $startIndex + $index }}</td>
                                    <td>{{ $historiReminder->reminder->no_hp }}</td>
                                    <td>{{ $historiReminder->penerbangan->nomor_penerbangan }}</td>
                                    <td>{{ $historiReminder->reminder->tgl_berangkat }}</td>
                                    <td>{{ $historiReminder->reminder->status_tiket }}</td>
                                    <td>{{ $historiReminder->reminder->ket_pesan }}</td>
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
                for (let i = 0; i < cells.length; i++) { // Search in all columns
                    if (cells[i].textContent.toLowerCase().includes(searchValue)) {
                        found = true;
                        break;
                    }
                }
                row.style.display = found ? '' : 'none';
            });
        });
    </script>
</body>

</html>
@endsection