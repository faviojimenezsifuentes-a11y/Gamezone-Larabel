<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mis compras | GameZone</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: radial-gradient(circle at top, #1b1b2f 0, #0b0b0b 60%, #050509 100%);
    color: #fff;
}
.box {
    background: #111;
    border: 1px solid rgba(255,26,26,0.5);
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 25px;
}
.table {
    margin-bottom: 0;
}
</style>
</head>

<body>

<nav class="navbar navbar-dark bg-black border-bottom border-danger">
  <div class="container">
    <a class="navbar-brand fw-bold text-danger" href="{{ route('catalogo') }}">GameZone</a>
    <a class="btn btn-outline-light btn-sm" href="{{ route('catalogo') }}">Volver al catálogo</a>
  </div>
</nav>

<div class="container py-5">
  <h1 class="mb-4">
    <i class="bi bi-bag-check me-2"></i> Mis compras
  </h1>

  @if ($pedidos->count() > 0)

    @foreach ($pedidos as $pedido)
      <div class="box">
        <div class="d-flex justify-content-between flex-wrap mb-3">
          <div>
            <h4 class="text-danger mb-1">Pedido #{{ $pedido->id_pedido }}</h4>
            <p class="mb-0">Fecha: {{ $pedido->fecha_pedido }}</p>
            <p class="mb-0">Método: {{ $pedido->metodo_pago }}</p>
            <p class="mb-0">Estado: {{ $pedido->estado }}</p>
          </div>

          <div class="text-end">
            <h4>Total: S/ {{ number_format($pedido->total, 2) }}</h4>
            <small>Referencia: {{ $pedido->referencia_pago }}</small>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-dark table-bordered align-middle">
            <thead>
              <tr>
                <th>Juego</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pedido->detalles as $detalle)
                <tr>
                  <td>{{ $detalle->titulo }}</td>
                  <td>{{ $detalle->cantidad }}</td>
                  <td>S/ {{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @endforeach

  @else
    <div class="alert alert-warning">
      Todavía no tienes compras registradas.
    </div>
  @endif
</div>

</body>
</html>
