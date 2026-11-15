<?php
require_once "../../functions/autoload.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

try {
    $personaje = Personaje::get_x_id($id);

    if ($personaje) {
        $personaje->delete();

        if (!empty($personaje->getImagen())) {
            Imagen::borrarImagen("../../img/personajes/" . $personaje->getImagen());
        }
    }
} catch (Exception $e) {
    die("No se pudo eliminar el personaje.");
}

header('Location: ../index.php?sec=admin_personajes');
