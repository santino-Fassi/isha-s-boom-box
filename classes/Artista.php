<?PHP

class Artista
{

    protected int $id;
    protected string $nombre_completo;
    protected string $biografia;
    protected string $foto_perfil;


    /**
     * Devuelve los datos de un artista en particular
     * @param int $id El ID único del artista 
     */
    public static function get_x_id(int $id): Artista
    {

        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM artistas WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$id]);

        $result = $PDOStatement->fetch();

        return $result ? $result : null;
    }

    /**
     * Devuelve el listado completo de artistas disponibles
     * 
     * @return Artista[] Un array de objetos Artista
     */
    public static function listado_completo(): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM artistas";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();

        $lista = $PDOStatement->fetchAll();
        return $lista;
    }

    /**
     * Get the value of nombre_completo
     */
    public function getNombre_completo()
    {
        return $this->nombre_completo;
    }

    /**
     * Get the value of biografia
     */
    public function getBiografia()
    {
        return $this->biografia;
    }

    /**
     * Get the value of foto_perfil
     */
    public function getFoto_perfil()
    {
        return $this->foto_perfil;
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
}
