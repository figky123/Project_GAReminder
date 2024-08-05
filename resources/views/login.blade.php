<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login GAReminder</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/util.css') }}">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container-login100 {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
            min-height: 100vh;
            background: #ffffff;
        }

        .wrap-login100 {
            width: 100%;
            max-width: 960px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
        }

        .login100-more {
            width: 50%;
            background-size: cover;
            background-position: center;
            background-image: url('{{ url('assets/images/shutterstock_1810694941.jpg')}}');
        }

        .login-form {
            width: 50%;
            padding: 50px 30px;
            background-color: #ffffff;
        }

        .login-form-title {
            font-size: 30px;
            color: #005bac;
            /* Garuda Blue */
            text-align: center;
            margin-bottom: 40px;
            font-weight: 700;
        }

        .form-welcome h1 {
            font-size: 24px;
            color: #005bac;
            /* Garuda Blue */
            margin-bottom: 10px;
            text-align: center;
        }

        .form-welcome h4 {
            font-size: 16px;
            color: #007dc5;
            /* Garuda Lighter Blue */
            margin-bottom: 30px;
            text-align: center;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            font-size: 16px;
            color: #666;
            display: block;
            margin-bottom: 5px;
        }

        .input-group input {
            font-size: 16px;
            line-height: 1.2;
            color: #333;
            display: block;
            width: 100%;
            background: #e6e6e6;
            height: 50px;
            border-radius: 5px;
            padding: 0 20px;
            border: 1px solid #ccc;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #005bac;
            /* Garuda Blue */
        }

        .form-checkbox {
            display: flex;
            align-items: center;
        }

        .form-checkbox input {
            margin-right: 10px;
        }

        .form-checkbox label {
            font-size: 14px;
            color: #333;
        }

        .form-actions {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .form-actions button {
            font-size: 16px;
            color: #fff;
            background: #005bac;
            /* Garuda Blue */
            border-radius: 5px;
            padding: 10px 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            outline: none;
            margin: 5px;
            width: 100%;
            /* Full-width button */
        }

        .form-actions button:hover {
            background: #007dc5;
            /* Garuda Lighter Blue */
        }

        .forgot-password {
            font-size: 14px;
            color: #005bac;
            /* Garuda Blue */
            text-align: center;
            text-decoration: none;
            display: block;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container-login100">
        <div class="wrap-login100">
            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-welcome">
                    <h1>Selamat Datang di <b>GAReminder</b></h1>
                    <h4>Didukung Oleh Whatsapp Messenger API</h4>
                </div>
                <p>Silahkan Masuk Dengan Identitas Anda</p>

                <div class="input-group">
                    <label for="email">Email / Kode Agen</label>
                    <input type="text" name="email" id="email" value="{{ old('email') }}">
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                </div>

                <div class="form-checkbox">
                    <input type="checkbox" id="ckb1" name="remember">
                    <label for="ckb1">Ingatkan Saya</label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger" style="margin-top: 20px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>

            <div class="login100-more"></div>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/countdowntime/countdowntime.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
