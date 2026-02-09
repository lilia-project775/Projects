<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom CSS -->
    <style>
        body {
            /* background: linear-gradient(135deg, #007bff 0%, #6610f2 100%); */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: none;
            text-align: center;
            font-size: 1.6rem;
            font-weight: 600;
            color: #333;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #ccc;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.15rem rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 500;
            background: linear-gradient(135deg, #007bff, #6610f2);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0056b3, #520dc2);
            transform: translateY(-2px);
        }

        .btn-link {
            color: #6610f2;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
        }

        label {
            font-weight: 500;
        }
    </style>
</head>

<body> 
    <div class="login-container">
        <div class="card">
            <div class="card-header">{{ __('Sign In') }}</div>

            <div class="card-body p-4">

                @if (session('registration_status'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('registration_status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif



                <form method="POST" action="{{ route('user.login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror @if (session('emailError')) is-invalid @endif"
                            name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        @if (session('emailError'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ session('emailError') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror @if (session('passwordError')) is-invalid @endif"
                            name="password" autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        @if (session('passwordError'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ session('passwordError') }}</strong>
                            </span>
                        @endif


                    </div>

                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    <div class="text-center align-items-center">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Sign In') }}
                        </button>
                    </div> 

                    <!--<div class="text-center mt-3">-->

                    <!--    <a class="btn-link text-dark" href="{{ route('register') }}">-->
                    <!--        {{ __("Don't have an account? Register") }}-->
                    <!--    </a>-->

                    <!--</div>-->
                    <div class="text-center mt-1">
                        @if (Route::has('password.request'))
                            <a class="btn-link text-dark" href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
