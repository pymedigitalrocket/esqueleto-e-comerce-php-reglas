<?php include_once("base.php"); ?>
<h1 class="text-center my-5">Ventas detalle por dia</h1>
<div class="container-sm">
  <div class="card bg-light m-lg-5">
    <table class="table table-striped">
      <thead>
        <tr>
          <?php
          if(!isset($data["idUsuario"])){
            print "<th>Nombre</th>";
          }else{
            print "<th>ID producto</th>";
          } 
          ?>
          <th>Precio</th>
          <th>Cantidad</th>
          <th>Descuento</th>
          <th>Subtotal</th>
          <th>Total</th>
          <th>Fecha</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $precio = 0;
          $cant = 0;
          $des = 0;
          $subtotal = 0;
          $total = 0;
          for($i =0; $i < count($data['datas']); $i++){
            print "<tr>";
            print "<td>".$data["datas"][$i]["nombre_producto"]."</td>";
            print "<td class='text-left'>$".number_format($data["datas"][$i]["precio"],0)."</td>";
            print "<td class='text-left'>".number_format($data["datas"][$i]["cantidad"],0)."</td>";
            print "<td class='text-left'>$".number_format($data["datas"][$i]["descuento"],0)."</td>";
            print "<td class='text-left'>$".number_format($data["datas"][$i]["subtotal"],0)."</td>";
            print "<td class='text-left'>$".number_format($data["datas"][$i]["total"],0)."</td>";
            print "<td class='text-left'>".$data["datas"][$i]["fecha"]."</td>";
            print "</tr>";
            $precio += $data["datas"][$i]["precio"] * $data["datas"][$i]["cantidad"];
            $cant += $data["datas"][$i]["cantidad"];
            $des += $data["datas"][$i]["descuento"];
            $subtotal += $data["datas"][$i]["subtotal"];
            $total += $data["datas"][$i]["total"];
          }
          print "<tr>";
          print "<td>totales</td>";
          print "<td class='text-right'>$".number_format($precio,0)."</td>";
          print "<td class='text-right'>".number_format($cant,0)."</td>";
          print "<td class='text-right'>$".number_format($des,0)."</td>";
          print "<td class='text-right'>$".number_format($subtotal,0)."</td>";
          print "<td class='text-right'>$".number_format($total,0)."</td>";
          print "<td></td>";
          print "</tr>";
        ?>
      </tbody>
    </table>
    <a href="<?php print RUTA; ?>carro/ventas" class="btn btn-primary mx-auto my-3 py-2 fw-bold">
      Regresar</a>
  </div>
  <?php include_once("errores.php"); ?>
</div>