<?PHP

class Imagen
{
    public static function subirImagen(string $directorio, array $datosArchivo): string
    {

        //le damos un nuevo nombre
        $og_name = explode(".", $datosArchivo['name']);
        $extension = end($og_name);
        $filename = time() . ".$extension";

        $fileUpload = move_uploaded_file(
            $datosArchivo['tmp_name'],
            "$directorio/$filename"
        );

        if (!$fileUpload) {
            throw new Exception("No de pudo subir la imágen");
        } else {
            return $filename;
        }
    }

      public static function borrarImagen( string $archivo): bool
    {

        if (file_exists($archivo)) {

            $fileDelete =  unlink($archivo);

            if (!$fileDelete) {
                throw new Exception("No se pudo eliminar la imagen");
            } else {
                return TRUE;
            }
        }else{
            return FALSE;
        }
    }
}
