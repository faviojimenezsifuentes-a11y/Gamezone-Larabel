<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Catálogo | GameZone</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<style>
:root {
    --gz-red: #ff1a1a;
    --gz-red-dark: #e60000;
}
body {
    background: radial-gradient(circle at top, #1b1b2f 0, #0b0b0b 60%, #050509 100%);
    color: #ffffff;
}
p, label, small, span, h1, h2, h3, h4, h5, h6 {
    color: #ffffff !important;
}
.text-white-50 {
    color: #ffffff !important;
}
header {
    margin-top: 70px;
    background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.95));
}
.form-control, .form-select {
    background-color: #1a1a1a;
    border: 1px solid #555;
    color: #ffffff !important;
}
.form-control::placeholder {
    color: #f8f9fa !important;
    opacity: 0.85;
}
.form-control:focus, .form-select:focus {
    border-color: #ff1a1a;
    box-shadow: 0 0 6px rgba(255,26,26,0.6);
}
.card {
    background: linear-gradient(145deg, #161623, #101018);
    border: 1px solid rgba(255,26,26,0.25);
    transition: transform .25s ease, box-shadow .25s ease, border .25s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 25px rgba(255,26,26,0.55);
    border-color: rgba(255,26,26,0.85);
}
.card h5, .card p {
    color: #ffffff !important;
}
footer {
    background: #000;
    border-top: 2px solid #ff1a1a;
    color: #eee;
}
footer a { color: #fff; transition: .3s; }
footer a:hover { color: #ff1a1a; }
#toast {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1055;
    display: none;
    min-width: 260px;
    border-radius: 6px;
}
</style>
</head>

<body id="page-top">

<nav class="navbar navbar-expand-lg navbar-dark bg-black fixed-top border-bottom border-danger">
  <div class="container">
    <a class="navbar-brand fw-bold text-danger" href="/">GameZone</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarGameZone">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarGameZone">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link" href="/catalogo">Catálogo</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/carrito">
            Carrito
            <span id="cart-count" class="badge bg-danger">
              {{ collect(session('carrito', []))->filter(fn($item) => is_array($item))->sum('cantidad') }}
            </span>
          </a>
        </li>

        @if (session('user'))
          <li class="nav-item">
            <span class="nav-link text-white">
              Hola, {{ session('user.nombre') }}
            </span>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="/mis-compras">Mis compras</a>
        </li>
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
              @csrf
              <button class="btn btn-outline-danger btn-sm" type="submit">Salir</button>
            </form>
          </li>
          @if (session('user.rol') === 'admin')
          <li class="nav-item">
            <a class="nav-link text-warning" href="/admin/juegos">
              Admin
            </a>
          </li>
        @endif
        @else
          <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/register">Registro</a>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>

<header class="py-5 text-center text-white">
  <div class="container" data-aos="fade-up">
    <h1 class="display-4 fw-bold">Catálogo de videojuegos</h1>
    <p class="lead">
      Explora nuestra colección y encuentra tu próximo juego favorito.
    </p>
  </div>
</header>

<section class="py-5 bg-dark">
  <div class="container px-4 px-lg-5 mt-4">
    <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-3 row-cols-xl-4 justify-content-center">

      @forelse ($juegos as $juego)
        @php
            $img = !empty($juego->imagen) ? $juego->imagen : 'assets/img/juegos/default.jpg';
        @endphp

        <div class="col mb-5" data-aos="zoom-in">
          <div class="card text-center h-100">

            <img class="card-img-top"
                 src="{{ asset($img) }}"
                 alt="{{ $juego->titulo }}"
                 style="height:220px;object-fit:cover;">

            <div class="card-body p-4">
              <h5 class="mb-1">{{ $juego->titulo }}</h5>
              <p class="fw-semibold mb-1">S/ {{ number_format($juego->precio, 2) }}</p>
              <small class="d-block text-white-50">
              Aprox. $ {{ number_format($juego->precio_dolares, 2) }} USD
            </small>
              <small>Licencia digital · Entrega inmediata</small>
            </div>

            <div class="card-footer bg-transparent border-0 pb-3">
              <div class="d-flex justify-content-center align-items-center">
                <input type="number"
                       class="form-control me-2"
                       id="qty-{{ $juego->id_juego }}"
                       value="1"
                       min="1"
                       style="width:80px;">

                <button class="btn btn-danger btn-sm px-3"
                        onclick="addToCart({{ $juego->id_juego }})">
                  <i class="bi bi-cart-plus me-1"></i> Añadir
                </button>
              </div>
            </div>

          </div>
        </div>
      @empty
        <p class="text-center fs-4">No hay juegos disponibles actualmente.</p>
      @endforelse

    </div>
  </div>
</section>

<div id="toast" class="toast align-items-center border-0" role="alert">
  <div class="d-flex">
    <div class="toast-body" id="toast-body"></div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="hideToast()"></button>
  </div>
</div>

<footer class="text-center py-4 mt-5">
  <div class="container">
    <div class="mb-3">
      <a href="#"><i class="bi bi-facebook fs-4 mx-1"></i></a>
      <a href="#"><i class="bi bi-instagram fs-4 mx-1"></i></a>
      <a href="#"><i class="bi bi-twitch fs-4 mx-1"></i></a>
      <a href="#"><i class="bi bi-discord fs-4 mx-1"></i></a>
    </div>
    <p class="mb-0 small">© 2025 GameZone — Todos los derechos reservados</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init();</script>

<script>
function showToast(msg, type = 'error') {
  const t = document.getElementById('toast');
  const body = document.getElementById('toast-body');

  if (type === 'success') {
    t.className = 'toast align-items-center text-white bg-success border-0';
    body.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>' + msg;
  } else {
    t.className = 'toast align-items-center text-white bg-danger border-0';
    body.innerHTML = '<i class="bi bi-x-circle-fill me-2"></i>' + msg;
  }

  t.style.display = 'flex';
  setTimeout(() => t.style.display = 'none', 2500);
}

function hideToast() {
  document.getElementById('toast').style.display = 'none';
}

function addToCart(id_juego) {
  const input = document.getElementById('qty-' + id_juego);
  const qty = input ? input.value : 1;
  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  if (qty <= 0) {
    showToast('Cantidad inválida');
    return;
  }

  fetch("/carrito/agregar", {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': token,
      'Accept': 'application/json'
    },
    body: JSON.stringify({
      id_juego: id_juego,
      cantidad: qty
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      showToast(data.message, 'success');

      const cartCount = document.getElementById('cart-count');
      if (cartCount) {
        cartCount.innerText = data.total_items;
      }
    } else {
      showToast(data.message || 'Error al agregar');
    }
  })
  .catch(() => {
    showToast('Error en la conexión');
  });
}
</script>

</body>
</html>
