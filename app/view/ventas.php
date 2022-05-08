<?php include_once("base.php"); ?>
<h1 class="text-center my-5">Gestor de ventas</h1>
<div class="container-sm">

  <form class="mx-5 row" action="<?php print RUTA; ?>carro/ventas/" method="GET">
      <div class="col-lg-2">
        <label for="fechaInicio" class="form-label text-dark fw-bold my-1">Fecha inicio: </label>
        <input type="date" class="form-control" name="fechaInicio" id="fechaInicio" 
        value='<?php isset($data["fechaInicio"])? print $data["fechaInicio"]:""; ?>'/>
      </div>
      <div class="col-lg-2">
        <label for="fechaMaxima" class="form-label text-dark fw-bold my-1">Fecha maxima: </label>
        <input type="date" class="form-control" name="fechaMaxima" id="fechaMaxima" 
        value='<?php isset($data["fechaMaxima"])? print $data["fechaMaxima"]:""; ?>'/>
      </div>
      <div class="col-sm-2">
        <label for="productos" class="form-check-label text-dark fw-bold my-1">Filtrar por productos: </label>
        <input type="checkbox" name="productos" id="productos" class="form-check-input mb-2 mx-1 mt-2" <?php
            if(isset($data["productos"])){
                if($data["productos"]=="1") print " checked ";
            } 
        ?>>
      </div>
      <div class="col-sm-2">
        <label for="categoria" class="form-check-label text-dark fw-bold my-1">Filtrar por categorias: </label>
        <input type="checkbox" name="categoria" id="categoria" class="form-check-input mb-2 mx-1 mt-2" <?php
            if(isset($data["categoria"])){
                if($data["categoria"]=="1") print " checked ";
            } 
        ?>>
      </div>
      <div class="col-lg-2">
        <input type="submit" value="Filtrar" class="btn btn-primary px-3 py-2 mt-4 fw-bold">
      </div>
  </form>

  <div class="card bg-light m-lg-5">
    <table class="table table-striped">
      <thead>
        <tr>
          <?php if($data["productos"]==1){
            print "<th>Nombre</th>";
          }else if($data["categoria"]==1){
            print "<th>Categoria</th>";
          }else{
            print "<th>ID</th>";
          }?>
          <th>Subtotal</th>
          <th>Descuento</th>
          <th>Total</th>
          <?php if($data["productos"]!=1&&$data["categoria"]!=1){
            print "<th>Fecha</th>";
          } ?>
          <th>Detalle</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $subtotal = 0;
          $des = 0;
          $envio = 0;
          $total = 0;
          $paginas = $data["total"]/8;
          $paginas = ceil($paginas);
          for($i =0; $i < count($data['datas']); $i++){
            $id = $data["datas"][$i]["id_usuario"];
            print "<tr>";
            if($data["productos"]==1){
              print "<td class='text-left'>".$data["datas"][$i]["nombre_producto"]."</td>";
            }else if($data["categoria"]==1){
              print "<td class='text-left'>".$data["catalogo"][$i]["cadena"]."</td>";
            }else{
              print "<td class='text-left'>".$data["datas"][$i]["id_usuario"]."</td>";
            }
            print "<td class='text-left'>$".number_format($data["datas"][$i]["subtotal"],0)."</td>";
            print "<td class='text-left'>$".number_format($data["datas"][$i]["descuento"],0)."</td>";
            print "<td class='text-left'>$".number_format($data["datas"][$i]["total"],0)."</td>";
            if($data["productos"]!=1&&$data["categoria"]!=1){
              print "<td class='text-left'>".$data["datas"][$i]["fecha"]."</td>";
            }
           if($data["productos"]==1){
              print "<td><a href='".RUTA."carro/detalleProductos/".$data["datas"][$i]["producto"]."/".$data["fechaInicio"]."/".$data["fechaMaxima"]."' class='btn btn-primary fw-bold px-3 py-2'>Detalle</a></td>";
            }else if($data["categoria"]==1){
              print "<td><a href='".RUTA."carro/detalleCategorias/".$data["datas"][$i]["categoria"]."/".$data["fechaInicio"]."/".$data["fechaMaxima"]."' class='btn btn-primary fw-bold px-3 py-2'>Detalle</a></td>";
            }else{
              print "<td><a href='".RUTA."carro/detalle/".$data["datas"][$i]["fecha"]."/".$id."' class='btn btn-primary fw-bold px-3 py-2'>Detalle</a></td>";
            }
            print "</tr>";
            $subtotal += $data["datas"][$i]["subtotal"];
            $des += $data["datas"][$i]["descuento"];
            $total += $data["datas"][$i]["total"];
          }
          print "<tr>";
          print "<td>totales</td>";
          print "<td class='text-right'>$".number_format($subtotal,0)."</td>";
          print "<td class='text-right'>$".number_format($des,0)."</td>";
          print "<td class='text-right'>$".number_format($total,0)."</td>";
          print "<td></td>";
          print "</tr>";
        ?>
      </tbody>
    </table>
    <div class="container col-auto">
        <nav aria-label="Page navigation example">
          <ul class="pagination mt-3">
            <li class="page-item <?php echo $_GET['ventas']<=1 ? 'disabled':'' ?>
            ">
              <?php $paginaAnterior = $_GET['ventas']-1;
                    $paginaSiguiente = $_GET['ventas']+1;
                    $fechaInicio = $data["fechaInicio"];
                    $fechaMaxima = $data["fechaMaxima"];
                    $productos = $data["productos"];
                    $categoria = $data["categoria"];
                    if($productos==0){
                        $productos = "";
                    }
                    if($categoria==0){
                        $categoria = "";
                    }
              ?>
              <a class="page-link" href="<?php echo RUTA;?>carro/ventas?ventas=<?php echo $paginaAnterior; ?>&fechaInicio=<?php echo $fechaInicio?>&fechaMaxima=<?php echo $fechaMaxima ?>&productos=<?php echo $productos ?>&categoria=<?php echo $categoria ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php for($i=0;$i<$paginas;$i++): ?>
            <?php $indice=$i+1; ?>
            <li class="page-item <?php echo $_GET['ventas']==$indice?'active':'' ?>
            ">
            <a class="page-link" href="<?php echo RUTA;?>carro/ventas?ventas=<?php echo $indice; ?>&fechaInicio=<?php echo $fechaInicio?>&fechaMaxima=<?php echo $fechaMaxima ?>&productos=<?php echo $productos ?>&categoria=<?php echo $categoria ?>"><?php print $i+1; ?></a></li>
            <?php endfor ?>
            <li class="page-item <?php echo $_GET['ventas']>=$paginas ? 'disabled':'' ?>
            ">
              <a class="page-link" href="<?php echo RUTA;?>carro/ventas?ventas=<?php echo $paginaSiguiente; ?>&fechaInicio=<?php echo $fechaInicio?>&fechaMaxima=<?php echo $fechaMaxima ?>&productos=<?php echo $productos ?>&categoria=<?php echo $categoria ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
    </div>
    <a href="<?php print RUTA; ?>carro/grafica" class="btn btn-primary mx-auto my-3 py-2 fw-bold">
      Grafica ventas</a>
  </div>
  <?php include_once("errores.php"); ?>
</div>