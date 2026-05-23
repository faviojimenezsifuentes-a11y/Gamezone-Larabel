<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Juegos | GameZone</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #0b0b0b;
    color: #fff;
}
.card-box {
    background: #111;
    border: 1px solid rgba(255,26,26,0.5);
    border-radius: 12px;
    padding: 24px;
}
</style>
</head>

<body>

<nav class="navbar navbar-dark bg-black border-bottom border-danger">
  <div class="container">
    <a class="navbar-brand fw-bold text-danger" href="{{ route('catalogo') }}">GameZone Admin</a>
    <a class="btn btn-outline-light btn-sm" href="{{ route('catalogo') }}">Volver al catálogo</a>
  </div>
</nav>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestión de juegos</h1>
    <a href="{{ route('admin.juegos.create') }}" class="btn btn-danger">Nuevo juego</a>
  </div>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card-box">
    <div class="table-responsive">
      <table class="table table-dark table-bordered align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Stock</th>
            <th style="width:180px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($juegos as $juego)
            <tr>
              <td>{{ $juego->id_juego }}</td>
              <td>{{ $juego->titulo }}</td>
              <td>{{ $juego->categoria }}</td>
              <td>S/ {{ number_format($juego->precio, 2) }}</td>
              <td>{{ $juego->stock }}</td>
              <td>
                <a href="{{ route('admin.juegos.edit', $juego->id_juego) }}" class="btn btn-warning btn-sm">
                  Editar
                </a>

                <form action="{{ route('admin.juegos.destroy', $juego->id_juego) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('¿Seguro que deseas eliminar este juego?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger btn-sm">Eliminar</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
