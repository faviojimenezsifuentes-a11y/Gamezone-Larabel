<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Iniciar sesión | GameZone</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: radial-gradient(circle at top, #1b1b2f 0, #0b0b0d 60%, #050509 100%);
    color: white;
}
.login-card {
    background: linear-gradient(145deg,#1f1f2b,#151520);
    border-radius: 12px;
    padding: 30px;
    border: 1px solid rgba(255,255,255,0.05);
}
.login-card input {
    background: #2a2a3a;
    color: white;
    border: 1px solid #444;
}
.login-card input:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25);
}
.input-group-text {
    background: #2a2a3a;
    border: 1px solid #444;
    color: white;
}
a { text-decoration: none; }
</style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-danger">
  <div class="container">
    <a class="navbar-brand fw-bold text-danger" href="{{ route('catalogo') }}">GameZone</a>
  </div>
</nav>

<div class="container py-5" style="margin-top: 60px;">
  <div class="row justify-content-center">
    <div class="col-md-5">

      <div class="login-card shadow">
        <h3 class="text-center mb-4 fw-bold">
          <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar sesión
        </h3>

        @if ($errors->any())
          <div class="alert alert-danger text-center">
            {{ $errors->first() }}
          </div>
        @endif

        <form method="POST" action="{{ route('login.procesar') }}" novalidate>
          @csrf

          <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" class="form-control" name="password" required>
            </div>
          </div>

          <button type="submit" class="btn btn-danger w-100 mt-2">
            <i class="bi bi-door-open me-1"></i> Ingresar
          </button>

          <p class="mt-3 text-center text-white-50">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="text-warning fw-bold">Regístrate</a>
          </p>
        </form>
      </div>

    </div>
  </div>
</div>

</body>
</html>
