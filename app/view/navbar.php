<!-- NavBar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="
        <?php  
            if($data["admin"]){
                if($_SESSION["usuario"]){
                    print RUTA.'adminUsuarios';   
                }
            }else{
                print RUTA."tienda";
            }
        ?>"><?php print $data["tituloMenu"]; ?></a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php if($data["menu"]){
                print "<ul class='navbar-nav me-auto mt-2 mt-lg-0'>";
                print "<li class='nav-item'>";
                print "<li class='nav-item'>";
                print "<a href='".RUTA."sobreNosotros' class='nav-link ";
                if(isset($data["activo"]) && $data["activo"]=="sobreNosotros") print "active";
                print "'>Sobre Nosotros</a>";
                print "</li>";
                print "<li class='nav-item'>";
                print "<a href='".RUTA."contacto' class='nav-link ";
                if(isset($data["activo"]) && $data["activo"]=="contacto") print "active";
                print "'>Contacto</a>";
                print "</li>";
                print "</ul>";
                print "<ul class='navbar-nav navbar-right'>";
                if(isset($_SESSION["usuario"])){
                    print "<li class='nav-item'>";
                    print "<a href='".RUTA."tienda/logout' class='nav-link ";
                    print "'>Cerrar Sesion</a>";
                    print "</li>";
                }else{
                    print "<li class='nav-item'>";
                    print "<a href='".RUTA."login' class='nav-link ";
                    print "'>Login</a>";
                    print "</li>";
                    print "<li class='nav-item'>";
                    print "<a href='".RUTA."login/registro' class='nav-link ";
                    print "'>Crear cuenta</a>";
                    print "</li>";   
                }
                print "</ul>";
            }
            if(isset($data["adminMenu"])){
                if($data["adminMenu"]){
                    print "<ul class='navbar-nav me-auto mt-2 mt-lg-0'>";
                    print "<li class='nav-item'>";
                    print "<a href='".RUTA."adminUsuarios' class='nav-link'>Usuarios</a>";
                    print "</li>";
                    print "<li class='nav-item'>";
                    print "<a href='".RUTA."adminClientes' class='nav-link'>Clientes</a>";
                    print "</li>";
                    print "<li class='nav-item'>";
                    print "<a href='".RUTA."productosAdmin' class='nav-link'>Productos</a>";
                    print "</li>";
                    print "<li class='nav-item'>";
                    print "<a href='".RUTA."carro/ventas' class='nav-link'>Gestor de ventas</a>";
                    print "</li>";
                    print "</ul>";
                    print "<ul class='navbar-nav navbar-right'>";
                    print "<li class='nav-item'>";
                    print "<a href='".RUTA."admin/logout' class='nav-link ";
                    print "'>Cerrar Sesion</a>";
                    print "</li>";
                    print "</ul>";
                }
            }
            ?>
        <!-- Fin Links -->
        </div>
        <?php if($data["menu"]){
            print "<a class='icon ion-md-cart fs-2 text-white mx-1' href='".RUTA."carro'>";
            if(isset($_SESSION["carro"])&&$_SESSION["carro"]>0){
                print "<small class='text-danger'>".number_format($_SESSION["carro"],0)."</small>";
            }
            print "</a>";
            print "<div class='mx-lg-0 mx-xl-5'>";
            print "<form method='GET' action='".RUTA."buscar/producto' class='d-flex'>";
            if(isset($_GET["buscar"])){
                print " <input type='search' name='buscar' id='buscar'"." value="."'".$_GET["buscar"]."' ";
            }
            if(isset($data["buscar"])){
                print " <input type='search' name='buscar' id='buscar'"." value="."'".$data["buscar"]."' ";
            }else{
                print " <input type='search' name='buscar' id='buscar'";
            }
            print "class='form-control me-2 fw-bold' placeholder='buscar producto' aria-label='buscar producto'>";
            print "<button type='submit' class='btn btn-success'><i class='icon ion-md-search fs-5'></i></button>";
            print "</form>";
            print "</div>";
        }?>
    </div>
</nav>
<!-- Fin NavBar -->