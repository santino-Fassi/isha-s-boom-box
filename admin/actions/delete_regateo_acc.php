<?php
require_once "../../functions/autoload.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

try {
    $regateo = Regateo::get_x_id($id);
    if ($regateo) {
        $regateo->delete();
    }
} catch (Exception $e) {
    die("No se pudo eliminar el regateo.");
}

header('Location: ../index.php?sec=admin_regateos');