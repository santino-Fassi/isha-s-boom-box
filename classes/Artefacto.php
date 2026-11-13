<?PHP

class Artefacto
{
    private int $id;
    private string $nombre;
    private string $alias;
    private Categoria $categoria;
    private Personaje $personaje_creador;
    private Personaje $personaje_usuario;
    private array $componentes;
    private string $origen;
    private int $nivel_peligro;
    private string $fecha_fabricacion;
    private string $descripcion;
    private string $imagen;
    private float $precio;
    private bool $robado;

    private static array $campos_primitivos = ["id", "nombre", "alias", "origen", "nivel_peligro", "fecha_fabricacion", "descripcion", "imagen", "precio", "robado"];

    private static function crearArtefacto($artefactoData): Artefacto
    {
        $artefacto = new self();

        foreach (self::$campos_primitivos as $campo) {
            $artefacto->{$campo} = $artefactoData[$campo];
        }

        $artefacto->categoria = Categoria::get_x_id($artefactoData["categoria_id"]);
        $artefacto->personaje_creador = Personaje::get_x_id($artefactoData["personaje_creador_id"]);
        $artefacto->personaje_usuario = Personaje::get_x_id($artefactoData["personaje_usuario_id"]);

        $componentesIds = !empty($artefactoData["componentes"]) ? explode(",", $artefactoData["componentes"]) : [];

        foreach ($componentesIds as $id) {
            $artefacto->componentes[] = Componente::get_x_id($id);
        }

        return $artefacto;
    }

    /**
     * Devuelve el catálgo completo
     * 
     * @return Artefacto[] Un array de objetos Artefacto
     */
    public static function catalogo_completo(): array
    {

        $conexion = Conexion::getConexion();

        //$query = "SELECT * FROM artefactos";
        $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) as componentes
            FROM artefactos LEFT JOIN componentes_x_artefacto as cxa ON artefactos.id = cxa.artefacto_id
            GROUP BY artefactos.id;";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute();

        $catalogo = [];

        while ($result = $PDOStatement->fetch()) {
            $catalogo[] = self::crearArtefacto($result);
        }

        return $catalogo;
    }

    /**
     * Devuelve los datos de un artefacto en particular
     * @param int $id El ID único del artefacto a mostrar
     *  
     * @return ?Artefacto devuelve un objeto artefacto o null     
     */
    public static function get_x_id(int $id): ?Artefacto
    {

        $conexion = Conexion::getConexion();
        //$query = "SELECT * FROM artefactos WHERE id = ?";
        $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) as componentes
            FROM artefactos LEFT JOIN componentes_x_artefacto as cxa ON artefactos.id = cxa.artefacto_id
            WHERE artefactos.id = ? GROUP BY artefactos.id;";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute([$id]);


        $result = $PDOStatement->fetch();

        return $result !== false ? self::crearArtefacto($result) : null;
    }

    public static function catalogo_x_categoria(int $categoriaID): array
    {
        $conexion = Conexion::getConexion();

        //$query = "SELECT * FROM artefactos WHERE categoria_id = ?";
        $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) as componentes
            FROM artefactos LEFT JOIN componentes_x_artefacto as cxa ON artefactos.id = cxa.artefacto_id
            WHERE artefactos.categoria_id = ? GROUP BY artefactos.id;";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute([$categoriaID]);

        $catalogo = [];

        while ($result = $PDOStatement->fetch()) {
            $catalogo[] = self::crearArtefacto($result);
        }

        return $catalogo;
    }

    public static function catalogo_x_creador(int $creadorID): array
    {
        $conexion = Conexion::getConexion();

        //$query = "SELECT * FROM artefactos WHERE personaje_creador_id = ?";
        $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) as componentes
            FROM artefactos LEFT JOIN componentes_x_artefacto as cxa ON artefactos.id = cxa.artefacto_id
            WHERE artefactos.personaje_creador_id = ? GROUP BY artefactos.id;";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute([$creadorID]);

        $catalogo = [];

        while ($result = $PDOStatement->fetch()) {
            $catalogo[] = self::crearArtefacto($result);
        }

        return $catalogo;
    }

    public static function catalogo_x_usuario(int $usuarioID): array
    {
        $conexion = Conexion::getConexion();

        //$query = "SELECT * FROM artefactos WHERE personaje_usuario_id = ?";
        $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) as componentes
            FROM artefactos LEFT JOIN componentes_x_artefacto as cxa ON artefactos.id = cxa.artefacto_id
            WHERE artefactos.personaje_usuario_id = ? GROUP BY artefactos.id;";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute([$usuarioID]);

        $catalogo = [];

        while ($result = $PDOStatement->fetch()) {
            $catalogo[] = self::crearArtefacto($result);
        }

        return $catalogo;
    }

    public static function catalogo_x_origen(string $origen): array
    {
        $conexion = Conexion::getConexion();

        //$query = "SELECT * FROM artefactos WHERE origen = ?";
        $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) as componentes
            FROM artefactos LEFT JOIN componentes_x_artefacto as cxa ON artefactos.id = cxa.artefacto_id
            WHERE artefactos.origen = ? GROUP BY artefactos.id;";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute([$origen]);

        $catalogo = [];

        while ($result = $PDOStatement->fetch()) {
            $catalogo[] = self::crearArtefacto($result);
        }

        return $catalogo;
    }

    /**
     * Devuelve los artefactos en un determinado rango de precios
     * @param int $minimo El precio minimo. De no proveerlo se asumira 0;
     * @param int $maximo El precio máximo. De no proveerlo se asumiran infinito. 
     * 
     * @return Artefacto[] Un array de objetos Artefacto
     */
    public static function catalogo_x_rango_precio(float $minimo = 0, float $maximo = 0): array
    {
        $conexion = Conexion::getConexion();

        if ($maximo > 0) {
            $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) AS componentes
                FROM artefactos 
                LEFT JOIN componentes_x_artefacto AS cxa ON artefactos.id = cxa.artefacto_id
                WHERE artefactos.precio BETWEEN :minimo AND :maximo
                GROUP BY artefactos.id;";
            $valores = [
                'minimo' => $minimo,
                'maximo' => $maximo
            ];
        } else {
            $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) AS componentes
                FROM artefactos 
                LEFT JOIN componentes_x_artefacto AS cxa ON artefactos.id = cxa.artefacto_id
                WHERE artefactos.precio >= :minimo
                GROUP BY artefactos.id;";
            $valores = [
                'minimo' => $minimo
            ];
        }

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute($valores);

        $catalogo = [];

        while ($result = $PDOStatement->fetch()) {
            $catalogo[] = self::crearArtefacto($result);
        }

        return $catalogo;
    }


    /**
     * Devuelve los artefactos en un determinado rango de peligro
     * @param int $minimo El peligro minimo. De no proveerlo se asumira 0;
     * @param int $maximo El peligro máximo. De no proveerlo se asumiran infinito. 
     * 
     * @return Artefacto[] Un array de objetos Artefacto
     */
    public static function catalogo_x_rango_peligro(int $minimo = 0, int $maximo = 0): array
    {
        $conexion = Conexion::getConexion();

        if ($maximo > 0) {
            $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) AS componentes
                FROM artefactos 
                LEFT JOIN componentes_x_artefacto AS cxa ON artefactos.id = cxa.artefacto_id
                WHERE artefactos.nivel_peligro BETWEEN :minimo AND :maximo
                GROUP BY artefactos.id;";
            $valores = [
                'minimo' => $minimo,
                'maximo' => $maximo
            ];
        } else {
            $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) AS componentes
                FROM artefactos 
                LEFT JOIN componentes_x_artefacto AS cxa ON artefactos.id = cxa.artefacto_id
                WHERE artefactos.nivel_peligro >= :minimo
                GROUP BY artefactos.id;";
            $valores = [
                'minimo' => $minimo
            ];
        }

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute($valores);

        $catalogo = [];

        while ($result = $PDOStatement->fetch()) {
            $catalogo[] = self::crearArtefacto($result);
        }

        return $catalogo;
    }

    /**
     * Busca un termino 
     * 
     */
    public static function buscador(string $terminoBusqueda): array
    {
        $terminoSanitizado = trim($terminoBusqueda);

        $conexion = Conexion::getConexion();
        $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) AS componentes
            FROM artefactos 
            LEFT JOIN componentes_x_artefacto AS cxa ON artefactos.id = cxa.artefacto_id
            WHERE artefactos.nombre LIKE :terminoNombre OR artefactos.alias LIKE :terminoAlias
            GROUP BY artefactos.id;";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute([
            "terminoNombre" => "%$terminoSanitizado%",
            "terminoAlias" => "%$terminoSanitizado%"
        ]);

        $catalogo = [];

        while ($result = $PDOStatement->fetch()) {
            $catalogo[] = self::crearArtefacto($result);
        }

        return $catalogo;
    }

    /**
     * Filtra el catálogo combinando término de búsqueda, origen y peligro mínimo
     * @param string $termino Término de búsqueda
     * @param string $origen Origen de los artefactos
     * @param int $peligroMin Peligro mínimo de los artefactos
     * @return array Lista de artefactos que cumplen con las condiciones
     */
    public static function catalogo_filtrado(string $termino = '', string $origen = '', int $peligroMin = 0): array
{
        $conexion = Conexion::getConexion();
        $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) AS componentes
            FROM artefactos 
            LEFT JOIN componentes_x_artefacto AS cxa ON artefactos.id = cxa.artefacto_id
            WHERE 1=1";
        $params = [];

        if (trim($termino) !== '') {
            $query .= " AND (artefactos.nombre LIKE :terminoNombre OR artefactos.alias LIKE :terminoAlias)";
            $terminoLimpio = "%" . trim($termino) . "%";
            $params['terminoNombre'] = $terminoLimpio;
            $params['terminoAlias'] = $terminoLimpio;
        }

        if ($origen !== '') {
            $query .= " AND artefactos.origen = :origen";
            $params['origen'] = $origen;
        }

        if ($peligroMin > 0) {
            $query .= " AND artefactos.nivel_peligro >= :peligroMin";
            $params['peligroMin'] = $peligroMin;
        }

        $query .= " GROUP BY artefactos.id;";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute($params);

        $catalogo = [];

        while ($result = $PDOStatement->fetch()) {
            $catalogo[] = self::crearArtefacto($result);
        }

        return $catalogo;
    }



    /**
     * Inserta un nuevo artefacto a la base de datos
     * @param string $nombre
     * @param string $alias
     * @param int $categoria_id
     * @param int $personaje_creador_id
     * @param int $personaje_usuario_id
     * @param string $origen
     * @param int $nivel_peligro
     * @param string $fecha_fabricacion El dia de publicación en formato YYYY-DD-MM
     * @param string $descripcion
     * @param string $imagen ruta a un archivo .jpg o .png
     * @param float $precio
     * @param bool $robado
     * 
     * @return int El ID AI del elemento insertado.
     */
    public static function insert(string $nombre, string $alias, int $categoria_id, int $personaje_creador_id, int $personaje_usuario_id, string $origen, int $nivel_peligro, string $fecha_fabricacion, string $descripcion, string $imagen, float $precio, bool $robado): int
    {
        $conexion = Conexion::getConexion();
        $query = "INSERT INTO artefactos VALUES (NULL, :nombre, :alias, :categoria_id, :personaje_creador_id, :personaje_usuario_id, :origen, :nivel_peligro, :fecha_fabricacion, :descripcion, :imagen, :precio, :robado)";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'nombre' => $nombre,
                'alias' => $alias,
                'categoria_id' => $categoria_id,
                'personaje_creador_id' => $personaje_creador_id,
                'personaje_usuario_id' => $personaje_usuario_id,
                'origen' => $origen,
                'nivel_peligro' => $nivel_peligro,
                'fecha_fabricacion' => $fecha_fabricacion,
                'descripcion' => $descripcion,
                'imagen' => $imagen,
                'precio' => $precio,
                'robado' => (int) $robado
            ]
        );

        return (int) $conexion->lastInsertId();
    }

    /**
     * Crea un vinculo entre un artefacto y un componente
     * @param int $artefacto_id
     * @param int $componente_id
     */
    public static function add_componente(int $artefacto_id, int $componente_id)
    {
        $conexion = Conexion::getConexion();
        $query = "INSERT INTO componentes_x_artefacto VALUES (NULL, :artefacto_id, :componente_id)";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'artefacto_id' => $artefacto_id,
                'componente_id' => $componente_id
            ]
        );
    }

    /**
     * Vaciar lista de componentes del artefacto
     */
    public function clear_componentes()
    {
        $conexion = Conexion::getConexion();
        $query = "DELETE FROM componentes_x_artefacto WHERE artefacto_id = :artefacto_id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'artefacto_id' => $this->id
            ]
        );
    }


    public function edit(string $nombre, string $alias, int $categoria_id, int $personaje_creador_id, int $personaje_usuario_id, string $origen, int $nivel_peligro, string $fecha_fabricacion, string $descripcion, string $imagen, float $precio, bool $robado)
    {

        $conexion = Conexion::getConexion();
        $query = "UPDATE artefactos SET
         nombre = :nombre,
         alias = :alias,
         categoria_id = :categoria_id,
         personaje_creador_id = :personaje_creador_id,
         personaje_usuario_id = :personaje_usuario_id,
         origen = :origen,
         nivel_peligro = :nivel_peligro,
         fecha_fabricacion = :fecha_fabricacion,
         descripcion = :descripcion,
         imagen = :imagen,
         precio = :precio,
         robado = :robado    
        WHERE id = :id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'id' => $this->id,
                'nombre' => $nombre,
                'alias' => $alias,
                'categoria_id' => $categoria_id,
                'personaje_creador_id' => $personaje_creador_id,
                'personaje_usuario_id' => $personaje_usuario_id,
                'origen' => $origen,
                'nivel_peligro' => $nivel_peligro,
                'fecha_fabricacion' => $fecha_fabricacion,
                'descripcion' => $descripcion,
                'imagen' => $imagen,
                'precio' => $precio,
                'robado' => (int) $robado
            ]
        );
    }



    /**
     * Elimina esta instancia de la base de datos
     */
    public function delete()
    {

        $this->clear_componentes();

        $conexion = Conexion::getConexion();
        $query = "DELETE FROM artefactos WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([$this->id]);
    }


    /**
     * @return array listado de componentes del artefacto
     */
    public function get_componentes(): array
    {
        return $this->componentes;
    }

    /**
     * Devuelve un array simple con los IDs de los componentes
     */
    public function get_componentes_ids(): array
    {
        $ids = [];
        foreach ($this->get_componentes() as $c) {
            $ids[] = $c->getId();
        }
        return $ids;
    }

    /**
     * Esta método devuelve las primeras x palabras de la descripcion
     * 
     * @param int $cantidad Esta es la cantidad de palabras a extraer (Opcional)
     */
    public function get_descripcion_reducida(int $cantidad = 10): string
    {
        $texto = $this->descripcion;

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
    public function get_precio_iva() : float
    {
        return $this->precio * 1.21;
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

	public function getCategoria() : Categoria {
		return $this->categoria;
	}

	public function setCategoria(Categoria $value) {
		$this->categoria = $value;
	}

	public function getCreador() : Personaje {
		return $this->personaje_creador;
	}

	public function setCreador(Personaje $value) {
		$this->personaje_creador = $value;
	}

	public function getUsuario() : Personaje {
		return $this->personaje_usuario;
	}

	public function setUsuario(Personaje $value) {
		$this->personaje_usuario = $value;
	}

	public function getComponentes() : array {
		return $this->componentes;
	}

	public function setComponentes(array $value) {
		$this->componentes = $value;
	}

	public function getOrigen() : string {
		return $this->origen;
	}

	public function setOrigen(string $value) {
		$this->origen = $value;
	}

	public function getNivel_peligro() : int {
		return $this->nivel_peligro;
	}

	public function setNivel_peligro(int $value) {
		$this->nivel_peligro = $value;
	}

	public function getFecha_fabricacion() : string {
		return $this->fecha_fabricacion;
	}

	public function setFecha_fabricacion(string $value) {
		$this->fecha_fabricacion = $value;
	}

	public function getDescripcion() : string {
		return $this->descripcion;
	}

	public function setDescripcion(string $value) {
		$this->descripcion = $value;
	}

	public function getImagen() : string {
		return $this->imagen;
	}

	public function setImagen(string $value) {
		$this->imagen = $value;
	}

	public function getPrecio() : float {
		return $this->precio;
	}

	public function setPrecio(float $value) {
		$this->precio = $value;
	}

	public function getRobado() : bool {
		return $this->robado;
	}

	public function setRobado(bool $value) {
		$this->robado = $value;
	}
}