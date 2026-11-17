<?php

class Categoria
{
    private int $id;
    private string $nombre;
    private string $descripcion;

    /**
     * Devuelve el listado de categorías que poseen al menos un artefacto asociado en el catálogo.
     *
     * @return array Lista asociativa con id, nombre y descripción de cada categoría activa.
     */
    public static function listado_menu(): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT DISTINCT categorias.id, categorias.nombre, categorias.descripcion FROM categorias JOIN artefactos ON categorias.id = artefactos.categoria_id;";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute();

        return $PDOStatement->fetchAll();
    }

    /**
     * Busca y devuelve una categoría específica según su identificador único.
     *
     * @param int $id Identificador único de la categoría.
     * @return ?Categoria Instancia de Categoria o null si no existe.
     */
    public static function get_x_id(int $id): ?Categoria
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM categorias WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$id]);

        $result = $PDOStatement->fetch();

        return $result !== false ? $result : null;
    }

    /**
     * Devuelve el listado completo de categorías registradas en la base de datos.
     *
     * @return Categoria[] Array de instancias de Categoria.
     */
    public static function listado_completo(): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM categorias";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();

        return $PDOStatement->fetchAll();
    }

    /**
     * Inserta una nueva categoría en la base de datos.
     *
     * @param string $nombre Nombre de la categoría.
     * @param string $descripcion Descripción de la categoría.
     * @return void
     */
    public static function insert(string $nombre, string $descripcion): void
    {
        $conexion = Conexion::getConexion();
        $query = "INSERT INTO categorias (`nombre`, `descripcion`) VALUES (:nombre, :descripcion)";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
            'nombre' => $nombre,
            'descripcion' => $descripcion
        ]);
    }

    /**
     * Actualiza los datos de esta categoría en la base de datos.
     *
     * @param string $nombre Nuevo nombre de la categoría.
     * @param string $descripcion Nueva descripción de la categoría.
     * @return void
     */
    public function edit(string $nombre, string $descripcion): void
    {
        $conexion = Conexion::getConexion();
        $query = "UPDATE categorias SET nombre = :nombre, descripcion = :descripcion WHERE id = :id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'id' => $this->id
        ]);
    }

    /**
     * Elimina el registro de esta categoría de la base de datos.
     *
     * @return void
     */
    public function delete(): void
    {
        $conexion = Conexion::getConexion();
        $query = "DELETE FROM categorias WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([$this->id]);
    }

    /**
     * Devuelve el identificador único de la categoría.
     *
     * @return int ID de la categoría.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Establece el identificador único de la categoría.
     *
     * @param int $value Nuevo ID de la categoría.
     * @return void
     */
    public function setId(int $value): void
    {
        $this->id = $value;
    }

    /**
     * Devuelve el nombre de la categoría.
     *
     * @return string Nombre de la categoría.
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Establece el nombre de la categoría.
     *
     * @param string $value Nuevo nombre de la categoría.
     * @return void
     */
    public function setNombre(string $value): void
    {
        $this->nombre = $value;
    }

    /**
     * Devuelve la descripción de la categoría.
     *
     * @return string Descripción de la categoría.
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * Establece la descripción de la categoría.
     *
     * @param string $value Nueva descripción de la categoría.
     * @return void
     */
    public function setDescripcion(string $value): void
    {
        $this->descripcion = $value;
    }
}