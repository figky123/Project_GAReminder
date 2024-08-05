@extends('master')
@section('navbar-title', 'Edit User')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .btn-back {
            margin-bottom: 20px;
        }
        .form-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            border-radius: 4px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-back"><i class="fas fa-arrow-left"></i> Back</a>
                    <div class="form-container">
                        <form id="editUserForm" action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="Karyawan" {{ $user->role == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                                    <option value="Intern" {{ $user->role == 'Intern' ? 'selected' : '' }}>Intern</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" onclick="return confirmUpdate()">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  

    <script>
        function confirmUpdate() {
            return confirm('Apakah yakin ingin menyimpan perubahan ini?');
        }
    </script>
</body>
</html>
@endsection
