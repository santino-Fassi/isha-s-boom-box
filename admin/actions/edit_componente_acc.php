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
    Alerta::add_alerta("success", "Componente actualizado", "Los datos se guardaron correctamente.", false);
} catch (Exception $e) {
    Alerta::add_alerta("danger", "Error al editar", "No se pudo actualizar el componente.", false);
}

header('Location: ../index.php?sec=admin_componentes');
