<?php include("base.php");?>

<div class="container-md">
    <h1 class="text-center my-4 fw-bold"><?php
        if(isset($data["subtitulo"])) {
            print $data["subtitulo"];
        }
    ?></h1>
    <div class="card bg-light items-align-center">
        <div class="mx-5 my-3">
            <form action="<?php print RUTA; ?>adminClientes/registroCliente/" method="POST">
                <label for="nombre" class="form-label text-dark fw-bold my-1">Nombre: *</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Juan" 
                required value='<?php isset($data["datas"]["nombre"])? print $data["datas"]["nombre"]:""; ?>'
                <?php
                    if(isset($data['baja'])){
                        print "disabled";
                    } 
                ?>/>

                <label for="apellidoPaterno" class="form-label text-dark fw-bold my-1">Apellido paterno: *</label>
                <input type="text" class="form-control" name="apellidoPaterno" id="apellidoPaterno" placeholder="Perez" 
                required value='<?php isset($data["datas"]["apellidoPaterno"])? print $data["datas"]["apellidoPaterno"]:""; ?>'
                <?php
                    if(isset($data['baja'])){
                        print "disabled";
                    } 
                ?>/>

                <label for="apellidoMaterno" class="form-label text-dark fw-bold my-1">Apellido materno: *</label>
                <input type="text" class="form-control" name="apellidoMaterno" id="apellidoMaterno" placeholder="Gonzales" 
                value='<?php isset($data["datas"]["apellidoMaterno"])? print $data["datas"]["apellidoMaterno"]:""; ?>'
                <?php
                    if(isset($data['baja'])){
                        print "disabled";
                    } 
                ?>/>
                 
                <label for="email" class="form-label text-dark fw-bold my-1">Correo electronico: *</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="ejemplo@ejemplo.com" required 
                value='<?php isset($data["datas"]["email"])? print $data["datas"]["email"]:""; ?>'
                <?php
                    if(isset($data['baja'])){
                        print "disabled";
                    } 
                ?>>

                <label for="direccion" class="form-label text-dark fw-bold my-1">Direccion: *</label>
                <input type="text" class="form-control" name="direccion" id="direccion" placeholder="avenida siempre viva" required 
                value='<?php isset($data["datas"]["direccion"])? print $data["datas"]["direccion"]:""; ?>'
                <?php
                    if(isset($data['baja'])){
                        print "disabled";
                    } 
                ?>>

                <label for="telefono" class="form-label text-dark fw-bold my-1">Telefono: *</label>
                <input type="text" class="form-control" name="telefono" id="telefono" placeholder="+56912345678" required 
                value='<?php isset($data["datas"]["telefono"])? print $data["datas"]["telefono"]:""; ?>'
                <?php
                    if(isset($data['baja'])){
                        print "disabled";
                    } 
                ?>>

                <div <?php if(isset($data['baja'])) print "hidden" ?>>
                    <label for="clave1" class="form-label text-dark fw-bold my-1">Clave de acceso: *</label>
                    <input type="password" class="form-control" name="clave1" id="clave1" placeholder="**********" required>
                
                    <label for="clave2" class="form-label text-dark fw-bold my-1">Confirme su clave de acceso: *</label>
                    <input type="password" class="form-control" name="clave2" id="clave2" placeholder="**********" required>
                </div>

                
                <div <?php if(!isset($data["datas"]["id"])){
                    print "hidden";
                }else if($data["datas"]["id"]==""){
                    print "hidden";
                }  ?>>
                    <label for="status" class="form-label text-dark fw-bold my-1">Seleccione el status *</label>
                    <select name="status" id="status" class="form-control" <?php
                        if(isset($data['baja'])){
                            print "disabled";
                        } 
                    ?>>
                        <option value="void">Seleccione el status del Usuario</option> 
                        <?php
                            for ($i=0; $i < count($data["status"]); $i++) { 
                            print "<option value='".$data["status"][$i]["indice"]."'";
                            if($data["status"][$i]["indice"]==$data["datas"]["status"]){
                                print " selected ";
                            }
                            print ">".$data["status"][$i]["cadena"]."</option>";
                            }
                        ?>
                    </select>
                </div>  

                <input type="hidden"
                <?php 
                    if(isset($data['baja'])){
                        print "id ='"."desc"."'";
                    }else{
                        print "id ='"."hola"."'";
                    }
                ?>>

                <input type="hidden" name="id" id="id" value='<?php isset($data["datas"]["id"])? print $data["datas"]["id"]:""; ?>'/>

                <?php
                if (isset($data["baja"])) { ?>
                    <p class="my-2 fw-bold">¿esta seguro de borrar este Usuario?</p>
                    <a href="<?php print RUTA; ?>adminClientes/borrarLogico/<?php print $data['datas']['id']; ?>" class="btn btn-danger px-5 py-2 fw-bold">Si</a>
                    <a href="<?php print RUTA; ?>adminClientes" class="btn btn-success px-5 py-2 fw-bold">No</a>
                <?php } else { ?> 
                    <button type="submit" class="btn btn-primary mx-auto px-5 py-2 fw-bold my-2 me-1">Enviar Datos</button>
                <?php } ?>
            </form>
        </div>
    </div>
    <?php include_once("errores.php"); ?>
</div>