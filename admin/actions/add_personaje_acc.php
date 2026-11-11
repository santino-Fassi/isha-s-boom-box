<?PHP
require_once '../../functions/autoload.php';

$postData = $_POST;
$datosArchivo = $_FILES['imagen'];

// echo "<pre>";
// print_r($postData);
// echo "</pre>";

echo "<pre>";
print_r($datosArchivo);
echo "</pre>";

//SUBIR la imágen ar servidor
//Obtener el nombre y ubicación de la imágen en el servidor
//Insertar los datos en BBDD




try {

    //Subo lo imágen
    $imagen = Imagen::subirImagen("../../img/personajes", $datosArchivo);

    //Inserto los datos en la BBDD    
    Personaje::insert(
        $postData['nombre'],
        $postData['alias'],
        $postData['creador'],
        $postData['primera_aparicion'],
        $postData['bio'],
        $imagen
    );
} catch (Exception $e) {
    //throw $th;
    die("No se pudo cargar el personaje =(");
}

header('Location: ../index.php?sec=admin_personajes');
