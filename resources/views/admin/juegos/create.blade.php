<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Crear Juego | GameZone</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#0b0b0b; color:#fff; }
.form-box {
    background:#111;
    border:1px solid rgba(255,26,26,0.5);
    border-radius:12px;
    padding:24px;
}
.form-control {
    background:#1a1a1a;
    color:#fff;
    border:1px solid #555;
}
.form-control:focus {
    background:#1a1a1a;
    color:#fff;
}
</style>
</head>

<body>

<nav class="navbar navbar-dark bg-black border-bottom border-danger">
  <div class="container">
    <a class="navbar-brand fw-bold text-danger" href="{{ route('admin.juegos.index') }}">GameZone Admin</a>
  </div>
</nav>

<div class="container py-5">
  <h1 class="mb-4">Crear juego</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      {{ $errors->first() }}
    </div>
  @endif

  <div class="form-box">
    <form action="{{ route('admin.juegos.store') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Precio</label>
        <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio') }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Categoría</label>
        <input type="text" name="categoria" class="form-control" value="{{ old('categoria') }}">
      </div>

      <div class="mb-3">
        <label class="form-label">Imagen</label>
        <input type="text" name="imagen" class="form-control" value="{{ old('imagen') }}" placeholder="assets/img/juegos/imagen.png">
      </div>

      <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control" value="{{ old('stock', 10) }}" required>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-danger">Guardar</button>
        <a href="{{ route('admin.juegos.index') }}" class="btn btn-outline-light">Cancelar</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>
