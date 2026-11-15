<?php
require_once "../../functions/autoload.php";

$postData = $_POST;
$datosArchivo = $_FILES['imagen'];

try {
    $imagen = Imagen::subirImagen("../../img/artefactos", $datosArchivo);

    $idArtefacto = Artefacto::insert(
        $postData['nombre'],
        $postData['alias'],
        (int) $postData['categoria_id'],
        (int) $postData['personaje_creador_id'],
        (int) $postData['personaje_usuario_id'],
        $postData['origen'],
        (int) $postData['nivel_peligro'],
        $postData['fecha_fabricacion'],
        $postData['descripcion'],
        $imagen,
        (float) $postData['precio'],
        (bool) $postData['robado']
    );

    if (isset($postData['componentes'])) {
        foreach ($postData['componentes'] as $componente_id) {
            Artefacto::add_componente($idArtefacto, (int) $componente_id);
        }
    }
} catch (Exception $e) {
    die("No se pudo cargar el artefacto.");
}

header('Location: ../index.php?sec=admin_artefactos');
