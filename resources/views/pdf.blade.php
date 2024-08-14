<!DOCTYPE html>
<html>

<head>
    <title>Histori Reminder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Histori Reminder</h2>
    <table>
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
                <td>{{ $index + 1 }}</td>
                <td>{{ $historiReminder->reminder->no_hp }}</td>
                <td>{{ $historiReminder->penerbangan->nomor_penerbangan }}</td>
                <td>{{ \Carbon\Carbon::parse($historiReminder->reminder->tgl_berangkat)->translatedFormat('d F Y') }}</td>
                <td>{{ $historiReminder->reminder->status_tiket }}</td>
                <td>{{ $historiReminder->reminder->ket_pesan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
