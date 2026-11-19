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
        Alerta::add_alerta("success", "Personaje eliminado", "El personaje fue eliminado del sistema.", false);
    }
    else {
        Alerta::add_alerta("warning", "Registro inexistente", "El personaje solicitado no existe.", false);
    }
} catch (Exception $e) {
    Alerta::add_alerta("danger", "Error al eliminar", "No se pudo eliminar el personaje.", false);
}

header('Location: ../index.php?sec=admin_personajes');
