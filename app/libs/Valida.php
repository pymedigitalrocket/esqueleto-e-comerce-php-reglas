<?php

class Valida{
    function __construct(){

    }

    public static function validaNumeros($cadena) {
        $buscar = array(' ', '$', ',');
        $remplazar = array('', '', '');
        $numero = str_replace($buscar, $remplazar, $cadena);
        return $numero;
    }

    public static function fecha($cadena) {
        $fecha = explode('-', $cadena);
        return checkdate($fecha[0],$fecha[1], $fecha[2]);
    }

    public static function fechaDia($cadena) {
        $hoy = date_create('now');
        $fecha = date_create($cadena);
        return ($fecha>$hoy);
    }

    public static function archivo($cadena) {
        $buscar = array(' ', '*', '!', '@', '?', 'á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'Ü', 'ü', '¿', '¡');
        $remplazar = array('-', '', '', '', '', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N', 'U', 'u', '', '');
        $cadena = str_replace($buscar, $remplazar, $cadena);
        return $cadena;
    }

    public static function esImagen($imagen, $anchoNuevo, $alturaNueva){
        $archivo = "img/".$imagen;
        $info = getimagesize($archivo);
        $ancho = $info['0'];
        $altura = $info['1'];
        $tipo = $info['mime'];
        $imagen = imagecreatefromjpeg($archivo);
        $lienzo = imagecreatetruecolor($anchoNuevo, $alturaNueva);
        imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $anchoNuevo, $alturaNueva, $ancho, $altura);
        imagejpeg($lienzo, $archivo, 100);
    }

    public static function cadena($cadena) {
        //$cadena = escapeshellcmd($cadena);
        $buscar = array('^', 'delete', 'drop', 'truncate', 'exec', 'system','<script>','</script>','<script></script>');
        $remplazar = array('-', 'dele*te', 'dr*op', 'truneca*te', 'ex*ec', 'syst*em','','','');
        $cadena = str_replace($buscar, $remplazar, $cadena);
        $cadena = addslashes(htmlentities($cadena));
        return $cadena;
    }

    public static function archivoImagen($archivo){
        $imagen = getimagesize($archivo);
        $imagenTipo = $imagen[2];
        return (bool)(in_array($imagenTipo, array(IMAGETYPE_JPEG, IMAGETYPE_PNG)));
    }

    public static function validaCodigoCelular($cadena){
        $codigo = substr($cadena, 0, 3);
        if($codigo=="+56"){
            return true;
        }
        return false;
    }
}
?>