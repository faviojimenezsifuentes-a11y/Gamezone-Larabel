<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Carrito | GameZone</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: radial-gradient(circle at top, #1b1b2f 0, #0b0b0b 60%, #050509 100%);
    color: #fff;
}
.table {
    border: 1px solid rgba(255,26,26,0.4);
}
.card-box {
    background: #111;
    border: 1px solid rgba(255,26,26,0.5);
    border-radius: 10px;
    padding: 24px;
}
</style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-danger">
  <div class="container">
    <a class="navbar-brand fw-bold text-danger" href="{{ route('catalogo') }}">GameZone</a>
    <div>
      <a class="btn btn-outline-light btn-sm" href="{{ route('catalogo') }}">Volver al catálogo</a>
    </div>
  </div>
</nav>

<div class="container py-5">
  <h1 class="mb-4">Mi carrito</h1>

  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if (!empty($carrito) && count($carrito)>0)
    @php
      $total = 0;
    @endphp

    <div class="card-box">
      <div class="table-responsive">
        <table class="table table-dark table-bordered align-middle">
          <thead>
            <tr>
              <th>Juego</th>
              <th>Precio</th>
              <th style="width: 180px;">Cantidad</th>
              <th>Subtotal</th>
              <th style="width: 130px;">Acción</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($carrito as $item)
            @continue(!is_array($item))
              @php
                $subtotal = $item['precio'] * $item['cantidad'];
                $total += $subtotal;
              @endphp

              <tr>
                <td>{{ $item['titulo'] }}</td>
                <td>S/ {{ number_format($item['precio'], 2) }}</td>
                <td>
                  <form action="{{ route('carrito.actualizar') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="hidden" name="id_juego" value="{{ $item['id_juego'] }}">
                    <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" class="form-control form-control-sm">
                    <button class="btn btn-warning btn-sm" type="submit">
                      <i class="bi bi-arrow-clockwise"></i>
                    </button>
                  </form>
                </td>
                <td>S/ {{ number_format($subtotal, 2) }}</td>
                <td>
                  <form action="{{ route('carrito.eliminar', $item['id_juego']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit">
                      <i class="bi bi-trash"></i> Quitar
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-4">
        <form action="{{ route('carrito.vaciar') }}" method="POST">
          @csrf
          @method('DELETE')
          <button class="btn btn-outline-danger">
            Vaciar carrito
          </button>
        </form>

        <div class="text-end">
          <h3>Total: S/ {{ number_format($total, 2) }}</h3>
          <a href="{{ route('checkout') }}" class="btn btn-danger mt-2">
          Continuar compra
        </a>
        </div>
      </div>
    </div>
  @else
    <div class="alert alert-warning">
      Tu carrito está vacío.
    </div>
  @endif
</div>

</body>
</html>
