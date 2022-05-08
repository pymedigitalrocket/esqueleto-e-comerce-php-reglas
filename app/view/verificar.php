<?php include("base.php");?>

<div class="card container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Datos de envio</a></li>
            <li class="breadcrumb-item"><a href="#">Forma de pago</a></li>
            <li class="breadcrumb-item fw-bold">Verificar datos</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Verificar datos</h2>
    <?php
        $verifica = false;
        $subTotal = 0;
        $descuento = 0;
        $porcentajeDescuento = 0;
        print "Modo de pago: ".$data["pago"]."<br>";
        if(isset($_SESSION["usuario"])){
            print "Nombre: ".$data["datas"]["nombre"]." ".$data["datas"]["apellido_paterno"]."<br>";
            print "Direccion: ".$data["datas"]["direccion"]."<br>";
            print "Correo: ".$data["datas"]["correo"]."<br>";
        }else{
            print "Nombre: ".$data["datas"]["nombre"]." ".$data["datas"]["apellido_paterno"]."<br>";
            print "Direccion: ".$data["datas"]["direccion"]."<br>";
            print "Correo: ".$data["datas"]["correo"]."<br>";
        }

        print "<table class='table table-striped' width='100%'>";
        print "<tr>";
        print "<th width='12%'>Producto</th>";
        print "<th width='58%'>Descripcion</th>";
        print "<th width='1.8%'>Cant.</th>";
        print "<th width='10.12%'>Precio</th>";
        print "<th width='10.12%'>Sub Total</th>";
        print "</tr>";
        for($i =0; $i<count($data["carro"]);$i++){
            $descripcion = substr(html_entity_decode($data["carro"][$i]["descripcion"]),0,49);
            $producto = $data["carro"][$i]["producto"];
            $nombre = $data["carro"][$i]["nombre"];
            $cantidad = $data["carro"][$i]["cantidad"];
            $precio = $data["carro"][$i]["precio"];
            $imagen = $data["carro"][$i]["imagen"];
            $des = $data["carro"][$i]["descuento"];
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
            print number_format($cantidad,0);
            print "<input type='hidden' name='i".$i."' value='".$producto."'/>";
            print "</td>";
            //precio
            print "<td class='text-right'>$".number_format($precio,0)."</td>";
            //total
            print "<td class='text-right'>$".number_format($total,0)."</td>";
            $subTotal += $total;
            $descuento += $des;
        }
        $total = $subTotal - $porcentajeDescuento;
        print "<input type='hidden' name='num' value='".$i."'/>";
        //print "<input type='hidden' name='idUsuario' value='".$data["datas"]["idUsuario"]."'/>";
        //print "</table>";
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
        print "<td><a href='".RUTA."carro/gracias' class='btn btn-success fw-bold px-5 py-2 my-2'>Pagar</a></td>";
        print "</tr>";
        print "</table>";
    ?>
</div>