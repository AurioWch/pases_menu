<?php

function connection(){
    
    //VARIABLES PARA LA CONEXION PDO
    $cadena="mysql:host=localhost;dbname=gym_data";
    $usuario="root";
    $clave="";
    //INSTANCIANDO UN OBJETO DE LA CLASE PDO
    $cnx = new PDO($cadena,$usuario,$clave);
    //CONFIGURAR EL JUEGO DE CARACTERES
    $cnx->exec("SET CHARACTER SET UTF8");

    return $cnx;
}


?>