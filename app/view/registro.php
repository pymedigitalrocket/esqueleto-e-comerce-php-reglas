<?php include_once("base.php"); ?>

<div class="container-lg">
    <h1 class="mx-5 my-4 fw-bold">Registro</h1>
    <div class="card bg-light items-align-center">
        <div class="mx-5 my-3">
            <form action="<?php print RUTA; ?>login/registro/" method="POST">
                <label for="nombre" class="form-label text-dark fw-bold my-1">Nombre: *</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Juan" 
                required value='<?php isset($data["datas"]["nombre"])? print $data["datas"]["nombre"]:""; ?>'/>
                
                <label for="apellidoPaterno" class="form-label text-dark fw-bold my-1">Apellido Paterno: *</label>
                <input type="text" class="form-control" name="apellidoPaterno" id="apellidoPaterno" placeholder="Perez" required 
                value='<?php isset($data["datas"]["apellidoPaterno"])? print $data["datas"]["apellidoPaterno"]:""; ?>'>

                <label for="apellidoMaterno" class="form-label text-dark fw-bold my-1">Apellido Materno:</label>
                <input type="text" class="form-control" name="apellidoMaterno" id="apellidoMaterno" placeholder="Gonzales" 
                value='<?php isset($data["datas"]["apellidoMaterno"])? print $data["datas"]["apellidoMaterno"]:""; ?>'>

                <label for="email" class="form-label text-dark fw-bold my-1">Correo electronico: *</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="ejemplo@ejemplo.com" required 
                value='<?php isset($data["datas"]["email"])? print $data["datas"]["email"]:""; ?>'>

                <label for="direccion" class="form-label text-dark fw-bold my-1">Direccion: *</label>
                <input type="text" class="form-control" name="direccion" id="direccion" placeholder="avenida siempre viva" required 
                value='<?php isset($data["datas"]["direccion"])? print $data["datas"]["direccion"]:""; ?>'>

                <label for="telefono" class="form-label text-dark fw-bold my-1">Telefono: *</label>
                <input type="text" class="form-control" name="telefono" id="telefono" placeholder="+56912345678" required 
                value='<?php isset($data["datas"]["telefono"])? print $data["datas"]["telefono"]:""; ?>'>

                <label for="clave1" class="form-label text-dark fw-bold my-1">Clave de acceso: *</label>
                <input type="password" class="form-control" name="clave1" id="clave1" placeholder="********" required>

                <label for="clave2" class="form-label text-dark fw-bold my-1">Confirme su clave de acceso: *</label>
                <input type="password" class="form-control" name="clave2" id="clave2" placeholder="********" required>

                <button type="submit" class="btn btn-primary mx-auto px-5 py-2 fw-bold my-2 me-1">Enviar Datos</button>
            </form>
        </div>
    </div>
    <?php include_once("errores.php"); ?>
</div>