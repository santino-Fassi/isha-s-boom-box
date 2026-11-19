<?php

class Alerta {


    /**
     * Registra una alerta, guardándola en la sesión.
     * @param string $tipo Tipo de alerta (success, warning o danger).
     * @param string $titulo Título de la alerta.
     * @param string $mensaje Contenido de la alerta.
     * @param bool $front Define si la alerta se debe mostrar con estilo del frontend o backend (frontend por defecto).
     * @return void
     */
    public static function add_alerta(string $tipo, string $titulo, string $mensaje, bool $front = true) {
        $_SESSION["alertas"][] = [
            "tipo" => $tipo,
            "titulo" => $titulo,
            "mensaje" => $mensaje,
            "front" => $front
        ];
    }

    /**
     * Limpia la lista de alertas.
     * @return void
     */
    public static function clear_alertas() {
        $_SESSION["alertas"] = [];
    }

    /**
     * Muestra la alerta dada.
     * @param array $alerta información de la alerta a mostrar.
     * @return void
     */
    private static function show_alerta(array $alerta): string {
        $estilo = $alerta["front"] ? "front" : "back";
        $html = "<div class='alert alert-{$alerta['tipo']} alert-dismissible fade show $estilo' role='alert'>";
        $html .= "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
        $html .= "<p class='h4'>{$alerta['titulo']}</p>";
        $html .= "<p>{$alerta['mensaje']}</p>";
        $html .= "</div>";

        return $html;
    }

    /**
     * Devuelve todas las alertas en el sistema. | Null si está vacía.
     * @return string|null
     */
    public static function get_alertas(): mixed {
        if (!empty($_SESSION["alertas"])) {
            $alertasActuales = "";

            foreach ($_SESSION["alertas"] as $alerta) {
                $alertasActuales .= self::show_alerta($alerta);
            }

            self::clear_alertas();

            return $alertasActuales;
        }
        else {
            return null;
        }
    }
}