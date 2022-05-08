<?php include_once("base.php"); ?>
<h1 class="text-center my-5">Lista de Usuarios</h1>
<div class="container-md">
  <div class="card bg-light m-lg-5">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>E-mail</th>
          <th>rol usuario administrativo</th>
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
            print "<td class='text-left'>".$data["datas"][$i]["nombre"]."</td>";
            print "<td class='text-left'>".$data["datas"][$i]["correo"]."</td>";
            if($data["datas"][$i]["tipo_usuario_admon"]==1){
              print "<td class='text-left'>"."Root"."</td>";
            }else if($data["datas"][$i]["tipo_usuario_admon"]==2){
              print "<td class='text-left'>"."Dueño"."</td>";
            }else if($data["datas"][$i]["tipo_usuario_admon"]==3){
              print "<td class='text-left'>"."Administrador"."</td>";
            }else if($data["datas"][$i]["tipo_usuario_admon"]==4){
              print "<td class='text-left'>"."Espectador"."</td>";
            }
            print "<td><a href='".RUTA."adminUsuarios/editarUsuario/".$data["datas"][$i]["id"]."' class='btn btn-warning text-white fw-bold px-3 py-2'>Modificar</a></td>";
            print "<td><a href='".RUTA."adminUsuarios/borrarUsuario/".$data["datas"][$i]["id"]."' class='btn btn-danger fw-bold px-3 py-2'>Borrar</a></td>";
            print "</tr>";
          }
        ?>
      </tbody>
    </table>
    <div class="container col-auto">
        <nav aria-label="Page navigation example">
          <ul class="pagination mt-3">
            <li class="page-item <?php echo $_GET['admon']<=1 ? 'disabled':'' ?>
            ">
              <?php $paginaAnterior = $_GET['admon']-1;
                    $paginaSiguiente = $_GET['admon']+1;
              ?>
              <a class="page-link" <?php print "href='".RUTA."adminUsuarios?admon=".$paginaAnterior." '"; ?> aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php for($i=0;$i<$paginas;$i++): ?>
            <?php $indice=$i+1; ?>
            <li class="page-item <?php echo $_GET['admon']==$indice?'active':'' ?>
            ">
            <a class="page-link" <?php print "href='".RUTA."adminUsuarios?admon=".$indice." '"; ?>><?php print $i+1; ?></a></li>
            <?php endfor ?>
            <li class="page-item <?php echo $_GET['admon']>=$paginas ? 'disabled':'' ?>
            ">
              <a class="page-link" <?php print "href='".RUTA."adminUsuarios?admon=".$paginaSiguiente." '"; ?> aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
    </div>
    <a href="<?php print RUTA; ?>adminUsuarios/registroUsuario" class="btn btn-primary mx-auto my-3 py-2 fw-bold">
      Registrar Usuario Administrativo</a>
  </div>
  <?php include_once("errores.php"); ?>
</div>