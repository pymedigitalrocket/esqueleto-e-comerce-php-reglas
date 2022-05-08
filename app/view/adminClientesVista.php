<?php include_once("base.php"); ?>
<h1 class="text-center my-5">Lista de Usuarios</h1>
<div class="container-md">
  <div class="card bg-light m-lg-5">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>E-mail</th>
          <th>Direccion</th>
          <th>Telefono</th>
          <th>Modificar</th>
          <th>Borrar</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $paginas = $data["total"]/8;
          $paginas = ceil($paginas);
          for($i =0; $i < count($data['datas']); $i++){
            print "<tr>";
            print "<td class='text-left'>".$data["datas"][$i]["nombre"]." ".$data["datas"][$i]["apellidoPaterno"]."</td>";
            print "<td class='text-left'>".$data["datas"][$i]["email"]."</td>";
            print "<td class='text-left'>".$data["datas"][$i]["direccion"]."</td>";
            print "<td class='text-left'>".$data["datas"][$i]["telefono"]."</td>";
            print "<td><a href='".RUTA."adminClientes/editarCliente/".$data["datas"][$i]["id"]."' class='btn btn-warning text-white fw-bold px-3 py-2'>Modificar</a></td>";
            print "<td><a href='".RUTA."adminClientes/borrarCliente/".$data["datas"][$i]["id"]."' class='btn btn-danger fw-bold px-3 py-2'>Borrar</a></td>";
            print "</tr>";
          }
        ?>
      </tbody>
    </table>
    <div class="container col-auto">
        <nav aria-label="Page navigation example">
          <ul class="pagination mt-3">
            <li class="page-item <?php echo $_GET['clientes']<=1 ? 'disabled':'' ?>
            ">
              <?php $paginaAnterior = $_GET['clientes']-1;
                    $paginaSiguiente = $_GET['clientes']+1;
              ?>
              <a class="page-link" <?php print "href='".RUTA."adminClientes?clientes=".$paginaAnterior." '"; ?> aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php for($i=0;$i<$paginas;$i++): ?>
            <?php $indice=$i+1; ?>
            <li class="page-item <?php echo $_GET['clientes']==$indice?'active':'' ?>
            ">
            <a class="page-link" <?php print "href='".RUTA."adminClientes?clientes=".$indice." '"; ?>><?php print $i+1; ?></a></li>
            <?php endfor ?>
            <li class="page-item <?php echo $_GET['clientes']>=$paginas ? 'disabled':'' ?>
            ">
              <a class="page-link" <?php print "href='".RUTA."adminClientes?clientes=".$paginaSiguiente." '"; ?> aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
    </div>
    <a href="<?php print RUTA; ?>adminClientes/registroCliente" class="btn btn-primary mx-auto my-3 py-2 fw-bold">
      Registrar Cliente</a>
  </div>
  <?php include_once("errores.php"); ?>
</div>