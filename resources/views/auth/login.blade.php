<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>

    @vite('resources/css/login.css')
</head>

<body>
    <div class="block-1">
        <img src="{{ Vite::asset('resources/img/login/logo.webp') }}" alt="Logo">
    </div>

    <div class="block-2">
        <div class="card">
            <div>
                <img src="{{ Vite::asset('resources/img/login/creditos.webp') }}" alt="creditos">
                <p>Créditos Rápidos</p>
            </div>
            <div>
                <img src="{{ Vite::asset('resources/img/login/pagos.webp') }}" alt="pagos">
                <p>Pagos Rápidos</p>
            </div>
            <div>
                <img src="{{ Vite::asset('resources/img/login/prestamos.webp') }}" alt="prestamos">
                <p>Préstamos sin intereses</p>
            </div>
            <div>
                <img src="{{ Vite::asset('resources/img/login/seguridad.webp') }}" alt="seguridad">
                <p>Máxima Seguridad</p>
            </div>
        </div>

        <div class="card-2">
            <div class="">
                <div class="">
                    <p>Sistema de Entidad Financiera</p>
                </div>
                <div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                autocomplete="username">
                            @error('email')
                                <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password">
                            @error('password')
                                <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div>
                            <div>
                                <div>
                                    <img src="{{ Vite::asset('resources/img/login/google.webp') }}" alt="google">
                                    <a href="">Iniciar Sesión Google</a>
                                </div>
                                <div>
                                    <img src="{{ Vite::asset('resources/img/login/github.webp') }}" alt="github">
                                    <a href="">Iniciar Sesión GitHub</a>
                                </div>
                            </div>
                            <button type="submit">Log in</button>
                        </div>
                    </form>
                </div>
            </div>
            <div>
                <img src="{{ Vite::asset('resources/img/login/logo 2.webp') }}" alt="logo 2">
            </div>
        </div>

        <div>

        </div>
    </div>




</body>

</html>