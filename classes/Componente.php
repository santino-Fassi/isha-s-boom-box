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

    /**
     * Inserta un nuevo componente a la base de datos
     * @param string $nombre
     * @param string $descripcion
     */
    public static function insert(string $nombre, string $descripcion)
    {

        $conexion = Conexion::getConexion();
        $query = "INSERT INTO componentes (`nombre`, `descripcion`) VALUES (:nombre, :descripcion)";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'nombre' => $nombre,
                'descripcion' => $descripcion,
            ]
        );
    }

    /**
     * Edita los datos de un componente en la base de datos
     * @param string $nombre
     * @param string $descripcion
     */
    public function edit(string $nombre, string $descripcion)
    {

        $conexion = Conexion::getConexion();
        $query = " UPDATE componentes 
                    SET nombre = :nombre, descripcion = :descripcion WHERE id = :id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'id' => $this->id
        ]);
    }


    /**
     * Elimina esta instancia de la base de datos
     */
    public function delete()
    {
        $conexion = Conexion::getConexion();
        $query = "DELETE FROM componentes WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([$this->id]);
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