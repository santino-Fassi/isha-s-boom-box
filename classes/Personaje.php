<?PHP
class Personaje
{
    private int $id;
    private string $nombre;
    private string $alias;
    private string $biografia;
    private string $creadores;
    private int $primera_aparicion;
    private string $imagen;



    /**
     * Devuelve el listado de personajes que tengan un catálogo.
     * 
     * @return array Un array con el id y el alias de cada personaje;
     */
    public static function listado_menu(): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT DISTINCT personajes.id, personajes.alias FROM personajes JOIN comics ON personajes.id = comics.personaje_principal_id;";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute();

        $lista = $PDOStatement->fetchAll();
        return $lista;
    }

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
        return $result ?? null;
    }

    /**
     * Inserta un nuevo personaje a la base de datos
     * @param string $nombre
     * @param string $alias
     * @param string $creador Creador o creadores del personaje, separados por comas
     * @param int $primera_aparicion El año en el que el personaje hizo su primera aparición (4 dígitos)
     * @param string $biografia 
     * @param string $imagen ruta a un archivo .jpg o .png 
     */
    public static function insert(string $nombre, string $alias, string $creador, int $primera_aparicion, string $biografia,  string $imagen)
    {

        $conexion = Conexion::getConexion();
        $query = "INSERT INTO personajes (`nombre`, `alias`, `biografia`, `creadores`, `primera_aparicion`, `imagen`) VALUES (:nombre, :alias, :biografia, :creador, :primera_aparicion, :imagen)";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'nombre' => $nombre,
                'alias' => $alias,
                'biografia' => $biografia,
                'creador' => $creador,
                'primera_aparicion' => $primera_aparicion,
                'imagen' => $imagen
            ]
        );
    }

    /**
     * Edita los datos de un personaje en la base de datos
     * @param string $nombre
     * @param string $alias
     * @param string $creador Creador o creadores del personaje, separados por comas
     * @param int $primera_aparicion El año en el que el personaje hizo su primera aparición (4 dígitos)
     * @param string $biografia 
     * @param string $imagen ruta a un archivo .jpg o .png 
     */
    public function edit($nombre, $alias, $creadores, $primera_aparicion, $biografia, $imagen)
    {

        $conexion = Conexion::getConexion();
        $query = " UPDATE personajes 
                            SET nombre = :nombre, alias = :alias, biografia = :biografia, creadores = :creadores, primera_aparicion = :primera_aparicion, imagen = :imagen 
                            WHERE id = :id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
            'nombre' => $nombre,
            'alias' => $alias,
            'biografia' => $biografia,
            'creadores' => $creadores,
            'primera_aparicion' => $primera_aparicion,
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

    /**
     * Devuelve el titulo del personaje
     * @param bool $aliasPrimero define si se usa principalmente el alias en vez de el nombre real. De no proveerse se asume false
     * 
     * @return string El titulo compuesto por el nombre de civil y el alias del personaje en la configuracion deseada.
     */
    public function getTitulo(bool $aliasPrimero = FALSE): string
    {

        if ($aliasPrimero) {
            $resultado = $this->alias . " (" . $this->nombre . ")";
        } else {
            $resultado = $this->nombre . " (" . $this->alias . ")";
        }

        return $resultado;
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
     * Get the value of alias
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set the value of alias
     *
     * @return  self
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get the value of biografia
     */
    public function getBiografia()
    {
        return $this->biografia;
    }

    /**
     * Set the value of biografia
     *
     * @return  self
     */
    public function setBiografia($biografia)
    {
        $this->biografia = $biografia;

        return $this;
    }

    /**
     * Get the value of creadores
     */
    public function getCreadores()
    {
        return $this->creadores;
    }

    /**
     * Set the value of creadores
     *
     * @return  self
     */
    public function setCreadores($creadores)
    {
        $this->creadores = $creadores;

        return $this;
    }

    /**
     * Get the value of primera_aparicion
     */
    public function getPrimera_aparicion()
    {
        return $this->primera_aparicion;
    }

    /**
     * Set the value of primera_aparicion
     *
     * @return  self
     */
    public function setPrimera_aparicion($primera_aparicion)
    {
        $this->primera_aparicion = $primera_aparicion;

        return $this;
    }

    /**
     * Get the value of imagen
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set the value of imagen
     *
     * @return  self
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }
}
