<?PHP
require_once "../../functions/autoload.php";

$postData = $_POST;
$datosArchivo = $_FILES['portada'];


echo "<pre>";
print_r($postData);
echo "</pre>";



try {
    //1- Subo la portada, me guardo el nombre de archivo
    $portada = Imagen::subirImagen("../../img/covers", $datosArchivo);
    //2- Inserto un registro en la tabla comics, y me guardo el ID recien insertado.
    $idComic = Comic::insert(
        $postData['titulo'],
        $postData['personaje_principal_id'],
        $postData['serie_id'],
        $postData['guionista_id'],
        $postData['artista_id'],
        $postData['volumen'],
        $postData['numero'],
        $postData['publicacion'],
        $postData['origen'],
        $postData['editorial'],
        $postData['bajada'],
        $portada,
        $postData['precio']
    );
    //3- Uso ese ID de comic para crear tantos registros de PS como correspondan (O ninguno si no se seleccionaron.)
    if (isset($postData['personajes_secundarios'])) {
        foreach ($postData['personajes_secundarios'] as $personaje_id) {
            Comic::add_personajes_sec($idComic, $personaje_id);
        }
    }

} catch (Exception $e) {
    die("No se pudo cargar el Comic D=");
}

header('Location: ../index.php?sec=admin_comics');
