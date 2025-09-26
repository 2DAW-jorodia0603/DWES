<?php

/* Inicialización del entorno */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Zona de declaración de funciones */
//Funciones de debugueo
function dump($var){
    echo '<pre>'.print_r($var,1).'</pre>';
}
//Funciones lógica de negocio
function leerArchivoCSV($archivoCSV) {
    $tablero = [];

    if (($puntero = fopen($archivoCSV, "r")) !== FALSE) {
        while (($datosFila = fgetcsv($puntero)) !== FALSE) {
            $tablero[] = $datosFila;
        }
        fclose($puntero);
    }

    return $tablero;
}

//function getPosGansuno(){
//    return random_int(0,144);
//}

function getFilaPosGansuno(){
    if (isset($_GET['fila'])) {
        return $_GET['fila'];
    }
}

function getColumnaPosGansuno(){
    if (isset($_GET['columna'])) {
        return $_GET['columna'];
    }
}



    
//Función lógica presentación
function getTableroMarkup ($tablero, $posGansuno){
    $contador = 0;
    $output = '';
    
    foreach ($tablero as $filaIndex => $datosFila) {
        foreach ($datosFila as $columnaIndex => $tileType) {
            
            $contador++;
            //Si tengo que pintar aquí al gansuno...
            if($contador == $posGansuno){      
                $output .= '<div class = "tile ' . $tileType . '"> <img src="pesitas.png" style= "width: 50px; height: 50px;"/></div>';
            }else{
                //Si no tengo que pintar al gansuno...
                $output .= '<div class = "tile ' . $tileType . '"></div>';
            }
        }
    }

    return $output;

}
//Lógica de negocio
//El tablero es un array bidimensional en el que cada fila contiene 12 palabras cuyos valores pueden ser:
// agua
//fuego
//tierra
// hierba


$tablero = leerArchivoCSV('contenido_tablero/contenido.csv');
$posFilaGansuno = getFilaPosGansuno();
$posColumnaGansuno = getColumnaPosGansuno();
$posGansuno = (($posFilaGansuno*12-12) + ($posColumnaGansuno));

//Lógica de presentación
$tableroMarkup = getTableroMarkup($tablero, $posGansuno);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablero</title>
    <style>
        .contenedorTablero {
            width: 600px;
            height: 600px;
            border-radius: 5px;
            border: solid 2px grey;
            box-shadow: grey;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: repeat(12, 1fr);
        }
        .tile {
            width: 50px;
            height: 50px;
            float: left;
            margin: 0;
            padding: 0;
            border-width: 0;
            background-size: 209px;
            background-image: url('464.jpg');
        }
        .fuego {
            background-position: 104px -52px;
        }
        .tierra {
            background-position: 104px -156px;
        }
        .agua {
            background-position: -52px 0px;
        }
        .hierba {
            background-position: -52px 52px;
        }
    </style>
</head>
<body>
    <h1>Tablero juego super rol DWES</h1>
    <div class="contenedorTablero">
        <?php echo $tableroMarkup; ?>
    </div>
</body>
</html>