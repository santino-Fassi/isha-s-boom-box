<?php
require_once '../../functions/autoload.php';

$postData = $_POST;

try {
    Regateo::insert(
        (int) $postData['personaje_id'],
        $postData['personalidad'],
        $postData['mensaje_1'],
        $postData['opcion_tecnica_1'],
        $postData['opcion_frontal_1'],
        $postData['opcion_caotica_1'],
        $postData['mensaje_2'],
        $postData['opcion_tecnica_2'],
        $postData['opcion_frontal_2'],
        $postData['opcion_caotica_2'],
        $postData['mensaje_3'],
        $postData['opcion_tecnica_3'],
        $postData['opcion_frontal_3'],
        $postData['opcion_caotica_3'],
        $postData['estrategia_correcta'],
        $postData['estrategia_intermedia'],
        $postData['respuesta_exito'],
        $postData['respuesta_neutral'],
        $postData['respuesta_fallo']
    );
    Alerta::add_alerta("success", "Regateo creado", "El regateo fue registrado correctamente.", false);
} catch (Exception $e) {
    Alerta::add_alerta("danger", "Error al cargar", "No se pudo cargar el regateo en la base de datos.", false);
}

header('Location: ../index.php?sec=admin_regateos');