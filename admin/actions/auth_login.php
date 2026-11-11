<?PHP
require_once "../../functions/autoload.php";

$postData = $_POST;

$login = Autenticacion::log_in($postData['username'], $postData['pass']);


if ($login) {

    if ($login == "usuario") {
        header('location: ../../index.php?sec=catalogo_completo');
    } else {
        header('location: ../index.php?sec=dashboard');
    }
} else {
    header('location: ../../index.php?sec=login');
}
