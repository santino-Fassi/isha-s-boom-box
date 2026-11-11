<?PHP
require_once "../../functions/autoload.php";

$id = $_GET['id'] ?? FALSE;

try {
    $personaje = Personaje::get_x_id($id);
   
    $personaje->delete();

    if (!empty($personaje->getImagen())) {
        Imagen::borrarImagen("../../img/personajes/" . $personaje->getImagen());
    }
} catch (Exception $e) {
    
    // echo "<pre>";
    // print_r($e);
    // echo "</pre>";
    die("No se pudo eliminar el personaje =(");
}
header('Location: ../index.php?sec=admin_personajes');
