<?php

class Personaje
{
    private int $id;
    private string $nombre;
    private string $alias;
    private string $biografia;
    private string $faccion;
    private string $imagen;

    /**
     * Devuelve el listado completo de personajes registrados en la base de datos.
     *
     * @return Personaje[] Array de instancias de Personaje.
     */
    public static function listado_completo(): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM personajes";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();

        return $PDOStatement->fetchAll();
    }

    /**
     * Busca y devuelve un personaje específico según su identificador único.
     *
     * @param int $id Identificador único del personaje.
     * @return ?Personaje Instancia de Personaje o null si no existe.
     */
    public static function get_x_id(int $id): ?Personaje
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM personajes WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$id]);

        $result = $PDOStatement->fetch();

        return $result !== false ? $result : null;
    }

    /**
     * Inserta un nuevo personaje en la base de datos.
     *
     * @param string $nombre Nombre del personaje.
     * @param string $alias Alias o apodo del personaje.
     * @param string $biografia Biografía descriptiva del personaje.
     * @param string $faccion Facción o ciudad de pertenencia.
     * @param string $imagen Nombre del archivo de imagen asociado.
     * @return void
     */
    public static function insert(string $nombre, string $alias, string $biografia, string $faccion, string $imagen): void
    {
        $conexion = Conexion::getConexion();
        $query = "INSERT INTO personajes (`nombre`, `alias`, `biografia`, `faccion`, `imagen`) VALUES (:nombre, :alias, :biografia, :faccion, :imagen)";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
            'nombre' => $nombre,
            'alias' => $alias,
            'biografia' => $biografia,
            'faccion' => $faccion,
            'imagen' => $imagen
        ]);
    }

    /**
     * Actualiza los datos de este personaje en la base de datos.
     *
     * @param string $nombre Nombre del personaje.
     * @param string $alias Alias o apodo del personaje.
     * @param string $biografia Biografía descriptiva del personaje.
     * @param string $faccion Facción o ciudad de pertenencia.
     * @param string $imagen Nombre del archivo de imagen asociado.
     * @return void
     */
    public function edit(string $nombre, string $alias, string $biografia, string $faccion, string $imagen): void
    {
        $conexion = Conexion::getConexion();
        $query = "UPDATE personajes SET nombre = :nombre, alias = :alias, biografia = :biografia, faccion = :faccion, imagen = :imagen WHERE id = :id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
            'nombre' => $nombre,
            'alias' => $alias,
            'biografia' => $biografia,
            'faccion' => $faccion,
            'imagen' => $imagen,
            'id' => $this->id
        ]);
    }

    /**
     * Elimina el registro de este personaje de la base de datos.
     *
     * @return void
     */
    public function delete(): void
    {
        $conexion = Conexion::getConexion();
        $query = "DELETE FROM personajes WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([$this->id]);
    }

    /**
     * Devuelve el nombre del personaje acompañado de su alias entre paréntesis.
     *
     * @return string Nombre completo formateado.
     */
    public function getNombreCompleto(): string
    {
        return $this->nombre . " (" . $this->alias . ")";
    }

    /**
     * Devuelve el identificador único del personaje.
     *
     * @return int ID del personaje.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Establece el identificador único del personaje.
     *
     * @param int $value Nuevo ID del personaje.
     * @return void
     */
    public function setId(int $value): void
    {
        $this->id = $value;
    }

    /**
     * Devuelve el nombre del personaje.
     *
     * @return string Nombre del personaje.
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Establece el nombre del personaje.
     *
     * @param string $value Nuevo nombre del personaje.
     * @return void
     */
    public function setNombre(string $value): void
    {
        $this->nombre = $value;
    }

    /**
     * Devuelve el alias del personaje.
     *
     * @return string Alias del personaje.
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * Establece el alias del personaje.
     *
     * @param string $value Nuevo alias del personaje.
     * @return void
     */
    public function setAlias(string $value): void
    {
        $this->alias = $value;
    }

    /**
     * Devuelve la biografía del personaje.
     *
     * @return string Biografía del personaje.
     */
    public function getBiografia(): string
    {
        return $this->biografia;
    }

    /**
     * Establece la biografía del personaje.
     *
     * @param string $value Nueva biografía del personaje.
     * @return void
     */
    public function setBiografia(string $value): void
    {
        $this->biografia = $value;
    }

    /**
     * Devuelve la facción a la que pertenece el personaje.
     *
     * @return string Facción del personaje.
     */
    public function getFaccion(): string
    {
        return $this->faccion;
    }

    /**
     * Establece la facción a la que pertenece el personaje.
     *
     * @param string $value Nueva facción del personaje.
     * @return void
     */
    public function setFaccion(string $value): void
    {
        $this->faccion = $value;
    }

    /**
     * Devuelve el nombre del archivo de imagen del personaje.
     *
     * @return string Archivo de imagen.
     */
    public function getImagen(): string
    {
        return $this->imagen;
    }

    /**
     * Establece el nombre del archivo de imagen del personaje.
     *
     * @param string $value Nuevo archivo de imagen.
     * @return void
     */
    public function setImagen(string $value): void
    {
        $this->imagen = $value;
    }
}