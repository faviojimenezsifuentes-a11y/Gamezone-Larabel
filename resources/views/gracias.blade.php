<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gracias | GameZone</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #090909;
    color: #fff;
}
.box {
    max-width: 700px;
    margin: 120px auto;
    background: #111;
    border: 1px solid #dc3545;
    border-radius: 12px;
    padding: 40px;
    text-align: center;
}
</style>
</head>

<body>

<div class="box">
  <h1 class="text-danger mb-3">¡Gracias por tu compra!</h1>
  <p class="lead">Tu pedido fue registrado correctamente.</p>

  <a href="{{ route('catalogo') }}" class="btn btn-danger mt-3">
    Volver al catálogo
  </a>
</div>

</body>
</html>
