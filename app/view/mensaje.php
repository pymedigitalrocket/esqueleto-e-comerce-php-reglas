<?php include_once("base.php");

print "<h2 class='text-center my-2'>".$data["subtitulo"]."</h2>";
print "<div class='alert text-center fw-bold ".$data["color"]." mt-3'>";
print $data["texto"];
print "</div>";
print "<a href='".RUTA.$data["url"]."' class='btn mx-3 fw-bold px-5 py-2 ".$data["colorBtn"]."'/>";
print $data["textoBtn"]."</a>";