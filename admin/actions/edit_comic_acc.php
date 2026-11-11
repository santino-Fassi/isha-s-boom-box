<?PHP
require_once "../../functions/autoload.php";

$postData = $_POST;
$fileData = $_FILES['portada'] ?? FALSE;
$id = $_GET['id'] ?? FALSE;

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
    $comic = Comic::get_x_id($id);

    $comic->clear_personajes_sec();

    if (isset($postData['personajes_secundarios'])) {
        foreach ($postData['personajes_secundarios'] as $personaje_id) {
            $comic->add_personajes_sec($id, $personaje_id);
        }
    }

    if (!empty($fileData['tmp_name'])) {
        $portada = Imagen::subirImagen("../../img/covers", $fileData);
        Imagen::borrarImagen("../../img/covers/" . $postData['portada_og']);
    } else {
        $portada = $postData['portada_og'];
    }


    $comic->edit(
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
        $postData['precio'],
        $portada
    );

} catch (Exception $e) {
    die("No se pudo editar el Comic =(");
}

header('Location: ../index.php?sec=admin_comics');
