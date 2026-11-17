<x-guest-layout>

    <h2 class="auth-heading">Create Account</h2>

    <p class="auth-description">
        Bergabunglah dengan Sya's Costura dan wujudkan gaya yang mencerminkan dirimu.
    </p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="auth-field">
            <label for="name" class="auth-label">Full Name</label>

            <input
                id="name"
                class="auth-input"
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Masukkan nama lengkap"
                required
                autofocus
                autocomplete="name"
            >

            @if ($errors->get('name'))
                <div class="auth-error">
                    @foreach ($errors->get('name') as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="auth-field">
            <label for="email" class="auth-label">Email Address</label>

            <input
                id="email"
                class="auth-input"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Masukkan email aktif"
                required
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
                placeholder="Buat password"
                required
                autocomplete="new-password"
            >

            @if ($errors->get('password'))
                <div class="auth-error">
                    @foreach ($errors->get('password') as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="auth-field">
            <label for="password_confirmation" class="auth-label">
                Confirm Password
            </label>

            <input
                id="password_confirmation"
                class="auth-input"
                type="password"
                name="password_confirmation"
                placeholder="Ulangi password"
                required
                autocomplete="new-password"
            >

            @if ($errors->get('password_confirmation'))
                <div class="auth-error">
                    @foreach ($errors->get('password_confirmation') as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <button type="submit" class="auth-button">
            CREATE ACCOUNT
        </button>
    </form>

    <div class="auth-divider"></div>

    <p style="text-align:center; color:#806B57; font-size:13px;">
        Already have an account?
        <a href="{{ route('login') }}" class="auth-link" style="font-weight:700;">
            Sign In
        </a>
    </p>

</x-guest-layout>