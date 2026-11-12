<?PHP
class Personaje
{
    private int $id;
    private string $nombre;
    private string $alias;
    private string $biografia;
    private string $faccion;
    private string $imagen;

    /**
     * Devuelve el listado completo de personajes disponibles
     * 
     * @return Personaje[] Un array de objetos Personaje
     */
    public static function listado_completo(): array
    {


        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM personajes";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();

        $lista = $PDOStatement->fetchAll();
        return $lista;
    }

    /**
     * Devuelve los datos de un personaje en particular
     * @param int $id El ID único del personaje a mostrar
     *  
     * @return ?Personaje devuelve un objeto Personaje o null     
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
     * Inserta un nuevo personaje a la base de datos
     * @param string $nombre
     * @param string $alias
     * @param string $biografia
     * @param string $faccion
     * @param string $imagen ruta a un archivo .jpg o .png 
     */
    public static function insert(string $nombre, string $alias, string $biografia, string $faccion, string $imagen)
    {

        $conexion = Conexion::getConexion();
        $query = "INSERT INTO personajes (`nombre`, `alias`, `biografia`, `faccion`, `imagen`) VALUES (:nombre, :alias, :biografia, :faccion, :imagen)";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'nombre' => $nombre,
                'alias' => $alias,
                'biografia' => $biografia,
                'faccion' => $faccion,
                'imagen' => $imagen
            ]
        );
    }

    /**
     * Edita los datos de un personaje en la base de datos
     * @param string $nombre
     * @param string $alias
     * @param string $biografia
     * @param string $faccion
     * @param string $imagen ruta a un archivo .jpg o .png 
     */
    public function edit(string $nombre, string $alias, string $biografia, string $faccion, string $imagen)
    {

        $conexion = Conexion::getConexion();
        $query = " UPDATE personajes 
                    SET nombre = :nombre, alias = :alias, biografia = :biografia, faccion = :faccion, imagen = :imagen WHERE id = :id";

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
     * Elimina esta instancia de la base de datos
     */
    public function delete()
    {
        $conexion = Conexion::getConexion();
        $query = "DELETE FROM personajes WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([$this->id]);
    }


    public function getNombreCompleto() 
    {
        return $this->nombre . " (" . $this->alias . ")";
    }


	public function getId() : int {
		return $this->id;
	}

	public function setId(int $value) {
		$this->id = $value;
	}

	public function getNombre() : string {
		return $this->nombre;
	}

	public function setNombre(string $value) {
		$this->nombre = $value;
	}

	public function getAlias() : string {
		return $this->alias;
	}

	public function setAlias(string $value) {
		$this->alias = $value;
	}

	public function getBiografia() : string {
		return $this->biografia;
	}

	public function setBiografia(string $value) {
		$this->biografia = $value;
	}

	public function getFaccion() : string {
		return $this->faccion;
	}

	public function setFaccion(string $value) {
		$this->faccion = $value;
	}

	public function getImagen() : string {
		return $this->imagen;
	}

	public function setImagen(string $value) {
		$this->imagen = $value;
	}
}