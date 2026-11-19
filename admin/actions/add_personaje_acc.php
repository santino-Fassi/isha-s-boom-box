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
    Alerta::add_alerta("success", "Personaje creado", "El expediente fue registrado correctamente.", false);
} catch (Exception $e) {
    Alerta::add_alerta("danger", "Error al cargar", $e->getMessage(), false);
}

header('Location: ../index.php?sec=admin_personajes');
