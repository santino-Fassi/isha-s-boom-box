<?php
require_once "../../functions/autoload.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

try {
    $regateo = Regateo::get_x_id($id);
    if ($regateo) {
        $regateo->delete();
        Alerta::add_alerta("success", "Artefacto eliminado", "El artefacto fue eliminado del inventario.", false);
    }
    else {
        Alerta::add_alerta("warning", "Registro inexistente", "El artefacto solicitado no existe.", false);
    }
} catch (Exception $e) {
    Alerta::add_alerta("danger", "Error al eliminar", "No se pudo eliminar el artefacto.", false);
}

header('Location: ../index.php?sec=admin_regateos');