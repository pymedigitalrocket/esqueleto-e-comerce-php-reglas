<?php include_once("base.php"); ?>
<h1 class="text-center my-5">Lista de Productos</h1>
<div class="container-sm">
  <div class="card bg-light m-lg-5">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Categoria</th>
          <th>Descripcion</th>
          <th>Modificar</th>
          <th>Borrar</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $paginas = $data["total"]/8;
          $paginas = ceil($paginas);
          for($i =0; $i < count($data['datas']); $i++){
            $categoria = $data["datas"][$i]["categoria"]-1;
            print "<tr>";
            print "<td class='text-left'>".$data["datas"][$i]["nombre"]."</td>";
            print "<td class='text-left'>".$data["catalogo"][$categoria]["cadena"]."</td>";
            print "<td class='text-left'>".substr(html_entity_decode($data["datas"][$i]["descripcion"]),0,70)."...</td>";
            print "<td><a href='".RUTA."productosAdmin/editarProducto/".$data["datas"][$i]["id"]."' class='btn btn-warning text-white fw-bold px-3 py-2'>Modificar</a></td>";
            print "<td><a href='".RUTA."productosAdmin/borrarProducto/".$data["datas"][$i]["id"]."' class='btn btn-danger fw-bold px-3 py-2'>Borrar</a></td>";
            print "</tr>";
          }
        ?>
      </tbody>
    </table>
    <div class="container col-auto">
        <nav aria-label="Page navigation example">
          <ul class="pagination mt-3">
            <li class="page-item <?php echo $_GET['productos']<=1 ? 'disabled':'' ?>
            ">
              <?php $paginaAnterior = $_GET['productos']-1;
                    $paginaSiguiente = $_GET['productos']+1;
              ?>
              <a class="page-link" <?php print "href='".RUTA."productosAdmin?productos=".$paginaAnterior." '"; ?> aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php for($i=0;$i<$paginas;$i++): ?>
            <?php $indice=$i+1; ?>
            <li class="page-item <?php echo $_GET['productos']==$indice?'active':'' ?>
            ">
            <a class="page-link" <?php print "href='".RUTA."productosAdmin?productos=".$indice." '"; ?>><?php print $i+1; ?></a></li>
            <?php endfor ?>
            <li class="page-item <?php echo $_GET['productos']>=$paginas ? 'disabled':'' ?>
            ">
              <a class="page-link" <?php print "href='".RUTA."productosAdmin?productos=".$paginaSiguiente." '"; ?> aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
    </div>
    <a href="<?php print RUTA; ?>productosAdmin/insertarProducto" class="btn btn-primary mx-auto my-3 py-2 fw-bold">
      Registrar Producto</a>
  </div>
  <?php include_once("errores.php"); ?>
</div>