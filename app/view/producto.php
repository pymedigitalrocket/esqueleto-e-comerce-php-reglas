<?php include_once("base.php");?>
<script type="text/javascript">
function galeria(imagen){
    var imagen1 = document.getElementById("imagen1");

    imagen1.src = imagen.src;
}
</script>
<?php
$precio = $data["datas"]["precio"];
$des = $data["datas"]["descuento"];
$descuento = ($data["datas"]["descuento"]*$precio)/100;
$precioReal = $precio - $descuento;
print "<h2 class='text-center my-3'>".$data["subtitulo"]."</h2>";
print "<aside class='float-end mt-5 me-2'>";
print "<img src='".RUTA."img/".$data['datas']["imagen1"]."' width='105' id='imagenuno' onclick='galeria(this);' ";
print "class='img-responsive' ";
print "alt='".$data['datas']["nombre"]."'/>";
if(!empty($data['datas']["imagen2"])){
    print "<br>";
    print "<img src='".RUTA."img/".$data['datas']["imagen2"]."' width='105' id='imagen2' onclick='galeria(this);'";
    print "class='img-responsive mt-3' ";
    print "alt='".$data['datas']["nombre"]."'/>";
}
if(!empty($data['datas']["imagen3"])){
    print "<br>";
    print "<img src='".RUTA."img/".$data['datas']["imagen3"]."' width='105' id='imagen3' onclick='galeria(this);'";
    print "class='img-responsive mt-3' ";
    print "alt='".$data['datas']["nombre"]."'/>";
}
print "</aside>";
print "<div class='container mt-5'".">";
print "<img src='".RUTA."img/".$data["datas"]["imagen1"]."' id='imagen1' class='img-responsive rounded float-end me-3'/>";
print "<h4>Descripcion:</h4>";
print "<p>".html_entity_decode($data["datas"]["descripcion"])."</p>";
print "<h4>Marca:</h4>";
print "<p>".$data["datas"]["marca"]."</p>";
print "<h4>Material:</h4>";
print "<p>".$data["datas"]["material"]."</p>";
print "<h4>Talla:</h4>";
for($i=0;$i<count($data["tallas"]);$i++){
    if($data["datas"]["talla"]==$data["tallas"][$i]["indice"]){
        print $data["tallas"][$i]["cadena"];
    }
}
print "<h4>Categoria:</h4>";
for($i=0;$i<count($data["categoria"]);$i++){
    if($data["datas"]["categoria"]==$data["categoria"][$i]["indice"]){
        print $data["categoria"][$i]["cadena"];
    }
}
print "<h4>Precio (CLP):</h4>";
if($des>0){
    print "<strike><p>$".number_format($precio,0)."</strike> $".number_format($precioReal,0)."</p>";
    print "<p class='fw-bold'".">"."descuento: ".number_format($des,0)."%</p>";
}else{
    print "<p>$".number_format($precioReal)."</p>";
}
$regresa = ($data["regresa"]=="")?"tienda":"tipoProducto/".$data["regresa"];
print "<a href='".RUTA."carro/agregarProducto/";
print $data["datas"]["id"]."/";
print $data["idUsuario"]."' ";
print "class='btn btn-success fw-bold px-5 py-2 me-2'/>Agregar al carro</a>";
print "<a href='".RUTA.$regresa."' class='btn btn-primary fw-bold px-5 py-2'/>Regresar</a>";
print "</div>";

print "<div class='container mt-5'>";
print "<hr></hr>";
print "<h1 class='text-center my-4 fw-bold'>Productos Relacionados</h1>";
$reglon = 0;
for($i=0;$i<count($data["catalogo"]);$i++){
    if($data["datas"]["relacion1"]==$data["catalogo"][$i]["id"]){
        $precio = $data["catalogo"][$i]["precio"];
        $des = $data["catalogo"][$i]["descuento"];
        $descuento = ($data["catalogo"][$i]["descuento"]*$precio)/100;
        $precioReal = $precio - $descuento;
        if($reglon==0){
            print "<div class='row'>";
        }
        print "<div class='card pt-2 border-0 col-sm-3'>";
        print "<img src='".RUTA."img/".$data['catalogo'][$i]["imagen1"]."' id='imagen1' ";
        if(!empty($data["catalogo"][$i]["imagen2"])){
            $imagenNueva = $data["catalogo"][$i]["imagen2"];
            $imagenVieja = $data["catalogo"][$i]["imagen1"];
            print "onmouseover=src='".RUTA."img/".$imagenNueva."' ";
            print "onmouseout=src='".RUTA."img/".$imagenVieja."' ";
        }
        print "class='img-responsive' ";
        print "alt='".$data['catalogo'][$i]["nombre"]."'/>";
        print "<p><a href='".RUTA."productosAdmin/producto/";
        print $data['catalogo'][$i]["id"]."'>";
        print $data['catalogo'][$i]["nombre"]."</a>"."</p>";
        print "<div class='row'>";
        print "<div class='col-lg-12 mb-3'>";
        if($des>0){
            print "precio: "."<strike class='text-muted'>$".number_format($precio,0)."</strike>"."<strong class='text-danger'>"." $".number_format($precioReal,0)."</strong>"." "."<strong>".$des."%"." descuento"."</strong>";
        }else{
            print "precio: $".number_format($precio,0);   
        }
        print "</div>";
        print "</div>";
        print "<a href='".RUTA."carro/agregarProducto/";
        print $data["catalogo"][$i]["id"]."/";
        if(isset($_SESSION["usuario"])){
            $idUsuario = $_SESSION["usuario"]["id"];
            print $idUsuario."' ";
        }else{
            $idUsuario = $_SESSION["temporal"];
            print $idUsuario."' ";
        }
        print "class='btn btn-success fw-bold px-5 py-2 me-2 mb-3'/>Agregar al carro</a>";
        print "</div>";
        $reglon++;
        if($reglon==4){
            $reglon = 0;
            print "</div>";
        }
    }else if($data["datas"]["relacion2"]==$data["catalogo"][$i]["id"]){
        $precio = $data["catalogo"][$i]["precio"];
        $des = $data["catalogo"][$i]["descuento"];
        $descuento = ($data["catalogo"][$i]["descuento"]*$precio)/100;
        $precioReal = $precio - $descuento;
        if($reglon==0){
            print "<div class='row'>";
        }
        print "<div class='card pt-2 border-0 col-sm-3'>";
        print "<img src='".RUTA."img/".$data['catalogo'][$i]["imagen1"]."' ";
        if(!empty($data["catalogo"][$i]["imagen2"])){
            $imagenNueva = $data["catalogo"][$i]["imagen2"];
            $imagenVieja = $data["catalogo"][$i]["imagen1"];
            print "onmouseover=src='".RUTA."img/".$imagenNueva."' ";
            print "onmouseout=src='".RUTA."img/".$imagenVieja."' ";
        }
        print "class='img-responsive' ";
        print "alt='".$data['catalogo'][$i]["nombre"]."'/>";
        print "<p><a href='".RUTA."productosAdmin/producto/";
        print $data['catalogo'][$i]["id"]."'>";
        print $data['catalogo'][$i]["nombre"]."</a>"."</p>";
        print "<div class='row'>";
        print "<div class='col-lg-12 mb-3'>";
        if($des>0){
            print "precio: "."<strike class='text-muted'>$".number_format($precio,0)."</strike>"."<strong class='text-danger'>"." $".number_format($precioReal,0)."</strong>"." "."<strong>".$des."%"." descuento"."</strong>";
        }else{
            print "precio: $".number_format($precio,0);   
        }
        print "</div>";
        print "</div>";
        print "<a href='".RUTA."carro/agregarProducto/";
        print $data["catalogo"][$i]["id"]."/";
        if(isset($_SESSION["usuario"])){
            $idUsuario = $_SESSION["usuario"]["id"];
            print $idUsuario."' ";
        }else{
            $idUsuario = $_SESSION["temporal"];
            print $idUsuario."' ";
        }
        print "class='btn btn-success fw-bold px-5 py-2 me-2 mb-3'/>Agregar al carro</a>";
        print "</div>";
        $reglon++;
        if($reglon==4){
            $reglon = 0;
            print "</div>";
        }
    }else if($data["datas"]["relacion3"]==$data["catalogo"][$i]["id"]){
        $precio = $data["catalogo"][$i]["precio"];
        $des = $data["catalogo"][$i]["descuento"];
        $descuento = ($data["catalogo"][$i]["descuento"]*$precio)/100;
        $precioReal = $precio - $descuento;
        if($reglon==0){
            print "<div class='row'>";
        }
        print "<div class='card pt-2 border-0 col-sm-3'>";
        print "<img src='".RUTA."img/".$data['catalogo'][$i]["imagen1"]."' ";
        if(!empty($data["catalogo"][$i]["imagen2"])){
            $imagenNueva = $data["catalogo"][$i]["imagen2"];
            $imagenVieja = $data["catalogo"][$i]["imagen1"];
            print "onmouseover=src='".RUTA."img/".$imagenNueva."' ";
            print "onmouseout=src='".RUTA."img/".$imagenVieja."' ";
        }
        print "class='img-responsive' ";
        print "alt='".$data['catalogo'][$i]["nombre"]."'/>";
        print "<p><a href='".RUTA."productosAdmin/producto/";
        print $data['catalogo'][$i]["id"]."'>";
        print $data['catalogo'][$i]["nombre"]."</a>"."</p>";
        print "<div class='row'>";
        print "<div class='col-lg-12 mb-3'>";
        if($des>0){
            print "precio: "."<strike class='text-muted'>$".number_format($precio,0)."</strike>"."<strong class='text-danger'>"." $".number_format($precioReal,0)."</strong>"." "."<strong>".$des."%"." descuento"."</strong>";
        }else{
            print "precio: $".number_format($precio,0);   
        }
        print "</div>";
        print "</div>";
        print "<a href='".RUTA."carro/agregarProducto/";
        print $data["catalogo"][$i]["id"]."/";
        if(isset($_SESSION["usuario"])){
            $idUsuario = $_SESSION["usuario"]["id"];
            print $idUsuario."' ";
        }else{
            $idUsuario = $_SESSION["temporal"];
            print $idUsuario."' ";
        }
        print "class='btn btn-success fw-bold px-5 py-2 me-2 mb-3'/>Agregar al carro</a>";
        print "</div>";
        $reglon++;
        if($reglon==4){
            $reglon = 0;
            print "</div>";
        }
    }
}
print "</div>";
include_once("errores.php");?>