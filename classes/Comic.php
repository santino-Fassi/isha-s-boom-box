<?PHP

class Comic
{
    /*PROPIEDADES*/

    private int $id;
    private int $personaje_principal_id;
    private int $serie_id;
    private int $volumen;
    private int $numero;
    private string $titulo;
    private string $publicacion;
    private int $guionista_id;
    private int $artista_id;
    private ?string $bajada;
    private string $origen;
    private string $editorial;
    private string $portada;
    private float $precio;


    /*MÉTODOS*/

    /**
     * Devuelve el catálgo completo
     * 
     * @return Comic[] Un array de objetos Comic
     */
    public static function catalogo_completo(): array
    {

        $conexion = Conexion::getConexion();

        $query = "SELECT * FROM comics";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();

        $catalogo = $PDOStatement->fetchAll();

        return $catalogo;
    }

    /**
     * Devuelve el catalogo de productos de un personaje en particular
     * @param int $personajeID Un int con el id del personaje a buscar
     * 
     * @return Comic[] Un Array lleno de instancias de objeto Comic.
     */
    public static function catalogo_x_personaje(int $personajeID): array
    {
        $conexion = Conexion::getConexion();

        $query = "SELECT * FROM comics WHERE personaje_principal_id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$personajeID]);

        $catalogo = $PDOStatement->fetchAll();

        return $catalogo;
    }

    /**
     * Devuelve los datos de un producto en particular
     * @param int $id El ID único del producto a mostrar
     *  
     * @return ?Comic devuelve un objeto comic o null     
     */
    public static function get_x_id(int $id): ?Comic
    {

        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM comics WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$id]);

        $result = $PDOStatement->fetch();

        return $result ?? null;
    }

    /**
     * Devuelve los comics en un determinado rango de precios
     * @param int $minimo El precio minimo. De no proveerlo se asumira 0;
     * @param int $maximo El precio máximo. De no proveerlo se asumiran infinito. 
     * 
     * @return Comics[] Un array de objetos Comic
     */
    public static function comics_x_rango(int $minimo = 0, int $maximo = 0): array
    {

        $conexion = Conexion::getConexion();

        //ACA CONSTRUIMOS EL QUERY
        if ($maximo) {
            //Elegir comics con precio entre el mínimo y el máximo
            $query = "SELECT * FROM comics WHERE precio BETWEEN :minimo AND :maximo";
            $valores = [
                'minimo' => $minimo,
                'maximo' => $maximo
            ];
        } else {
            //Elegir comics con precio entre el mínimo y infinito´
            //Elegir comics con precio entre el mínimo y infinito
            $query = "SELECT * FROM comics WHERE precio > :minimo";
            $valores = [
                'minimo' => $minimo
            ];
        }

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute($valores);

        $catalogo = $PDOStatement->fetchAll();

        return $catalogo;
    }
    /**
     * Busca un termino 
     * 
     */
    public static function buscador(string $terminoBusqueda): array
    {


        /*PROCESAR EL TERMINO DE BUSQUEDA */
        $terminoSanitizado = trim($terminoBusqueda);

        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM comics WHERE titulo LIKE :terminoTitulo OR bajada LIKE :terminoBajada";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([
            "terminoTitulo" => "%$terminoSanitizado%",
            "terminoBajada" => "%$terminoSanitizado%"
        ]);

        $catalogo = $PDOStatement->fetchAll();

        return $catalogo;
    }



    /**
     * Inserta un nuevo comic a la base de datos
     * @param string $titulo
     * @param int $personaje_pricipal_id
     * @param int $serie_id
     * @param int $guionista_id
     * @param int $artista_id
     * @param int $volumen
     * @param int $numero
     * @param string $publicacion El dia de publicación en formato YYYY-DD-MM
     * @param string $bajada 
     * @param string $origen 
     * @param string $editorial 
     * @param string $portada ruta a un archivo .jpg o .png 
     * @param float $precio   
     * 
     * @return int El ID AI del elemento insertado.
     */
    public static function insert($titulo, $personaje_pricipal_id, $serie_id, $guionista_id, $artista_id, $volumen, $numero, $publicacion, $origen, $editorial, $bajada, $portada, $precio): int
    {
        $conexion = Conexion::getConexion();
        $query = "INSERT INTO comics VALUES (NULL, :titulo, :personaje_pricipal_id, :serie_id, :guionista_id, :artista_id, :volumen, :numero, :publicacion, :origen, :editorial, :bajada, :portada, :precio)";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'titulo' => $titulo,
                'personaje_pricipal_id' => $personaje_pricipal_id,
                'serie_id' => $serie_id,
                'guionista_id' => $guionista_id,
                'artista_id' => $artista_id,
                'volumen' => $volumen,
                'numero' => $numero,
                'publicacion' => $publicacion,
                'origen' => $origen,
                'editorial' => $editorial,
                'bajada' => $bajada,
                'portada' => $portada,
                'precio' => $precio,
            ]
        );

        return $conexion->lastInsertId();
    }

    /**
     * Crea un vinculo entre un comic y un personaje Secundario
     * @param int $comic_id
     * @param int $personaje_id
     */
    public static function add_personajes_sec(int $comic_id, int $personaje_id)
    {
        $conexion = Conexion::getConexion();
        $query = "INSERT INTO personajes_x_comic VALUES (NULL, :comic_id, :personaje_id)";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'comic_id' => $comic_id,
                'personaje_id' => $personaje_id
            ]
        );
    }

    /**
     * Vaciar lista de personajes secundarios
     */
    public function clear_personajes_sec()
    {
        $conexion = Conexion::getConexion();
        $query = "DELETE FROM personajes_x_comic WHERE comic_id = :comic_id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'comic_id' => $this->id
            ]
        );
    }


    public function edit($titulo, $personaje_principal_id, $serie_id, $guionista_id, $artista_id, $volumen, $numero, $publicacion, $origen, $editorial, $bajada, $precio, $portada)
    {

        $conexion = Conexion::getConexion();
        $query = "UPDATE comics SET
         titulo = :titulo,
         personaje_principal_id = :personaje_principal_id,
         serie_id = :serie_id,
         guionista_id = :guionista_id,
         artista_id = :artista_id,
         volumen = :volumen,
         numero = :numero,
         publicacion = :publicacion,
         origen = :origen,
         editorial = :editorial,
         bajada = :bajada,
         precio = :precio,
         portada = :portada          
        WHERE id = :id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'id' => $this->id,
                'titulo' => $titulo,
                'personaje_principal_id' => $personaje_principal_id,
                'serie_id' => $serie_id,
                'guionista_id' => $guionista_id,
                'artista_id' => $artista_id,
                'volumen' => $volumen,
                'numero' => $numero,
                'publicacion' => $publicacion,
                'origen' => $origen,
                'editorial' => $editorial,
                'bajada' => $bajada,
                'precio' => $precio,
                'portada' => $portada
            ]
        );
    }



    /**
     * Elimina esta instancia de la base de datos
     */
    public function delete()
    {
        $conexion = Conexion::getConexion();
        $query = "DELETE FROM comics WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([$this->id]);
    }


    /**
     * Get the value of personajes_secundarios
     */
    public function getPersonajes_secundarios(): array
    {

        $conexion = Conexion::getConexion();
        $query = "SELECT personajes.* FROM personajes_x_comic
LEFT JOIN personajes ON personajes_x_comic.personaje_id = personajes.id
WHERE comic_id = :comic_id";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, 'Personaje');
        $PDOStatement->execute(
            [
                'comic_id' => $this->id
            ]
        );

        $result = $PDOStatement->fetchAll();

        return $result;
    }




    /**
     * Mi primer Método
     *  */
    public function hola_mundo(): String
    {
        return "Hola, soy una instancia del objeto Comic";
    }

    /**
     * Devuelve el nombre completo de la edición
     */
    public function get_nombre_completo(): string
    {
        $nombreCompleto = $this->getSerie() . " Vol. $this->volumen #$this->numero - $this->titulo";

        return $nombreCompleto;
    }

    /**
     * Esta método devuelve las primeras x palabras de la bajada 
     * 
     * @param int $cantidad Esta es la cantidad de palabras a extraer (Opcional)
     */
    public function get_bajada_reducida(int $cantidad = 10): string
    {
        $texto = $this->bajada;

        $array = explode(" ", $texto);
        if (count($array) <= $cantidad) {
            $resultado = $texto;
        } else {
            array_splice($array, $cantidad);
            $resultado = implode(" ", $array) . "...";
        }

        return $resultado;
    }

    /**
     * Devuelve el precio de la unidad, formateado correctamente
     */
    public function get_precio_formateado(): string
    {
        return "$" . number_format($this->precio, 2, ",", ".");
    }

    /**
     * Devuelve el precio + IVA
     */
    public function get_precio_iva()
    {
        return $this->precio * 1.21;
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
     * Get the value of personaje
     */
    public function getPersonaje()
    {
        return Personaje::get_x_id($this->personaje_principal_id)->getTitulo();
    }

    /**
     * Set the value of personaje
     *
     * @return  self
     */
    public function setPersonaje(int $personaje_principal_id)
    {
        $this->personaje_principal_id = $personaje_principal_id;

        return $this;
    }

    /**
     * Get the value of serie
     */
    public function getSerie()
    {
        return Serie::get_x_id($this->serie_id)->getNombre();
    }

    /**
     * Set the value of serie
     *
     * @return  self
     */
    public function setSerie(string $serie_id)
    {
        $this->serie_id = $serie_id;

        return $this;
    }

    /**
     * Get the value of volumen
     */
    public function getVolumen()
    {
        return $this->volumen;
    }

    /**
     * Set the value of volumen
     *
     * @return  self
     */
    public function setVolumen($volumen)
    {
        $this->volumen = $volumen;

        return $this;
    }

    /**
     * Get the value of numero
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     *
     * @return  self
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of titulo
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     *
     * @return  self
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get the value of publicacion
     */
    public function getPublicacion()
    {
        return $this->publicacion;
    }

    /**
     * Set the value of publicacion
     *
     * @return  self
     */
    public function setPublicacion($publicacion)
    {
        $this->publicacion = $publicacion;

        return $this;
    }

    /**
     * Get the value of guion
     */
    public function getGuion()
    {
        return Guionista::get_x_id($this->guionista_id)->getNombre_completo();
    }

    /**
     * Set the value of guion
     *
     * @return  self
     */
    public function setGuion($guionista_id)
    {
        $this->guionista_id = $guionista_id;

        return $this;
    }

    /**
     * Get the value of arte
     */
    public function getArte()
    {
        return Artista::get_x_id($this->artista_id)->getNombre_completo();
    }

    /**
     * Set the value of arte
     *
     * @return  self
     */
    public function setArte($artista_id)
    {
        $this->artista_id = $artista_id;

        return $this;
    }

    /**
     * Get the value of bajada
     */
    public function getBajada()
    {
        return $this->bajada;
    }

    /**
     * Set the value of bajada
     *
     * @return  self
     */
    public function setBajada($bajada)
    {
        $this->bajada = $bajada;

        return $this;
    }

    /**
     * Get the value of portada
     */
    public function getPortada()
    {
        return $this->portada;
    }

    /**
     * Set the value of portada
     *
     * @return  self
     */
    public function setPortada($portada)
    {
        $this->portada = $portada;

        return $this;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of origen
     */
    public function getOrigen()
    {
        return $this->origen;
    }

    /**
     * Set the value of origen
     *
     * @return  self
     */
    public function setOrigen($origen)
    {
        $this->origen = $origen;

        return $this;
    }

    /**
     * Get the value of editorial
     */
    public function getEditorial()
    {
        return $this->editorial;
    }

    /**
     * Get the value of serie_id
     */
    public function getSerie_id()
    {
        return $this->serie_id;
    }

    /**
     * Set the value of serie_id
     *
     * @return  self
     */
    public function setSerie_id($serie_id)
    {
        $this->serie_id = $serie_id;

        return $this;
    }

    /**
     * Get the value of personaje_principal_id
     */
    public function getPersonaje_principal_id()
    {
        return $this->personaje_principal_id;
    }

    /**
     * Set the value of personaje_principal_id
     *
     * @return  self
     */
    public function setPersonaje_principal_id($personaje_principal_id)
    {
        $this->personaje_principal_id = $personaje_principal_id;

        return $this;
    }

    /**
     * Get the value of guionista_id
     */
    public function getGuionista_id()
    {
        return $this->guionista_id;
    }

    /**
     * Set the value of guionista_id
     *
     * @return  self
     */
    public function setGuionista_id($guionista_id)
    {
        $this->guionista_id = $guionista_id;

        return $this;
    }

    /**
     * Get the value of artista_id
     */
    public function getArtista_id()
    {
        return $this->artista_id;
    }

    /**
     * Set the value of artista_id
     *
     * @return  self
     */
    public function setArtista_id($artista_id)
    {
        $this->artista_id = $artista_id;

        return $this;
    }
}
