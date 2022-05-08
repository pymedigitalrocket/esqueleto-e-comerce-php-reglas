<?php include("base.php");?>
<h1 class="text-center my-4 fw-bold">Productos Nuevos</h1>
<div class="container">
    <div class="card border-0 p-4 bg-light">
    <?php
        $reglon = 0;
        $paginas = $data["total"]/4;
        $paginasMasVendidas = $data["totalMasVendido"]/4;
        $paginasDescuento = $data["totalDescuento"]/4;
        if($paginas<=1){
            $paginas = 1;
        }else{
            $paginas = ceil($paginas);
        }
        if($paginasMasVendidas<=1){
            $paginasMasVendidas = 1;
        }else{
            $paginasMasVendidads = ceil($paginasMasVendidas);
        }
        if($paginasDescuento<=1){
            $paginasDescuento = 1;
        }else{
            $pagianasDescuento = ceil($paginasDescuento);
        }
        for($i=0;$i<count($data["catalogo"]); $i++) {
            $precio = $data["catalogo"][$i]["precio"];
            $des = $data["catalogo"][$i]["descuento"];
            $descuento = ($data["catalogo"][$i]["descuento"]*$precio)/100;
            $precioReal = $precio - $descuento;
            if($reglon==0){
                print "<div class='row'>";
            }
            print "<div class='card pt-2 border-0 col-sm-3'>";
            print "<img src='img/".$data['catalogo'][$i]["imagen1"]."' ";
            if(!empty($data["catalogo"][$i]["imagen2"])){
                $imagenNueva = $data["catalogo"][$i]["imagen2"];
                $imagenVieja = $data["catalogo"][$i]["imagen1"];
                print "onmouseover=src='img/".$imagenNueva."' ";
                print "onmouseout=src='img/".$imagenVieja."' ";
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
        <li class="page-item <?php echo $_GET['pagina']<=1 ? 'disabled':'' ?>
        ">
          <?php $paginaAnterior = $_GET['pagina']-1;
                $paginaSiguiente = $_GET['pagina']+1;
          ?>
          <a class="page-link" <?php print "href='".RUTA."tienda?pagina=".$paginaAnterior." '"; ?> aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php for($i=0;$i<$paginas;$i++): ?>
        <?php $indice=$i+1; ?>
        <li class="page-item <?php echo $_GET['pagina']==$indice?'active':'' ?>
        ">
        <a class="page-link" <?php print "href='".RUTA."tienda?pagina=".$indice." '"; ?>><?php print $i+1; ?></a></li>
        <?php endfor ?>
        <li class="page-item <?php echo $_GET['pagina']>=$paginas ? 'disabled':'' ?>
        ">
          <a class="page-link" <?php print "href='".RUTA."tienda?pagina=".$paginaSiguiente." '"; ?> aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
    </div>
</div>

<h1 class="text-center my-4 fw-bold">Productos mas vendidos</h1>
<div class="container">
    <div class="card border-0 p-4 bg-light">
    <?php
        $reglon = 0;
        for($i=0;$i<count($data["datas"]); $i++) {
            $precio = $data["datas"][$i]["precio"];
            $des = $data["datas"][$i]["descuento"];
            $descuento = ($data["datas"][$i]["descuento"]*$precio)/100;
            $precioReal = $precio - $descuento;
            if($reglon==0){
                print "<div class='row'>";
            }
            print "<div class='card pt-2 border-0 col-sm-3'>";
            print "<img src='img/".$data['datas'][$i]["imagen1"]."' ";
            if(!empty($data["datas"][$i]["imagen2"])){
                $imagenNueva = $data["datas"][$i]["imagen2"];
                $imagenVieja = $data["datas"][$i]["imagen1"];
                print "onmouseover=src='img/".$imagenNueva."' ";
                print "onmouseout=src='img/".$imagenVieja."' ";
            }
            print "class='img-responsive' ";
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
        <li class="page-item <?php echo $_GET['masVendido']<=1 ? 'disabled':'' ?>
        ">
          <?php $paginaAnteriorMasVendido = $_GET['masVendido']-1;
                $paginaSiguienteMasVendido = $_GET['masVendido']+1;
          ?>
          <a class="page-link" <?php print "href='".RUTA."tienda?masVendido=".$paginaAnteriorMasVendido." '"; ?> aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php for($i=0;$i<$paginasMasVendidas;$i++): ?>
        <?php $indiceMasVendido=$i+1; ?>
        <li class="page-item <?php echo $_GET['masVendido']==$indiceMasVendido?'active':'' ?>
        ">
        <a class="page-link" <?php print "href='".RUTA."tienda?masVendido=".$indiceMasVendido." '"; ?>><?php print $i+1; ?></a></li>
        <?php endfor ?>
        <li class="page-item <?php echo $_GET['masVendido']>=$paginasMasVendidas ? 'disabled':'' ?>
        ">
          <a class="page-link" <?php print "href='".RUTA."tienda?masVendido=".$paginaSiguiente." '"; ?> aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
    </div>
</div>

<h1 class="text-center my-4 fw-bold">Productos con descuento</h1>
<div class="container">
    <div class="card border-0 p-4 bg-light">
    <?php
        $reglon = 0;
        for($i=0;$i<count($data["descuento"]); $i++) {
            $precio = $data["descuento"][$i]["precio"];
            $des = $data["descuento"][$i]["descuento"];
            $descuento = ($data["descuento"][$i]["descuento"]*$precio)/100;
            $precioReal = $precio - $descuento;
            if($reglon==0){
                print "<div class='row'>";
            }
            print "<div class='card pt-2 border-0 col-sm-3'>";
            print "<img src='img/".$data['descuento'][$i]["imagen1"]."' ";
            if(!empty($data["descuento"][$i]["imagen2"])){
                $imagenNueva = $data["descuento"][$i]["imagen2"];
                $imagenVieja = $data["descuento"][$i]["imagen1"];
                print "onmouseover=src='img/".$imagenNueva."' ";
                print "onmouseout=src='img/".$imagenVieja."' ";
            }
            print "class='img-responsive' ";
            print "alt='".$data['descuento'][$i]["nombre"]."'/>";
            print "<p><a href='".RUTA."productosAdmin/producto/";
            print $data['descuento'][$i]["id"]."'>";
            print $data['descuento'][$i]["nombre"]."</a>"."</p>";
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
            print $data["descuento"][$i]["id"]."/";
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
        <li class="page-item <?php echo $_GET['descuento']<=1 ? 'disabled':'' ?>
        ">
          <?php $paginaAnteriorDescuento = $_GET['descuento']-1;
                $paginaSiguienteDescuento = $_GET['descuento']+1;
          ?>
          <a class="page-link" <?php print "href='".RUTA."tienda?descuento=".$paginaAnteriorDescuento." '"; ?> aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php for($i=0;$i<$paginasDescuento;$i++): ?>
        <?php $indiceDescuento=$i+1; ?>
        <li class="page-item <?php echo $_GET['descuento']==$indiceDescuento?'active':'' ?>
        ">
        <a class="page-link" <?php print "href='".RUTA."tienda?descuento=".$indiceDescuento." '"; ?>><?php print $i+1; ?></a></li>
        <?php endfor ?>
        <li class="page-item <?php echo $_GET['descuento']>=$paginasDescuento ? 'disabled':'' ?>
        ">
          <a class="page-link" <?php print "href='".RUTA."tienda?masVendido=".$paginaSiguiente." '"; ?> aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
    </div>
</div>


<section class="container-sm py-5">
    <div class="row">
        <!-- Chaquetas -->
        <div class="col-md-6">
            <div class="overflow-hidden mb-3 mb-md-0 card border-0">
                <img src="img/modelo chaqueta.png" class="img-fluid">
                <div class="card-img-overlay">
                    <h1 class="card-title">Chaquetas</h1>
                    <h4 class="card-text"><?php print "<a href='".RUTA."tienda/getTipoProducto/3'".">Ver producto >>></a>"; ?></h4>
                </div>
            </div>
        </div>
        <!-- Fin Chaquetas -->

        <!-- Vestidos -->
        <div class="col-md-6">
            <div class="overflow-hidden mb-3 mb-md-0 card border-0">
                <img src="img/modelo vestido.png" class="img-fluid">
                <div class="card-img-overlay">
                    <h1 class="card-title">Vestidos</h1>
                    <h4 class="card-text"><?php print "<a href='".RUTA."tienda/getTipoProducto/1'".">Ver producto >>></a>"; ?></h4>
                </div>
            </div>
            <!-- Fin Vestidos -->

            <!-- Poleras -->
            <div class="overflow-hidden mt-md-4 card border-0">
                <img src="img/modelo polera.png" class="img-fluid mt-xl-3 mt-lg-2  mt-md-1">
                <div class="card-img-overlay">
                    <h1 class="card-title">Poleras</h1>
                    <h4 class="card-text"><?php print "<a href='".RUTA."tienda/getTipoProducto/2'".">Ver producto >>></a>"; ?></h4>
                </div>
            </div>
            <!-- Fin Poleras -->
        </div>
    </div>
</section>
<!-- Fin Categoria -->

<?php include("errores.php");?>