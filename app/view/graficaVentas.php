<?php include_once("base.php"); ?>

<form class="mx-5 row" action="<?php print RUTA; ?>carro/grafica/" method="GET">
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


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['bar']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(grafica);

    function grafica() {
        var data = google.visualization.arrayToDataTable([
            <?php
            if($data["productos"]==1){
                print "['Productos', 'Ventas'],";
            #}else if($data["categoria"==1]){
                #print "['Categorias', 'Ventas'],";
            }else{
                print "['Fecha', 'Ventas'],";
            }
            ?>
        <?php
        $n = count($data["datas"]);
        for($i = 0; $i < $n; $i++) {
            if(isset($data["datas"][$i]["nombre_producto"])){
                print "['".$data["datas"][$i]["nombre_producto"]."', ";
                print $data["datas"][$i]["total"]."]";
                if($i<$n) print ",";
            }else if(isset($data["datas"][$i]["categoria"])){
                print "['".$data["catalogo"][$i]["cadena"]."', ";
                print $data["datas"][$i]["total"]."]";
                if($i<$n) print ",";
            }else{
                print "['".$data["datas"][$i]["fecha"]."', ";
                print $data["datas"][$i]["total"]."]";
                if($i<$n) print ",";
            }
        }
        ?>
        ]);
        var opciones = {
            chart: {
                <?php
                if($data["productos"]==1){
                    print "title: 'Ventas por producto',";
                    print "subtitle: 'Tienda virtual'";
                }else if($data["categoria"]==1){
                    print "title: 'Ventas por categoria',";
                    print "subtitle: 'Tienda virtual'";
                }else{
                    print "title: 'Ventas por dia',";
                    print "subtitle: 'Tienda virtual'";
                } 
                ?>
            },
            colors: ["orange"],
            fontSize: 25,
            fontName:"Times",
            bars:"horizontal",
            height:400,
            hAxis:{
                title:"Ventas $(CLP)",
                titleTextStyle:{color:"blue", fontSize:"30"},
                textPosition:"out",
                textStyle:{color:"red", fontSize:20, bold:true,italic:true}
            },
            vAxis: {
                <?php
                if($data["productos"]==1){
                    print "title:'Productos',";
                }else if($data["categoria"]==1){
                    print "title:'Categoria',";
                }else{
                    print "title:'Fecha',";
                } 
                ?>
                titleTextStyle:{color:"blue", fontSize:30},
                textPosition:"out",
                textStyle:{color:"blue", fontSize:20, bold:true,italic:true},
                gridlines: {color:"gray"}
            }
        }

        var chart = new google.charts.Bar(document.getElementById("grafica"));
        chart.draw(data, google.charts.Bar.convertOptions(opciones));
    }
</script>

<div class="container mt-4"><div id="grafica"></div></div>

<?php include_once("errores.php"); ?>

<?php
$paginas = $data["total"]/8;
$paginas = ceil($paginas);
?>
<div class="container col-auto">
    <nav aria-label="Page navigation example">
      <ul class="pagination mt-3">
        <li class="page-item <?php echo $_GET['grafica']<=1 ? 'disabled':'' ?>
        ">
          <?php $paginaAnterior = $_GET['grafica']-1;
                $paginaSiguiente = $_GET['grafica']+1;
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
          <a class="page-link" href="<?php echo RUTA;?>carro/grafica?grafica=<?php echo $paginaAnterior; ?>&fechaInicio=<?php echo $fechaInicio?>&fechaMaxima=<?php echo $fechaMaxima ?>&productos=<?php echo $productos ?>&categoria=<?php echo $categoria ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php for($i=0;$i<$paginas;$i++): ?>
        <?php $indice=$i+1; ?>
        <li class="page-item <?php echo $_GET['grafica']==$indice?'active':'' ?>
        ">
        <a class="page-link" href="<?php echo RUTA;?>carro/grafica?grafica=<?php echo $indice; ?>&fechaInicio=<?php echo $fechaInicio?>&fechaMaxima=<?php echo $fechaMaxima ?>&productos=<?php echo $productos ?>&categoria=<?php echo $categoria ?>"><?php print $i+1; ?></a></li>
        <?php endfor ?>
        <li class="page-item <?php echo $_GET['grafica']>=$paginas ? 'disabled':'' ?>
        ">
          <a class="page-link" href="<?php echo RUTA;?>carro/grafica?grafica=<?php echo $paginaSiguiente; ?>&fechaInicio=<?php echo $fechaInicio?>&fechaMaxima=<?php echo $fechaMaxima ?>&productos=<?php echo $productos ?>&categoria=<?php echo $categoria ?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
</div>