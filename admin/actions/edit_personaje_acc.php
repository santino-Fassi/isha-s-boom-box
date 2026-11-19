<?php
require_once "../../functions/autoload.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$postData = $_POST;
$fileData = $_FILES['imagen'] ?? false;

try {
    $personaje = Personaje::get_x_id($id);

    if (!empty($fileData['tmp_name'])) {
        $imagen = Imagen::subirImagen("../../img/personajes", $fileData);
        Imagen::borrarImagen("../../img/personajes/" . $personaje->getImagen());
    } else {
        $imagen = $postData['imagen_og'];
    }

    $personaje->edit(
        $postData['nombre'],
        $postData['alias'],
        $postData['biografia'],
        $postData['faccion'],
        $imagen
    );
    Alerta::add_alerta("success", "Personaje actualizado", "Los datos se actualizaron correctamente.", false);
} catch (Exception $e) {
    Alerta::add_alerta("danger", "Error al editar", $e->getMessage(), false);
}

header('Location: ../index.php?sec=admin_personajes');
