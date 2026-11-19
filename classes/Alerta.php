<?php

class Alerta
{
    /**
     * Registra una alerta, guardándola en la sesión.
     *
     * @param string $tipo Tipo de alerta (success, warning o danger).
     * @param string $titulo Título de la alerta.
     * @param string $mensaje Contenido de la alerta.
     * @param bool $front Define si la alerta se debe mostrar con estilo del frontend o backend (frontend por defecto).
     * @return void
     */
    public static function add_alerta(string $tipo, string $titulo, string $mensaje, bool $front = true): void
    {
        $_SESSION["alertas"][] = [
            "tipo" => $tipo,
            "titulo" => $titulo,
            "mensaje" => $mensaje,
            "front" => $front
        ];
    }

    /**
     * Limpia la lista de alertas almacenadas en sesión.
     *
     * @return void
     */
    public static function clear_alertas(): void
    {
        $_SESSION["alertas"] = [];
    }

    /**
     * Genera el marcado HTML de una alerta individual.
     *
     * @param array $alerta Información de la alerta a mostrar.
     * @return string Código HTML de la alerta.
     */
    private static function show_alerta(array $alerta): string
    {
        $estilo = $alerta["front"] ? "front" : "back";
        $html = "<div class='alert alert-{$alerta['tipo']} alert-dismissible fade show $estilo' role='alert'>";
        $html .= "<button type='button' class='btn-close btn-close-white' data-bs-dismiss='alert' aria-label='Cerrar'></button>";
        $html .= "<p class='h4'>{$alerta['titulo']}</p>";
        $html .= "<p>{$alerta['mensaje']}</p>";
        $html .= "</div>";

        return $html;
    }

    /**
     * Devuelve el HTML de todas las alertas pendientes y limpia la cola, o null si no hay ninguna.
     *
     * @return ?string HTML acumulado de alertas o null si está vacía.
     */
    public static function get_alertas(): ?string
    {
        if (!empty($_SESSION["alertas"])) {
            $alertasActuales = "";

            foreach ($_SESSION["alertas"] as $alerta) {
                $alertasActuales .= self::show_alerta($alerta);
            }

            self::clear_alertas();

            return $alertasActuales;
        }

        return null;
    }
}