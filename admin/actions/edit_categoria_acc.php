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
} catch (Exception $e) {
    die("No se pudo editar la categoría.");
}

header('Location: ../index.php?sec=admin_categorias');
