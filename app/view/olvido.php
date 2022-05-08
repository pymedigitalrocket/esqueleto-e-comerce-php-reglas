<?php include("base.php");?>

<div class="container-lg">
    <h1 class="mx-5 my-4 fw-bold"><?php print $data["subtitulo"]; ?></h1>
    <div class="mx-5">
        <form action="<?php print RUTA; ?>login/olvido/" method="POST">
            <div class="col-lg-6">
                <label for="email" class="form-label text-dark fw-bold my-1">Correo electronico: *</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="ejemplo@ejemplo.com" value='<?php isset($data["datas"]["email"])? print $data["datas"]["email"]:""; ?>' required>
            </div>
            <div class="col-lg-6">
                <button type="submit" class="btn btn-primary mx-auto px-5 py-2 fw-bold my-2 me-1" value="Enviar">Enviar</button>
            </div>
        </form>
        <p class="text-muted">Se te enviara un correo. Porfavor verifica tu bandeja de spam</p>
    </div>
    <?php include_once("errores.php"); ?>
</div>