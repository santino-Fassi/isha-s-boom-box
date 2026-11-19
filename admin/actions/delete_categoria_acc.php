<?php
require_once "../../functions/autoload.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

try {
    $categoria = Categoria::get_x_id($id);

    if ($categoria) {
        $categoria->delete();
        Alerta::add_alerta("success", "Categoría eliminada", "La categoría fue eliminada del sistema.", false);
    }

} catch (Exception $e) {
    switch ($e->getCode()) {
        case 23000:
            Alerta::add_alerta("danger", "Eliminación bloqueada", "No se pudo eliminar la categoría porque existen artefactos asociados a ella.", false);
        default:
            Alerta::add_alerta("danger", "Error al eliminar", "No se pudo eliminar la categoría.", false);
    }
}

header('Location: ../index.php?sec=admin_categorias');
