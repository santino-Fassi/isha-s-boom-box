<?php
require_once '../../functions/autoload.php';

$postData = $_POST;

try {
    Categoria::insert(
        $postData['nombre'],
        $postData['descripcion']
    );
    Alerta::add_alerta("success", "Categoría creada", "La categoría fue registrada correctamente.", false);
} catch (Exception $e) {
    Alerta::add_alerta("danger", "Error al cargar", "No se pudo registrar la categoría en la base de datos.", false);
}

header('Location: ../index.php?sec=admin_categorias');
