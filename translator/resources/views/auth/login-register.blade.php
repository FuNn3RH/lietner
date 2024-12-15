<!DOCTYPE html>
<html>

<head>
    <title>{{ __('Register') }} / {{ __('Login') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/login.css') }}">
</head>

<body>
    <div class="main">

        @if (session('error'))
            <h3 style="width: 101%;display: block;text-align: center;">
                {{ session('error') }}
            </h3>
        @endif

        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="signup">
            <form action="{{ route('register-request') }}" method="POST">
                @csrf
                <label for="chk" aria-hidden="true">{{ __('Sign up') }}</label>
                <input type="text" name="username" placeholder="{{ __('Username') }}" required>
                <input type="email" name="email" placeholder="{{ __('Email') }}" required>
                <input type="password" name="password" placeholder="{{ __('Password') }}" required>
                <button>{{ __('Sign up') }}</button>
            </form>
        </div>

        <div class="login">
            <form action="{{ route('login-request') }}" method="POST">
                @csrf
                <label for="chk" aria-hidden="true">{{ __('Login') }}</label>
                <input type="email" name="email" placeholder="{{ __('Email') }}" required>
                {{-- <input type="password" name="password" placeholder="{{ __('Password') }}" required> --}}
                <button>{{ __('Login') }}</button>
            </form>
        </div>
    </div>
</body>

</html>
