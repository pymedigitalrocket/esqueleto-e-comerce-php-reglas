<?php include("base.php");?>

<div class="container-lg">
    <h1 class="mx-5 my-4 fw-bold">Login</h1>
    <div class="card bg-light items-align-center">
        <div class="mx-5 my-3">
            <form action="<?php print RUTA; ?>login/verifica/" method="POST">
                <label for="email" class="form-label text-dark fw-bold my-1">Correo electronico:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="ejemplo@ejemplo.com" value='<?php isset($data["datas"]["email"])? print $data["datas"]["email"]:""; ?>'>

                <label for="clave" class="form-label text-dark fw-bold my-1">Clave acceso:</label>
                <input type="password" class="form-control" name="clave" id="clave" placeholder="********">

                <button type="submit" class="btn btn-primary mx-auto px-5 py-2 fw-bold my-2 me-1">Login</button>
                
                <input type="checkbox" name="recordar" 
                <?php
                    if(isset($data["datas"]["recordar"])){
                        if($data["datas"]["recordar"]) print "checked";
                    }
                ?> id="recordar">
                <label for="recordar" class="for-label">Recordar</label>
            </form>
            <a href="<?php print RUTA; ?>login/registro/">Registrarse</a>
            <a href="<?php print RUTA; ?>login/olvido/" class="mx-1">¿olvidaste tu clave de acceso?</a>
        </div>
    </div>
    <?php include_once("errores.php"); ?>
</div>