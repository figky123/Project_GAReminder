@extends('master')
@section('navbar-title', 'Data Users')
@section('content')
<!DOCTYPE html>
<html>

<head>
    <title>Data Users</title>
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

        /* Search input styling */
        .search-container {
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ced4da;
            border-radius: 4px;
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

                    <!-- Search input -->
                    <div class="search-container">
                        <input type="text" id="searchInput" placeholder="Cari Data Pengguna...">
                    </div>

                    <button type="button" class="add-button" id="tombolTambahData" data-toggle="modal" data-target="#tambahDataModal">Tambah User</button>
                    <table id="tabelUsers" class="display" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td class="action-buttons">
                                    <!-- Edit button -->
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn-action">
                                        <i class="fas fa-edit icon-edit"></i>
                                    </a>
                                    <!-- Delete button -->
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
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
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <!-- Modal for adding data -->
    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah User</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST" onsubmit="return confirm('Apakah yakin ingin menyimpan data ini?')">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="Karyawan">Karyawan Tetap</option>
                                <option value="Intern">Intern</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Apakah yakin ingin menghapus data ini?');
        }

        // Custom search function
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tabelUsers tbody tr');
            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                let found = false;
                for (let i = 0; i < cells.length - 1; i++) { // Exclude the last column (actions)
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