<?php
require_once "../../functions/autoload.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$postData = $_POST;

try {
    $regateo = Regateo::get_x_id($id);

    $regateo->edit(
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
} catch (Exception $e) {
    die("No se pudo editar el regateo.");
}

header('Location: ../index.php?sec=admin_regateos');