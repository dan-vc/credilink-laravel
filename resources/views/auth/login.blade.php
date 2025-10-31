<!DOCTYPE html>
<html lang="pe">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>

    @vite('resources/css/login.css')
</head>

<body>



    <header class="block-1">
        <img src="{{ asset('img/login/logo.webp') }}" alt="Logo">
    </header>

    <section class="block-2">
        <div class="card">
            <div>
                <img src="{{ asset('img/login/creditos.webp') }}" alt="creditos">
                <p>Créditos Rápidos</p>
            </div>
            <div>
                <img src="{{ asset('img/login/pagos.webp') }}" alt="pagos">
                <p>Pagos Rápidos</p>
            </div>
            <div>
                <img src="{{ asset('img/login/prestamos.webp') }}" alt="prestamos">
                <p>Préstamos sin intereses</p>
            </div>
            <div>
                <img src="{{ asset('img/login/seguridad.webp') }}" alt="seguridad">
                <p>Máxima Seguridad</p>
            </div>
        </div>

        <div class="card-2">
            <div class="form">
                <div>
                    <h1>Sistema de Entidad Financiera</p>
                </div>
                <div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email">Correo</label><br>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autofocus autocomplete="username">
                            @error('email')
                                <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div><br><br>

                        <!-- Password -->
                        <div>
                            <label for="password">Contraseña</label><br>
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password">
                            @error('password')
                                <div style="color: red;">{{ $message }}</div>
                            @enderror
                            @if (session('error'))
                                <div style="color: red;">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                        <br><br>
                        <!-- Submit -->
                        <div class="buttons">
                            <div class="buttons-social">
                                <a href="{{ route('auth.google') }}" class="button-google">
                                    <img src="{{ asset('img/login/google.webp') }}" alt="google">
                                    <p>Iniciar Sesión Google</p>
                                </a>
                                <a href="{{ route('auth.github') }}" class="button-github">
                                    <img src="{{ asset('img/login/github.webp') }}" alt="github">
                                    <p>Iniciar Sesión GitHub</p>
                                </a>
                            </div>
                            <div class="button-submit">
                                <button type="submit">
                                    Entrar
                                    <img src="{{ asset('img/login/entrar.webp') }}" alt="entrar">

                                </button>
                            </div>
                        </div>
                        @error('social_errors')
                            <div style="color: red; margin-top: .5rem;">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>
            <div class="card-img">
                <img src="{{ asset('img/login/imagen.webp') }}" alt="imagen">
                <img src="{{ asset('img/login/logo 2.webp') }}" alt="logo 2">
            </div>
        </div>

        <div class="line">

        </div>
    </section>
</body>

</html>
