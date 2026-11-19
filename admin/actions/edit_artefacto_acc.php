<?php
require_once "../../functions/autoload.php";

$postData = $_POST;
$fileData = $_FILES['imagen'] ?? false;
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

try {
    $artefacto = Artefacto::get_x_id($id);

    $artefacto->clear_componentes();

    if (isset($postData['componentes'])) {
        foreach ($postData['componentes'] as $componente_id) {
            Artefacto::add_componente($id, (int) $componente_id);
        }
    }

    if (!empty($fileData['tmp_name'])) {
        $imagen = Imagen::subirImagen("../../img/artefactos", $fileData);
        Imagen::borrarImagen("../../img/artefactos/" . $postData['imagen_og']);
    } else {
        $imagen = $postData['imagen_og'];
    }

    $artefacto->edit(
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
    Alerta::add_alerta("success", "Artefacto actualizado", "Los cambios se guardaron correctamente.", false);
} catch (Exception $e) {
    Alerta::add_alerta("danger", "Error al editar", $e->getMessage(), false);
}

header('Location: ../index.php?sec=admin_artefactos');
