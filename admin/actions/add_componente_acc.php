<?php
require_once '../../functions/autoload.php';

$postData = $_POST;

try {
    Componente::insert(
        $postData['nombre'],
        $postData['descripcion']
    );
    Alerta::add_alerta("success", "Componente creado", "El componente fue registrado correctamente.", false);
} catch (Exception $e) {
    Alerta::add_alerta("danger", "Error al cargar", "No se pudo registrar el componente en la base de datos.", false);
}

header('Location: ../index.php?sec=admin_componentes');
