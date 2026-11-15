<?php
require_once "../../functions/autoload.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

try {
    $categoria = Categoria::get_x_id($id);

    if ($categoria) {
        $categoria->delete();
    }

} catch (Exception $e) {
    switch ($e->getCode()) {
        case 23000:
            die("No se pudo eliminar la categoría, ya que hay artefactos usando la categoría.");
        default:
            die("No se pudo eliminar la categoría.");
    }
}

header('Location: ../index.php?sec=admin_categorias');
