<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ Route::is('login') ? 'Login' : 'Register' }} | Sya's Costura
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            background: #F7F4EE;
            color: #292522;
        }

        .auth-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
        }

        .auth-visual {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background: #665246;
        }

        .auth-visual img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .auth-visual::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(41, 37, 34, 0.05),
                rgba(41, 37, 34, 0.72)
            );
        }

        .visual-content {
            position: absolute;
            z-index: 2;
            left: 9%;
            right: 9%;
            bottom: 10%;
            color: #fff;
        }

        .visual-content .eyebrow {
            font-size: 11px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #E6DED2;
            margin-bottom: 18px;
        }

        .visual-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(38px, 5vw, 65px);
            line-height: 1.1;
            font-weight: 500;
            margin: 0;
        }

        .visual-content p {
            max-width: 390px;
            margin-top: 18px;
            color: #F7F4EE;
            line-height: 1.8;
            font-size: 14px;
        }

        .auth-panel {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 55px 9%;
            background: #F7F4EE;
        }

        .auth-content {
            width: 100%;
            max-width: 440px;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 25px;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #665246;
        }

        .brand-caption {
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #A1876C;
            margin-top: 5px;
        }

        .auth-heading {
            font-family: 'Playfair Display', serif;
            font-size: 38px;
            line-height: 1.2;
            font-weight: 500;
            color: #292522;
            margin-top: 48px;
        }

        .auth-description {
            color: #806B57;
            font-size: 14px;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .auth-label {
            display: block;
            color: #665246;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 9px;
        }

        .auth-input {
            display: block;
            width: 100%;
            border: 1px solid #DED5C9;
            border-radius: 9px;
            padding: 14px 15px;
            background: #FFFEFC;
            color: #292522;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            outline: none;
            transition: 0.2s;
        }

        .auth-input:focus {
            border-color: #806B57;
            box-shadow: 0 0 0 3px rgba(161, 135, 108, 0.12);
        }

        .auth-input::placeholder {
            color: #B4A99B;
        }

        .auth-field {
            margin-bottom: 21px;
        }

        .auth-button {
            display: block;
            width: 100%;
            border: none;
            border-radius: 9px;
            background: #665246;
            color: white;
            padding: 15px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 1px;
            cursor: pointer;
            transition: 0.25s;
        }

        .auth-button:hover {
            background: #292522;
            transform: translateY(-1px);
        }

        .auth-link {
            color: #806B57;
            text-decoration: none;
            font-size: 13px;
        }

        .auth-link:hover {
            color: #292522;
            text-decoration: underline;
        }

        .auth-error {
            color: #B04444;
            font-size: 12px;
            margin-top: 7px;
        }

        .auth-divider {
            height: 1px;
            background: #E6DED2;
            margin: 27px 0;
        }

        .auth-footer {
            color: #A1876C;
            font-size: 11px;
            text-align: center;
            margin-top: 35px;
            letter-spacing: 0.5px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 13px;
            color: #806B57;
        }

        .remember-label input {
            accent-color: #665246;
            width: 15px;
            height: 15px;
        }

        @media (max-width: 800px) {
            .auth-shell {
                grid-template-columns: 1fr;
            }

            .auth-visual {
                min-height: 230px;
                height: 230px;
            }

            .visual-content {
                left: 7%;
                bottom: 9%;
            }

            .visual-content h1 {
                font-size: 35px;
            }

            .visual-content p {
                display: none;
            }

            .visual-content .eyebrow {
                margin-bottom: 9px;
            }

            .auth-panel {
                min-height: auto;
                padding: 45px 7%;
            }

            .auth-heading {
                margin-top: 35px;
                font-size: 33px;
            }
        }
    </style>
</head>

<body>

    <main class="auth-shell">

        <section class="auth-visual">
            <img
                src="{{ asset('images/atelier-costura.png') }}"
                alt="Sya's Costura Fashion Atelier"
            >

            <div class="visual-content">
                <div class="eyebrow">Sya's Costura · Est. Atelier</div>

                <h1>
                    The Art of<br>
                    Tailoring.
                </h1>

                <p>
                    Every stitch tells a story. Discover the beauty of
                    custom-made fashion, crafted with care and made for you.
                </p>
            </div>
        </section>

        <section class="auth-panel">
            <div class="auth-content">

                <a href="{{ route('home') }}" style="text-decoration:none;">
                    <div class="brand-name">Sya's Costura</div>
                    <div class="brand-caption">Timeless Luxury Atelier</div>
                </a>

                {{ $slot }}

                <div class="auth-footer">
                    © {{ date('Y') }} Sya's Costura. Made with care.
                </div>

            </div>
        </section>

    </main>

</body>
</html>