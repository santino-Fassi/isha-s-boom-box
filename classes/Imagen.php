<?php

class Imagen
{
    /**
     * Sube un archivo de imagen al directorio indicado asignándole un nombre único basado en timestamp.
     *
     * @param string $directorio Ruta de la carpeta de destino.
     * @param array $datosArchivo Datos del archivo recibido mediante $_FILES.
     * @return string Nombre final del archivo almacenado.
     * @throws Exception Si falla el movimiento del archivo al directorio de destino.
     */
    public static function subirImagen(string $directorio, array $datosArchivo): string
    {
        $og_name = explode(".", $datosArchivo['name']);
        $extension = end($og_name);
        $filename = time() . ".$extension";

        $fileUpload = move_uploaded_file(
            $datosArchivo['tmp_name'],
            "$directorio/$filename"
        );

        if (!$fileUpload) {
            throw new Exception("No se pudo subir la imagen.");
        }

        return $filename;
    }

    /**
     * Elimina un archivo de imagen físico del servidor si existe.
     *
     * @param string $archivo Ruta completa al archivo a eliminar.
     * @return bool True si se eliminó correctamente, false si el archivo no existía.
     * @throws Exception Si ocurre un error al intentar borrar el archivo existente.
     */
    public static function borrarImagen(string $archivo): bool
    {
        if (file_exists($archivo)) {
            $fileDelete = unlink($archivo);

            if (!$fileDelete) {
                throw new Exception("No se pudo eliminar la imagen.");
            }

            return true;
        }

        return false;
    }
}
