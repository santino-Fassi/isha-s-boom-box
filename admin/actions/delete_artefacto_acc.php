<?php
require_once "../../functions/autoload.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

try {
    $artefacto = Artefacto::get_x_id($id);

    if ($artefacto) {
        Imagen::borrarImagen("../../img/artefactos/" . $artefacto->getImagen());
        $artefacto->delete();
    }
} catch (Exception $e) {
    die("No se pudo eliminar el artefacto.");
}

header('Location: ../index.php?sec=admin_artefactos');
