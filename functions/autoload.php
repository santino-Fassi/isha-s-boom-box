<?php
session_start();

/**
 * Carga automáticamente el archivo de la clase solicitada dentro del directorio classes.
 *
 * @param string $nombreClase Nombre de la clase a incluir.
 * @return void
 */
function autoloadClasses(string $nombreClase): void
{
    $archivoClase = __DIR__ . "/../classes/$nombreClase.php";

    if (file_exists($archivoClase)) {
        require_once $archivoClase;
    } else {
        die("No se pudo cargar la clase: $nombreClase");
    }
}

spl_autoload_register('autoloadClasses');
