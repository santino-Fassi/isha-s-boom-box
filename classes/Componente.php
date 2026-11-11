<?php

class Componente
{
    private int $id;
    private string $nombre;
    private string $descripcion;


    /**
     * Devuelve los datos de un componente en particular
     * @param int $id El ID único del componente
     * @return ?Componente Componente solicitado o null si la ID no existe.
     */
    public static function get_x_id(int $id): ?Componente
    {

        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM componentes WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$id]);

        $result = $PDOStatement->fetch();

        return $result ? $result : null;
    }

    /**
     * Devuelve el listado completo de componentes disponibles
     * 
     * @return Componente[] Un array de objetos Componente
     */
    public static function listado_completo(): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM componentes";

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