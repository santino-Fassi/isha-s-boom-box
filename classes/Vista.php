<?php

class Vista
{
    private int $id;
    private string $nombre;
    private string $titulo;
    private int $activa;
    private int $restringida;

    /**
     * Busca una vista en la base de datos según su nombre identificador.
     *
     * @param string $nombre Identificador de la vista.
     * @return ?Vista Instancia de Vista o null si no se encuentra.
     */
    private static function obtener_x_nombre(string $nombre): ?Vista
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM vistas WHERE nombre = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$nombre]);

        $result = $PDOStatement->fetch();

        return $result !== false ? $result : null;
    }

    /**
     * Valida el identificador de una vista solicitada y devuelve la instancia correspondiente.
     * Si la vista no está activa devuelve la vista no_disponible, y si no existe devuelve la vista 404.
     *
     * @param ?string $vista Identificador de la vista recibida por GET.
     * @return Vista Instancia de la vista validada.
     */
    public static function validar_vista(?string $vista): Vista
    {
        $viewData = $vista ? self::obtener_x_nombre($vista) : null;

        if ($viewData) {
            if ($viewData->getActiva()) {
                $resultado = $viewData;
            } else {
                $resultado = self::obtener_x_nombre('no_disponible');
            }
        } else {
            $resultado = self::obtener_x_nombre('404');
        }

        if (!$resultado) {
            $resultado = new self();
            $resultado->nombre = '404';
            $resultado->titulo = 'Página no encontrada';
            $resultado->activa = 1;
            $resultado->restringida = 0;
        }

        return $resultado;
    }

    /**
     * Devuelve el identificador único de la vista.
     *
     * @return int ID de la vista.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Establece el identificador único de la vista.
     *
     * @param int $id Nuevo ID de la vista.
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Devuelve el nombre clave del archivo de la vista.
     *
     * @return string Nombre identificador de la vista.
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Establece el nombre clave del archivo de la vista.
     *
     * @param string $nombre Nuevo nombre de la vista.
     * @return void
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * Devuelve el título de la vista para mostrar en el navegador.
     *
     * @return string Título de la vista.
     */
    public function getTitulo(): string
    {
        return $this->titulo;
    }

    /**
     * Establece el título de la vista.
     *
     * @param string $titulo Nuevo título de la vista.
     * @return void
     */
    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    /**
     * Indica si la vista se encuentra activa y disponible para el público.
     *
     * @return int Estado de activación (1 activa, 0 inactiva).
     */
    public function getActiva(): int
    {
        return $this->activa;
    }

    /**
     * Establece el estado de activación de la vista.
     *
     * @param int $activa Nuevo estado de activación.
     * @return void
     */
    public function setActiva(int $activa): void
    {
        $this->activa = $activa;
    }

    /**
     * Devuelve el nivel de restricción de acceso de la vista.
     *
     * @return int Nivel de restricción.
     */
    public function getRestringida(): int
    {
        return $this->restringida;
    }

    /**
     * Establece el nivel de restricción de acceso de la vista.
     *
     * @param int $restringida Nuevo nivel de restricción.
     * @return void
     */
    public function setRestringida(int $restringida): void
    {
        $this->restringida = $restringida;
    }
}
