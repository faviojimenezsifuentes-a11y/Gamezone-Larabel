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

.checkout-box {
    background: linear-gradient(145deg, #141421, #0d0d14);
    border: 1px solid rgba(255,26,26,0.6);
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 0 24px rgba(255,26,26,0.15);
}

.table {
    border-color: rgba(255,255,255,0.15);
}

.btn-danger {
    background: #e9344f;
    border: none;
}

.btn-danger:hover {
    background: #ff1a3c;
}
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
  <h1 class="mb-4 fw-bold">Confirmar compra</h1>

  @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif

  <div class="checkout-box">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="mb-1">Resumen del pedido</h3>
        <p class="text-white-50 mb-0">Revisa tus juegos antes de pagar con Stripe.</p>
      </div>

      <span class="badge bg-danger fs-6">
        Pago seguro test
      </span>
    </div>

    <div class="table-responsive">
      <table class="table table-dark table-bordered align-middle">
        <thead>
          <tr>
            <th>Juego</th>
            <th class="text-center">Cantidad</th>
            <th class="text-end">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($carrito as $item)
            @continue(!is_array($item))
            <tr>
              <td>{{ $item['titulo'] }}</td>
              <td class="text-center">{{ $item['cantidad'] }}</td>
              <td class="text-end">
                S/ {{ number_format($item['precio'] * $item['cantidad'], 2) }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">

      <div class="text-end">
        <p class="text-white-50 mb-1">Total a pagar</p>
        <h2 class="fw-bold text-danger">
          S/ {{ number_format($total, 2) }}
        </h2>

        <form action="{{ route('pago.crearSesion') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-danger btn-lg mt-2" id="btn-pagar">
            <i class="bi bi-credit-card me-1"></i>
            Pagar con Stripe
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
const btnPagar = document.getElementById('btn-pagar');

if (btnPagar) {
  btnPagar.closest('form').addEventListener('submit', function () {
    btnPagar.disabled = true;
    btnPagar.innerText = 'Redirigiendo a Stripe...';
  });
}
</script>
</body>
</html>
