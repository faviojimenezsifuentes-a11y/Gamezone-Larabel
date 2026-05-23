<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Checkout | GameZone</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
}
</style>
</head>

<body>

<nav class="navbar navbar-dark bg-black border-bottom border-danger">
  <div class="container">
    <a class="navbar-brand fw-bold text-danger" href="{{ route('catalogo') }}">GameZone</a>
    <a class="btn btn-outline-light btn-sm" href="{{ route('carrito.index') }}">Volver al carrito</a>
  </div>
</nav>

<div class="container py-5">
  <h1 class="mb-4">Confirmar compra</h1>

  <div class="box">
    <h4>Resumen del pedido</h4>

    <table class="table table-dark table-bordered mt-3">
      <thead>
        <tr>
          <th>Juego</th>
          <th>Cantidad</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($carrito as $item)
          @continue(!is_array($item))
          <tr>
            <td>{{ $item['titulo'] }}</td>
            <td>{{ $item['cantidad'] }}</td>
            <td>S/ {{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="text-end">
      <h3>Total: S/ {{ number_format($total, 2) }}</h3>

      <form action="{{ route('pago.crearSesion') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-danger mt-3">
        Pagar con Stripe
      </button>
    </form>
        @csrf
        <button type="submit" class="btn btn-danger mt-3">
          Confirmar compra
        </button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
