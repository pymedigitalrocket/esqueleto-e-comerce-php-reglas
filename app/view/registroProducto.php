<?php include("base.php");?>

<script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script>

<div class="container-md">
    <h1 class="text-center my-4 fw-bold">
    <?php
        if(isset($data["subtitulo"])) {
            print $data["subtitulo"];
        }
    ?>
    </h1>
    <div class="card bg-light items-align-center">
        <div class="mx-5 my-3">
            <form action="<?php print RUTA; ?>productosAdmin/insertarProducto/" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre" class="form-label text-dark fw-bold my-1">Nombre Producto: *</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del producto" 
                    required value='<?php isset($data["datas"]["nombre"])? print $data["datas"]["nombre"]:""; ?>'
                    <?php
                        if(isset($data['baja'])){
                            print "disabled";
                        } 
                    ?>>
                </div>

                <div class="form-group">
                    <label for="content" class="form-label text-dark fw-bold my-1">Descripcion Producto: </label>
                    <textarea name="content" id="editor" cols="30" rows="10">
                    <?php
                        if(isset($data['datas']['descripcion'])){
                            print $data['datas']['descripcion']; 
                        }
                    ?>
                    </textarea>
                </div>

                <div class="form-group">
                    <label for="marca" class="form-label text-dark fw-bold my-1">Marca Producto: </label>
                    <input type="text" class="form-control" name="marca" id="marca" placeholder="Marca del producto" 
                     value='<?php isset($data["datas"]["marca"])? print $data["datas"]["marca"]:""; ?>'
                    <?php
                        if(isset($data['baja'])){
                            print "disabled";
                        } 
                    ?>>
                </div>

                <div class="form-group">
                    <label for="talla" class="form-label text-dark fw-bold my-1">Seleccione la talla de la prenda: *</label>
                    <select name="talla" id="talla" class="form-control" required
                    <?php
                        if(isset($data['baja'])){
                            print "disabled";
                        } 
                    ?>>
                    <option value="void">Seleccione la talla de la prenda</option>
                    <?php
                        for($i=0;$i<count($data["talla"]);$i++){
                            print " <option value='".$data["talla"][$i]["indice"]."'";
                            if(isset($data["datas"]["talla"])){
                                if($data["datas"]["talla"]==$data["talla"][$i]["indice"]){
                                    print " selected ";
                                }
                            }
                            print ">".$data["talla"][$i]["cadena"]."</option>";
                        } 
                    ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="material" class="form-label text-dark fw-bold my-1">Material de la prenda: </label>
                    <input type="text" class="form-control" name="material" id="material" placeholder="Material de la prenda" 
                    value='<?php isset($data["datas"]["material"])? print $data["datas"]["material"]:""; ?>'
                    <?php
                        if(isset($data['baja'])){
                            print "disabled";
                        } 
                    ?>>
                </div>

                <input type="hidden"
                <?php 
                    if(isset($data['baja'])){
                        print "id ='"."desc"."'";
                    }else{
                        print "id ='"."hola"."'";
                    }
                ?>>

                <div class="form-group">
                    <label for="precio" class="form-label text-dark fw-bold my-1">Precio Producto (sin comas, ni puntos. Tampoco utilice simbolo de peso, o dolar): *</label>
                    <input type="text" class="form-control" name="precio" id="precio" placeholder="Precio del producto" pattern = "^(\d|-)?(\d|,)*\.?\d*$" 
                    required value='<?php isset($data["datas"]["precio"])? print $data["datas"]["precio"]:""; ?>'
                    <?php
                        if(isset($data['baja'])){
                            print "disabled";
                        } 
                    ?>/>
                </div>

                <div class="form-group">
                    <label for="imagen1" class="form-label text-dark fw-bold my-1">Subir primera imagen del producto: * </label>
                    <input type="file" class="form-control" name="imagen1" id="imagen1" accept="image/jpeg" required
                    <?php
                        if(isset($data['baja'])){
                            print "disabled";
                        } 
                    ?>>
                </div>

                <div class="form-group">
                    <label for="imagen2" class="form-label text-dark fw-bold my-1">Subir segunda imagen del producto: </label>
                    <input type="file" class="form-control" name="imagen2" id="imagen2" accept="image/jpeg"
                    <?php
                        if(isset($data['baja'])){
                            print "disabled";
                        } 
                    ?>>
                </div>

                <div class="form-group">
                    <label for="imagen3" class="form-label text-dark fw-bold my-1">Subir tercera imagen del producto: </label>
                    <input type="file" class="form-control" name="imagen3" id="imagen3" accept="image/jpeg"
                    <?php
                        if(isset($data['baja'])){
                            print "disabled";
                        } 
                    ?>>
                </div>
                
                <div class="form-group">
                    <label for="relacion1" class="form-label text-dark fw-bold my-1">Producto relacionado: </label>
                    <select name="relacion1" id="relacion1" class="form-control"
                    <?php
                        if(isset($data['baja'])){
                            print "disabled";
                        } 
                    ?>>
                    <option value="void">Selecciona el Producto relacionado</option>
                    <?php
                        for($i=0;$i<count($data["catalogo"]);$i++){
                            print " <option value='".$data["catalogo"][$i]["id"]."'";
                            if(isset($data["datas"]["relacion1"])){
                                if($data["datas"]["relacion1"]==$data["catalogo"][$i]["id"]){
                                    print " selected ";
                                }
                            }
                            print ">".$data["catalogo"][$i]["nombre"]."</option>";
                        } 
                    ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="relacion2" class="form-label text-dark fw-bold my-1">Producto relacionado: </label>
                    <select name="relacion2" id="relacion2" class="form-control"
                    <?php
                        if(isset($data['baja'])){
                            print "disabled";
                        } 
                    ?>>
                    <option value="void">Selecciona el Producto relacionado</option>
                    <?php
                        for($i=0;$i<count($data["catalogo"]);$i++){
                            print " <option value='".$data["catalogo"][$i]["id"]."'";
                            if(isset($data["datas"]["relacion2"])){
                                if($data["datas"]["relacion2"]==$data["catalogo"][$i]["id"]){
                                    print " selected ";
                                }
                            }
                            print ">".$data["catalogo"][$i]["nombre"]."</option>";
                        } 
                    ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="relacion3" class="form-label text-dark fw-bold my-1">Producto relacionado: </label>
                    <select name="relacion3" id="relacion3" class="form-control"
                    <?php
                        if(isset($data['baja'])){
                            print "disabled";
                        } 
                    ?>>
                    <option value="void">Selecciona el Producto relacionado</option>
                    <?php
                        for($i=0;$i<count($data["catalogo"]);$i++){
                            print " <option value='".$data["catalogo"][$i]["id"]."'";
                            if(isset($data["datas"]["relacion3"])){
                                if($data["datas"]["relacion3"]==$data["catalogo"][$i]["id"]){
                                    print " selected ";
                                }
                            }
                            print ">".$data["catalogo"][$i]["nombre"]."</option>";
                        } 
                    ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="categoria" class="form-label text-dark fw-bold my-1">Seleccione la categoria de la prenda: </label>
                    <select name="categoria" id="categoria" class="form-control" required
                    <?php
                        if(isset($data['baja'])){
                            print "disabled";
                        } 
                    ?>>
                    <option value="void">Seleccione la categoria de la prenda</option>
                    <?php
                        for($i=0;$i<count($data["categoria"]);$i++){
                            print " <option value='".$data["categoria"][$i]["indice"]."'";
                            if(isset($data["datas"]["categoria"])){
                                if($data["datas"]["categoria"]==$data["categoria"][$i]["indice"]){
                                    print " selected ";
                                }
                            }
                            print ">".$data["categoria"][$i]["cadena"]."</option>";
                        } 
                    ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="descuento" class="form-label text-dark fw-bold my-1">Descuento Producto (sin comas, ni puntos. Tampoco utilice simbolo de porcentaje): </label>
                    <input type="text" class="form-control" name="descuento" id="descuento" placeholder="Descuento del precio" pattern = "^(\d|-)?(\d|,)*\.?\d*$"  
                    value='<?php isset($data["datas"]["descuento"])? print $data["datas"]["descuento"]:""; ?>'
                    <?php
                        if(isset($data['baja'])){
                            print "disabled";
                        } 
                    ?>/>
                </div>
                

                <?php
                if (STOCK) { ?>
                    <div class="form-group">
                        <label for="stock" class="form-label text-dark fw-bold my-1">stock Producto: </label>
                        <input type="text" class="form-control" name="stock" id="stock" placeholder="stock del producto" pattern = "^(\d|-)?(\d|,)*\.?\d*$"  
                        value='<?php isset($data["datas"]["stock"])? print $data["datas"]["stock"]:""; ?>'
                        <?php
                            if(isset($data['baja'])){
                                print "disabled";
                            } 
                        ?>/>
                    </div>
                <?php }  ?> 

                <div class="form-group">
                    <label for="status" class="form-label text-dark fw-bold my-1">Seleccione el status: *</label>
                    <select name="status" id="status" class="form-control" required
                    <?php
                        if(isset($data['baja'])){
                            print "disabled";
                        } 
                    ?>>
                    <option value="void">Selecciona el status del producto</option>
                    <?php
                        for($i=0;$i<count($data["status"]);$i++){
                            print " <option value='".$data["status"][$i]["indice"]."'";
                            if(isset($data["datas"]["status"])){
                                if($data["datas"]["status"]==$data["status"][$i]["indice"]){
                                    print " selected ";
                                }
                            }
                            print ">".$data["status"][$i]["cadena"]."</option>";
                        } 
                    ?>
                    </select>
                </div>

                <input type="hidden" name="id" id="id" value='<?php isset($data["datas"]["id"])? print $data["datas"]["id"]:""; ?>'/>
                
                <?php
                if (isset($data["baja"])) { ?>
                    <p class="my-2 fw-bold">¿esta seguro de borrar este Producto?</p>
                    <a href="<?php print RUTA; ?>productosAdmin/borrarLogico/<?php print $data['datas']['id']; ?>" class="btn btn-danger px-5 py-2 fw-bold">Si</a>
                    <a href="<?php print RUTA; ?>productosAdmin" class="btn btn-success px-5 py-2 fw-bold">No</a>
                <?php } else { ?> 
                <input type="submit" value="Enviar" class="btn btn-primary mt-2 px-5 py-2 fw-bold">
                <?php } ?> 
            </form>
        </div>
    </div>
    <?php include_once("errores.php"); ?>
</div>

<script>
    if(document.getElementById("desc")){
        ClassicEditor.create( document.querySelector('#editor' ) )
        .then(editor => { 
            console.log( editor ); 
            editor.isReadOnly = true; 
        } ) .catch( error => { 
            console.error( error ); 
        } );
    }
    if(document.getElementById("hola")){
        ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
    }
</script>