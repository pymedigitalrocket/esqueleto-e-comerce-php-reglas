<?php include("base.php");?>

<div class="card container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Datos de envio</a></li>
            <li class="breadcrumb-item"><a href="#">Forma de pago</a></li>
            <li class="breadcrumb-item fw-bold">Verificar datos</li>
        </ol>
    </nav>
    <p class="lead fw-bold"><?php print $data["datas"]["nombre"]." gracias por su compra. Estamos contentos de que haya encontrado lo que buscaba. Nuestro objetivo es que siempre este satisfecho. Esperamos volver a verle pronto. Que tenga un gran dia";?></p>
    <br>
    <h3>Atentamente: Sus amigos de Tienda Virtual</h3>
</div>
<a href="<?php print RUTA; ?>tienda" class="btn btn-primary px-5 py-2 mx-5 fw-bold">Regresar</a>