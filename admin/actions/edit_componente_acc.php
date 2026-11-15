<?php
require_once "../../functions/autoload.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$postData = $_POST;

try {
    $componente = Componente::get_x_id($id);


    $componente->edit(
        $postData['nombre'],
        $postData['descripcion'],
    );
} catch (Exception $e) {
    die("No se pudo editar el componente.");
}

header('Location: ../index.php?sec=admin_componentes');
