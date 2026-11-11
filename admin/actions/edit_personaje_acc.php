
<?PHP
require_once "../../functions/autoload.php";

$id = $_GET['id'] ?? FALSE;

$postData = $_POST;
$fileData = $_FILES['imagen'];


echo "<pre>";
print_r($postData);
echo "</pre>";

echo "<pre>";
print_r($fileData);
echo "</pre>";

echo "<pre>";
print_r($id);
echo "</pre>";


try {

    $personaje = Personaje::get_x_id($id);

    if (!empty($fileData['tmp_name'])) {
        //EL USUARIO DECIDIÓ REEMPLAZAR LA IMÁGEN
        $imagen = Imagen::subirImagen("../../img/personajes", $fileData);
        Imagen::borrarImagen("../../img/personajes/" . $personaje->getImagen());
    } else {
        //EL USUARIO DECIDIÓ NO TOCAR LA IMÁGEN
        $imagen = $postData['imagen_og'];
    }

    $personaje->edit(
        $postData['nombre'],
        $postData['alias'],
        $postData['creador'],
        $postData['primera_aparicion'],
        $postData['bio'],
        $imagen
    );
} catch (Exception $e) {
    // echo "<pre>";
    // print_r($e);
    // echo "</pre>";
    die("No se pudo editar el personaje =(");
}

header('Location: ../index.php?sec=admin_personajes');
