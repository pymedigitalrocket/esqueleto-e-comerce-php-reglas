<?php include("base.php");?>

<div class="card container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Datos de envio</a></li>
            <li class="breadcrumb-item fw-bold">Forma de pago</li>
            <li class="breadcrumb-item"><a href="#">Verificar datos</a></li>
        </ol>
    </nav>
    <h2 class="fw-bold">Forma de pago</h2>
    <form action="<?php print RUTA; ?>carro/verificar" method="POST" class="text-left">
        <div class="radio"><label for="tc1"><input type="radio" name="pago" id="tc1" value="Tarjeta Credito Master Card">Tarjeta Credito Master Card</label></div>
        <div class="radio"><label for="tc2"><input type="radio" name="pago" id="tc2" value="Tarjeta Credito Visa">Tarjeta Credito Visa</label></div>
        <div class="radio"><label for="debito"><input type="radio" name="pago" id="debito" value="Tarjeta Debito">Tarjeta Debito</label></div>
        <div class="radio"><label for="efectivo"><input type="radio" name="pago" id="efectivo" value="Efectivo">Efectivo</label></div>
        <div class="radio"><label for="paypal"><input type="radio" name="pago" id="paypal" value="Paypal">Paypal</label></div>
        <div class="radio"><label for="bitcoin"><input type="radio" name="pago" id="bitcoin" value="Bitocoins">Bitocoins</label></div>
        <input type="submit" value="Enviar" class="btn btn-primary px-5 py-2 my-2 fw-bold">
    </form> 
</div>