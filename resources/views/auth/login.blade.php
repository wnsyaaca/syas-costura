<x-guest-layout>

    <h2 class="auth-heading">Welcome Back</h2>

    <p class="auth-description">
        Masuk kembali dan lanjutkan perjalanan fashion-mu bersama kami.
    </p>

    <x-auth-session-status
        class="mb-4"
        :status="session('status')"
    />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="auth-field">
            <label for="email" class="auth-label">Email Address</label>

            <input
                id="email"
                class="auth-input"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Masukkan email kamu"
                required
                autofocus
                autocomplete="username"
            >

            @if ($errors->get('email'))
                <div class="auth-error">
                    @foreach ($errors->get('email') as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="auth-field">
            <label for="password" class="auth-label">Password</label>

            <input
                id="password"
                class="auth-input"
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
                autocomplete="current-password"
            >

            @if ($errors->get('password'))
                <div class="auth-error">
                    @foreach ($errors->get('password') as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; gap:10px; flex-wrap:wrap;">

            <label for="remember_me" class="remember-label">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                >
                Remember me
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">
                    Forgot password?
                </a>
            @endif

        </div>

        <button type="submit" class="auth-button">
            SIGN IN
        </button>
    </form>

    <div class="auth-divider"></div>

    <p style="text-align:center; color:#806B57; font-size:13px;">
        Don't have an account?
        <a href="{{ route('register') }}" class="auth-link" style="font-weight:700;">
            Create Account
        </a>
    </p>

</x-guest-layout>