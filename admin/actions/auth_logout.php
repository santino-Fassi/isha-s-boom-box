<?PHP
require_once "../../functions/autoload.php";
$admin = $_GET['admin'] ?? 0;

Autenticacion::log_out();

if($admin){
    header('location: ../index.php?sec=login');
}else{
    header('location: ../../index.php?sec=login');
}
