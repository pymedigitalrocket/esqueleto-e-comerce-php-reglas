<?php include_once("base.php"); ?>

<div class="container-lg">
    <h1 class="mx-5 my-4 fw-bold">Cambio de contrase単a</h1>
    <div class="mx-5">
        <form action="<?php print RUTA; ?>login/cambioClave/" method="POST">
            <div class="col-lg-4">
                <label for="clave" class="form-label text-dark fw-bold my-1">Cambiar Clave acceso:</label>
                <input type="password" class="form-control" name="clave1" id="clave1" placeholder="********">
            </div>
            <div class="col-lg-4">
                <label for="clave" class="form-label text-dark fw-bold my-1">Confirmar nueva Clave acceso:</label>
                <input type="password" class="form-control" name="clave2" id="clave2" placeholder="********">
            </div>
            <input type="hidden" name="id" value="<?php print $data['datas']; ?>"/>
            <div class="col-lg-4">
                <button type="submit" class="btn btn-primary mx-auto px-5 py-2 fw-bold my-2 me-1" value="Enviar">Cambiar clave</button>
            </div>
        </form>
    </div>
    <?php include_once("errores.php"); ?>
</div>