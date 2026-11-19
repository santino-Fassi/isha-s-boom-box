<?php
require_once "../../functions/autoload.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$postData = $_POST;

try {
    $categoria = Categoria::get_x_id($id);


    $categoria->edit(
        $postData['nombre'],
        $postData['descripcion'],
    );
    Alerta::add_alerta("success", "Categoría actualizada", "Los datos se guardaron correctamente.", false);
} catch (Exception $e) {
    Alerta::add_alerta("danger", "Error al editar", "No se pudo actualizar la categoría.", false);
}

header('Location: ../index.php?sec=admin_categorias');
