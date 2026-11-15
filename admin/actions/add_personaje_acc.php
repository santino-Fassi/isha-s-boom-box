<?php
require_once '../../functions/autoload.php';

$postData = $_POST;
$datosArchivo = $_FILES['imagen'];

try {
    $imagen = Imagen::subirImagen("../../img/personajes", $datosArchivo);

    Personaje::insert(
        $postData['nombre'],
        $postData['alias'],
        $postData['biografia'],
        $postData['faccion'],
        $imagen
    );
} catch (Exception $e) {
    die("No se pudo cargar el personaje.");
}

header('Location: ../index.php?sec=admin_personajes');
