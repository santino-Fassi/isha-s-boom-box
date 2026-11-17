<?php

class Componente
{
    private int $id;
    private string $nombre;
    private string $descripcion;

    /**
     * Busca y devuelve un componente específico según su identificador único.
     *
     * @param int $id Identificador único del componente.
     * @return ?Componente Instancia de Componente o null si no existe.
     */
    public static function get_x_id(int $id): ?Componente
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM componentes WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$id]);

        $result = $PDOStatement->fetch();

        return $result !== false ? $result : null;
    }

    /**
     * Devuelve el listado completo de componentes disponibles en la base de datos.
     *
     * @return Componente[] Array de instancias de Componente.
     */
    public static function listado_completo(): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM componentes";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();

        return $PDOStatement->fetchAll();
    }

    /**
     * Inserta un nuevo componente en la base de datos.
     *
     * @param string $nombre Nombre del componente.
     * @param string $descripcion Descripción técnica del componente.
     * @return void
     */
    public static function insert(string $nombre, string $descripcion): void
    {
        $conexion = Conexion::getConexion();
        $query = "INSERT INTO componentes (`nombre`, `descripcion`) VALUES (:nombre, :descripcion)";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
            'nombre' => $nombre,
            'descripcion' => $descripcion
        ]);
    }

    /**
     * Actualiza los datos de este componente en la base de datos.
     *
     * @param string $nombre Nuevo nombre del componente.
     * @param string $descripcion Nueva descripción del componente.
     * @return void
     */
    public function edit(string $nombre, string $descripcion): void
    {
        $conexion = Conexion::getConexion();
        $query = "UPDATE componentes SET nombre = :nombre, descripcion = :descripcion WHERE id = :id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'id' => $this->id
        ]);
    }

    /**
     * Elimina el registro de este componente de la base de datos.
     *
     * @return void
     */
    public function delete(): void
    {
        $conexion = Conexion::getConexion();
        $query = "DELETE FROM componentes WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([$this->id]);
    }

    /**
     * Devuelve el identificador único del componente.
     *
     * @return int ID del componente.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Establece el identificador único del componente.
     *
     * @param int $value Nuevo ID del componente.
     * @return void
     */
    public function setId(int $value): void
    {
        $this->id = $value;
    }

    /**
     * Devuelve el nombre del componente.
     *
     * @return string Nombre del componente.
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Establece el nombre del componente.
     *
     * @param string $value Nuevo nombre del componente.
     * @return void
     */
    public function setNombre(string $value): void
    {
        $this->nombre = $value;
    }

    /**
     * Devuelve la descripción técnica del componente.
     *
     * @return string Descripción del componente.
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * Establece la descripción técnica del componente.
     *
     * @param string $value Nueva descripción del componente.
     * @return void
     */
    public function setDescripcion(string $value): void
    {
        $this->descripcion = $value;
    }
}