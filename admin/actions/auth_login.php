<?php
require_once "../../functions/autoload.php";

$postData = $_POST;

$login = Autenticacion::log_in($postData['username'] ?? '', $postData['pass'] ?? '');

if ($login) {
    if ($login === "usuario") {
        header('Location: ../../index.php?sec=catalogo_completo');
    } else {
        header('Location: ../index.php?sec=dashboard');
    }
} else {
    header('Location: ../../index.php?sec=login');
}
