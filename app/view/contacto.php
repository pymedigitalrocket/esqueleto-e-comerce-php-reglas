<?php include_once("base.php");?>

<div class="container-md">
    <h1 class="text-center my-4 fw-bold">Contacto</h1>
    <div class="card bg-light items-align-center">
        <div class="mx-5 my-3">
            <form method="POST" action="<?php print RUTA.'contacto/enviar'; ?>">
                <div class="form-group">
                    <label for="nombre" class="form-label text-dark fw-bold my-1">Nombre: *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Juan" required value='<?php isset($data["datas"]["nombre"])? print $data["datas"]["nombre"]:""; ?>'>
                </div>
                <div class="form-group">
                    <label for="correo" class="form-label text-dark fw-bold my-1">E-mail: *</label>
                    <input type="emal" name="correo" id="correo" class="form-control" placeholder="ejemplo@ejemplo.com" required value='<?php isset($data["datas"]["email"])? print $data["datas"]["email"]:""; ?>'>
                </div>
                <div class="form-group">
                    <label for="telefono" class="form-label text-dark fw-bold my-1">telefono: </label>
                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="+56912345678" value='<?php isset($data["datas"]["telefono"])? print $data["datas"]["telefono"]:""; ?>'>
                </div>
                <div class="form-group">
                    <label for="mensaje" class="form-label text-dark fw-bold my-1">Mensaje: *</label>
                    <textarea name="mensaje" id="mensaje" class="form-control"><?php isset($data["datas"]["mensaje"])? print $data["datas"]["mensaje"]:""; ?></textarea>
                </div>
                <input type="submit" value="Enviar" class="btn btn-primary px-5 py-2 mt-2 fw-bold">
            </form>
        </div>
    </div>
    <?php include("errores.php");?> 
</div>