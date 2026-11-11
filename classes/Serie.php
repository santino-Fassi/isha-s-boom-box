<?PHP

class Serie
{
    private int $id;
    private string $nombre;
    private ?string $historia;

    /**
     * Devuelve los datos de una serie en particular
     * @param int $id El ID único de la serie 
     */
    public static function get_x_id(int $id): ?Serie
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM series WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$id]);

        $result = $PDOStatement->fetch();


        return $result ? $result : null;
    }

    /**
     * Devuelve el listado completo de series disponibles
     * 
     * @return Serie[] Un array de objetos Personaje
     */
    public static function listado_completo(): array
    {
    
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM series";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();

        $lista = $PDOStatement->fetchAll();
        return $lista;
    }


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of historia
     */
    public function getHistoria()
    {
        return $this->historia;
    }

    /**
     * Set the value of historia
     *
     * @return  self
     */
    public function setHistoria($historia)
    {
        $this->historia = $historia;

        return $this;
    }
}
