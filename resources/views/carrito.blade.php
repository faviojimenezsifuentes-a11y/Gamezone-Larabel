<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Carrito | GameZone</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: radial-gradient(circle at top, #1b1b2f 0, #0b0b0b 60%, #050509 100%);
    color: #fff;
}

.navbar {
    border-bottom: 1px solid #dc3545;
}

.card-box {
    background: linear-gradient(145deg, #141421, #0d0d14);
    border: 1px solid rgba(255,26,26,0.6);
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 0 24px rgba(255,26,26,0.12);
}

.table {
    border: 1px solid rgba(255,26,26,0.4);
}

.table th {
    color: #fff;
}

.form-control {
    background-color: #15151f !important;
    color: #ffffff !important;
    border: 1px solid #555 !important;
}

.form-control:focus {
    background-color: #15151f !important;
    color: #ffffff !important;
    border-color: #ff1a1a !important;
    box-shadow: 0 0 8px rgba(255,26,26,0.6) !important;
}

input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    opacity: 1;
    filter: invert(1);
}

.total-box {
    background: #0b0b0f;
    border: 1px solid rgba(255,26,26,0.4);
    border-radius: 14px;
    padding: 20px;
}

#toast-carrito {
    z-index: 9999;
    min-width: 280px;
}
</style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-black">
  <div class="container">
    <a class="navbar-brand fw-bold text-danger" href="/catalogo">GameZone</a>

    <div>
      <a class="btn btn-outline-light btn-sm" href="/catalogo">
        Volver al catálogo
      </a>
    </div>
  </div>
</nav>

<div class="container py-5">
  <h1 class="mb-4 fw-bold">Mi carrito</h1>

  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif

  @if (!empty($carrito) && count($carrito) > 0)
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
              <th style="width: 140px;">Cantidad</th>
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

                <td>
                  S/ {{ number_format($item['precio'], 2) }}
                </td>

                <td>
                  <input type="number"
                         class="form-control form-control-sm cantidad-carrito"
                         value="{{ $item['cantidad'] }}"
                         min="1"
                         data-id="{{ $item['id_juego'] }}"
                         style="width:90px;">
                </td>

                <td id="subtotal-{{ $item['id_juego'] }}">
                  S/ {{ number_format($subtotal, 2) }}
                </td>

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

      <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
        <form action="{{ route('carrito.vaciar') }}" method="POST">
          @csrf
          @method('DELETE')
          <button class="btn btn-outline-danger" type="submit">
            Vaciar carrito
          </button>
        </form>

        <div class="total-box text-end">
          <p class="text-white-50 mb-1">Total del carrito</p>

          <h3 class="fw-bold text-danger">
            S/ <span id="total-carrito">{{ number_format($total, 2) }}</span>
          </h3>

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

<div id="toast-carrito"
     class="alert position-fixed top-0 end-0 m-3 d-none">
</div>

<script>
function mostrarToastCarrito(mensaje, tipo = 'danger') {
  const toast = document.getElementById('toast-carrito');

  toast.className = 'alert alert-' + tipo + ' position-fixed top-0 end-0 m-3';
  toast.style.zIndex = '9999';
  toast.innerText = mensaje;

  setTimeout(() => {
    toast.className = 'alert position-fixed top-0 end-0 m-3 d-none';
  }, 2500);
}

document.querySelectorAll('.cantidad-carrito').forEach(input => {
  input.addEventListener('change', async function () {
    const idJuego = this.dataset.id;
    const cantidadAnterior = this.defaultValue;
    const cantidadNueva = parseInt(this.value, 10);
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (!cantidadNueva || cantidadNueva < 1) {
      this.value = cantidadAnterior;
      mostrarToastCarrito('La cantidad debe ser mayor a 0.');
      return;
    }

    try {
      const response = await fetch('/carrito/actualizar', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token,
          'Accept': 'application/json'
        },
        body: JSON.stringify({
          id_juego: idJuego,
          cantidad: cantidadNueva
        })
      });

      const data = await response.json();

      if (!response.ok || !data.success) {
        this.value = cantidadAnterior;
        mostrarToastCarrito(data.message || 'No se pudo actualizar la cantidad.');
        return;
      }

      this.defaultValue = cantidadNueva;

      const subtotal = document.getElementById('subtotal-' + idJuego);
      const total = document.getElementById('total-carrito');

      if (subtotal) {
        subtotal.innerText = 'S/ ' + data.subtotal;
      }

      if (total) {
        total.innerText = data.total;
      }

      mostrarToastCarrito(data.message, 'success');
    } catch (error) {
      this.value = cantidadAnterior;
      mostrarToastCarrito('Error en la conexión.');
    }
  });
});
</script>

</body>
</html>
