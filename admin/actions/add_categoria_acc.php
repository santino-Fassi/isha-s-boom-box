<?php
require_once '../../functions/autoload.php';

$postData = $_POST;

try {
    Categoria::insert(
        $postData['nombre'],
        $postData['descripcion']
    );
} catch (Exception $e) {
    die("No se pudo cargar la categoría.");
}

header('Location: ../index.php?sec=admin_categorias');
