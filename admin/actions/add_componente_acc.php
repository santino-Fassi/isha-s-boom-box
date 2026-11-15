<?php
require_once '../../functions/autoload.php';

$postData = $_POST;

try {
    Componente::insert(
        $postData['nombre'],
        $postData['descripcion']
    );
} catch (Exception $e) {
    die("No se pudo cargar el componente.");
}

header('Location: ../index.php?sec=admin_componentes');
