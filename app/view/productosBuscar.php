<?php include("base.php");?>

<h1 class="text-center my-4 fw-bold">Productos Encontrados</h1>
<div class="alert-succes text-center fw-bold mt-3">
    <?php if(count($data["datas"])==0){
                print "<p class='lead'>No se encontraron resultados</p>";
            }else{
                print "<p class='lead'>se han encontrado ".count($data["datas"])." resultados</p>";
            }
    ?>
</div>
<div class="container">
    <div class="card border-0 p-4 bg-light">
    <?php
        $reglon = 0;
        $paginas = $data["total"]/4;
        $paginas = ceil($paginas);
        for($i=0;$i<count($data["datas"]); $i++) {
            $precio = $data["datas"][$i]["precio"];
            $des = $data["datas"][$i]["descuento"];
            $descuento = ($data["datas"][$i]["descuento"]*$precio)/100;
            $precioReal = $precio - $descuento;
            if($reglon==0){
                print "<div class='row'>";
            }
            print "<div class='card pt-2 border-0 col-sm-3'>";
            print "<img src='".RUTA."img/".$data['datas'][$i]["imagen1"]."' ";
            if(!empty($data["datas"][$i]["imagen2"])){
                $imagenNueva = $data["datas"][$i]["imagen2"];
                $imagenVieja = $data["datas"][$i]["imagen1"];
                print "onmouseover=src='".RUTA."img/".$imagenNueva."' ";
                print "onmouseout=src='".RUTA."img/".$imagenVieja."' ";
            }
            print "class='img-responsive' ' ";
            print "alt='".$data['datas'][$i]["nombre"]."'/>";
            print "<p><a href='".RUTA."productosAdmin/producto/";
            print $data['datas'][$i]["id"]."'>";
            print $data['datas'][$i]["nombre"]."</a>"."</p>";
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
            print $data["datas"][$i]["id"]."/";
            if(isset($_SESSION["usuario"])){
                $idUsuario = $_SESSION["usuario"]["id"];
                print $idUsuario."' ";
            }else{
                $idUsuario = $_SESSION["temporal"];
                print $idUsuario."' ";
            }
            print "class='btn btn-success fw-bold px-5 py-2 me-2 mb-2'/>Agregar al carro</a>";
            print "</div>";
            $reglon++;
            if($reglon==4){
                $reglon = 0;
                print "</div>";
            }
        }
    ?>
    <nav aria-label="Page navigation example">
      <ul class="pagination mt-3">
        <li class="page-item <?php echo $_GET['numeroBuscar']<=1 ? 'disabled':'' ?>
        ">
          <?php if(isset($_GET['numeroBuscar'])){
              $paginaAnterior = $_GET['numeroBuscar']-1;
              $paginaSiguiente = $_GET['numeroBuscar']+1;
            } 
            $cadenaBuscar = $data["buscar"];
          ?>
          <a class="page-link" href="<?php echo RUTA;?>buscar/producto?numeroBuscar=<?php echo $paginaAnterior; ?>&buscar=<?php echo $cadenaBuscar?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php for($i=0;$i<$paginas;$i++): ?>
        <?php $indice=$i+1; ?>
        <li class="page-item <?php echo $_GET['numeroBuscar']==$indice?'active':'' ?>
        ">
        <a class="page-link" href="<?php echo RUTA;?>buscar/producto?numeroBuscar=<?php echo $indice; ?>&buscar=<?php echo $cadenaBuscar?>"><?php print $i+1; ?></a></li>
        <?php endfor ?>
        <li class="page-item <?php echo $_GET['numeroBuscar']>=$paginas ? 'disabled':'' ?>
        ">
          <a class="page-link" href="<?php echo RUTA;?>buscar/producto?numeroBuscar=<?php echo $paginaSiguiente; ?>&buscar=<?php echo $cadenaBuscar?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
    </div>
</div>

<?php include("errores.php");?>