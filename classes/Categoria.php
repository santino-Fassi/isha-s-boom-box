<?php


class Categoria
{
    private int $id;
    private string $nombre;
    private string $descripcion;

    /**
     * Devuelve el listado de categorias que tengan un catálogo.
     * 
     * @return array Un array con el id, nombre y descripcion de cada categoria;
     */
    public static function listado_menu(): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT DISTINCT categorias.id, categorias.nombre, categorias.descripcion FROM categorias JOIN artefactos ON categorias.id = artefactos.categoria_id;";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute();

        $lista = $PDOStatement->fetchAll();
        return $lista;
    }

    /**
     * Devuelve los datos de una categoria en particular
     * @param int $id El ID único de la categoria
     * @return ?Categoria Categoria solicitado o null si la ID no existe.
     */
    public static function get_x_id(int $id): ?Categoria
    {

        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM categorias WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$id]);

        $result = $PDOStatement->fetch();

        return $result ? $result : null;
    }

    /**
     * Devuelve el listado completo de categorias disponibles
     * 
     * @return Categoria[] Un array de objetos Categoria
     */
    public static function listado_completo(): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM categorias";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();

        $lista = $PDOStatement->fetchAll();
        return $lista;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $value)
    {
        $this->id = $value;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $value)
    {
        $this->nombre = $value;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $value)
    {
        $this->descripcion = $value;
    }
}