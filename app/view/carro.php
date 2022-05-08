<?php include("base.php");

$verifica = false;
$subTotal = 0;
$descuento = 0;
$porcentajeDescuento = 0;
$idUsuario = $data["idUsuario"];

print "<h1 class='text-center fw-bold my-4'>Carro de compras</h1>";
print "<form action='".RUTA."carro/actualizar' method='POST'>";
print "<table class='table table-striped' width='100%'>";
print "<tr>";
print "<th width='12%'>Producto</th>";
print "<th width='58%'>Descripcion</th>";
print "<th width='1.8%'>Cant.</th>";
print "<th width='10.12%'>Precio</th>";
print "<th width='10.12%'>Sub Total</th>";
print "<th width='1%'>&nbsp;</th>";
print "<th width='6.5%'>borrar</th>";
print "</tr>";
for($i =0; $i<count($data["datas"]);$i++){
    $descripcion = substr(html_entity_decode($data["datas"][$i]["descripcion"]),0,130);
    $nombre = $data["datas"][$i]["nombre"];
    $producto = $data["datas"][$i]["producto"];
    $cantidad = $data["datas"][$i]["cantidad"];
    $precio = $data["datas"][$i]["precio"];
    $imagen = $data["datas"][$i]["imagen"];
    $des = $data["datas"][$i]["descuento"];
    if($des!=0){
        $porcentajeDescuento += ($precio * ($des/100))*$cantidad;
    }
    $total = $cantidad*$precio;

    print "<tr>";
    //producto
    print "<td><img src='".RUTA."img/".$imagen."' width='105' alt'".$nombre."'></td>";
    //descripcion
    print "<td>".$descripcion."...</td>";
    //cantidad
    print "<td class='text-right'>";
    print "<input type='number' name='c".$i."' class='text-right' ";
    print "value='".number_format($cantidad,0)."' min='1' max='99'/>";
    print "<input type='hidden' name='i".$i."' value='".$producto."'/>";
    print "</td>";
    //precio
    print "<td class='text-right'>$".number_format($precio,0)."</td>";
    //total
    print "<td class='text-right'>$".number_format($total,0)."</td>";
    //borrar
    print "<td>&nbsp;</td>";
    print "<td class='text-right'><a href='".RUTA."carro/borrar/";
    print $producto."/".$idUsuario."' class='btn btn-danger fw-bold'>Borrar</a>";
    print "</tr>";
    $subTotal += $total;
    $descuento += $des;
}
$total = $subTotal - $porcentajeDescuento;
print "<input type='hidden' name='num' value='".$i."'/>";
print "<input type='hidden' name='idUsuario' value='".$data["idUsuario"]."'/>";
print "</table>";
print "<hr>";

print "<table width='100%' class='text-right'>";
print "<tr>";
print "<td width='79.85%'></td>";
print "<td width='11.55%'>Sub total</td>";
print "<td width='9.20%'>$".number_format($subTotal,0)."</td>";
print "</tr>";

print "<tr>";
print "<td></td>";
print "<td>Descuento</td>";
print "<td>$".number_format($porcentajeDescuento,0)."</td>";
print "</tr>";
print "<tr>";
print "<td></td>";
print "<td>Total</td>";
print "<td>$".number_format($total,0)."</td>";
print "</tr>";
print "<tr>";
print "<td><a href='".RUTA."tienda' class='btn btn-primary fw-bold mx-5'>Seguir comprando</a></td>";
print "<td><input type='submit' class='btn btn-success fw-bold' value='Recalcular'/></td>";
if($verifica){
    print "<td><a href='".RUTA."carro/gracias' class='btn btn-success fw-bold'>Pagar</a></td>";
}else{
    print "<td><a href='".RUTA."carro/checkout' class='btn btn-success fw-bold'>Pagar</a></td>";
}
print "</tr>";
print "</table>";
print "</form>";

include("errores.php");?>