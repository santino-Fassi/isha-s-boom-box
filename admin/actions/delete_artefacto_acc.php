<?php
require_once "../../functions/autoload.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

try {
    $artefacto = Artefacto::get_x_id($id);

    if ($artefacto) {
        Imagen::borrarImagen("../../img/artefactos/" . $artefacto->getImagen());
        $artefacto->delete();
        Alerta::add_alerta("success", "Regateo eliminado", "El regateo fue eliminado del sistema.", false);
    }
    else {
        Alerta::add_alerta("warning", "Registro inexistente", "El regateo solicitado no existe.", false);
    }
} catch (Exception $e) {
    Alerta::add_alerta("danger", "Error al eliminar", "No se pudo eliminar el regateo.", false);
}

header('Location: ../index.php?sec=admin_artefactos');
