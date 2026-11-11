<?PHP

class Artefacto
{
    private int $id;
    private string $nombre;
    private string $alias;
    private int $categoria_id;
    private int $personaje_creador_id;
    private int $personaje_usuario_id;
    private string $origen;
    private int $nivel_peligro;
    private string $fecha_fabricacion;
    private string $descripcion;
    private string $imagen;
    private float $precio;
    private bool $robado;


    /**
     * Devuelve el catálgo completo
     * 
     * @return Artefacto[] Un array de objetos Artefacto
     */
    public static function catalogo_completo(): array
    {

        $conexion = Conexion::getConexion();

        $query = "SELECT * FROM artefactos";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();

        $catalogo = $PDOStatement->fetchAll();

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
        $query = "SELECT * FROM artefactos WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$id]);

        $result = $PDOStatement->fetch();

        return $result ?? null;
    }

    public static function catalogo_x_categoria(int $categoriaID): array
    {
        $conexion = Conexion::getConexion();

        $query = "SELECT * FROM artefactos WHERE categoria_id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$categoriaID]);

        $catalogo = $PDOStatement->fetchAll();

        return $catalogo;
    }

    public static function catalogo_x_creador(int $creadorID): array
    {
        $conexion = Conexion::getConexion();

        $query = "SELECT * FROM artefactos WHERE personaje_creador_id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$creadorID]);

        $catalogo = $PDOStatement->fetchAll();

        return $catalogo;
    }

    public static function catalogo_x_usuario(int $usuarioID): array
    {
        $conexion = Conexion::getConexion();

        $query = "SELECT * FROM artefactos WHERE personaje_usuario_id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$usuarioID]);

        $catalogo = $PDOStatement->fetchAll();

        return $catalogo;
    }

    public static function catalogo_x_origen(string $origen): array
    {
        $conexion = Conexion::getConexion();

        $query = "SELECT * FROM artefactos WHERE origen = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$origen]);

        $catalogo = $PDOStatement->fetchAll();

        return $catalogo;
    }

    /**
     * Devuelve los artefactos en un determinado rango de precios
     * @param int $minimo El precio minimo. De no proveerlo se asumira 0;
     * @param int $maximo El precio máximo. De no proveerlo se asumiran infinito. 
     * 
     * @return Artefacto[] Un array de objetos Artefacto
     */
    public static function catalogo_x_rango_precio(int $minimo = 0, int $maximo = 0): array
    {
        $conexion = Conexion::getConexion();

        if ($maximo) {
            //Elegir artefactos con precio entre el mínimo y el máximo
            $query = "SELECT * FROM artefactos WHERE precio BETWEEN :minimo AND :maximo";
            $valores = [
                'minimo' => $minimo,
                'maximo' => $maximo
            ];
        } else {
            //Elegir artefactos con precio entre el mínimo y infinito
            $query = "SELECT * FROM artefactos WHERE precio > :minimo";
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
     * Devuelve los artefactos en un determinado rango de peligro
     * @param int $minimo El peligro minimo. De no proveerlo se asumira 0;
     * @param int $maximo El peligro máximo. De no proveerlo se asumiran infinito. 
     * 
     * @return Artefacto[] Un array de objetos Artefacto
     */
    public static function catalogo_x_rango_peligro(int $minimo = 0, int $maximo = 0): array
    {
        $conexion = Conexion::getConexion();

        if ($maximo) {
            //Elegir artefactos con peligro entre el mínimo y el máximo
            $query = "SELECT * FROM artefactos WHERE nivel_peligro BETWEEN :minimo AND :maximo";
            $valores = [
                'minimo' => $minimo,
                'maximo' => $maximo
            ];
        } else {
            //Elegir artefactos con peligro entre el mínimo y infinito
            $query = "SELECT * FROM artefactos WHERE nivel_peligro > :minimo";
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
        $query = "SELECT * FROM artefactos WHERE nombre LIKE :terminoNombre OR alias LIKE :terminoAlias";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([
            "terminoNombre" => "%$terminoSanitizado%",
            "terminoAlias" => "%$terminoSanitizado%"
        ]);

        $catalogo = $PDOStatement->fetchAll();

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

        return $conexion->lastInsertId();
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

        $conexion = Conexion::getConexion();
        $query = "SELECT componentes.* FROM componentes_x_artefacto
            LEFT JOIN componentes ON componentes_x_artefacto.componente_id = componentes.id
            WHERE artefacto_id = :artefacto_id";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, 'Componente');
        $PDOStatement->execute(
            [
                'artefacto_id' => $this->id
            ]
        );

        $result = $PDOStatement->fetchAll();

        return $result;
    }

    /**
     * Devuelve un array simple con los IDs de los componentes (para los checkboxes al editar)
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
    public function get_bajada_reducida(int $cantidad = 10): string
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
    public function get_precio_iva()
    {
        return $this->precio * 1.21;
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

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function setAlias(string $value)
    {
        $this->alias = $value;
    }

    public function getCategoria(): string
    {
        $categoria = Categoria::get_x_id($this->categoria_id);

        return $categoria ? $categoria->getNombre() : "Sin categoria";
    }

    public function setCategoria_id(int $value)
    {
        $this->categoria_id = $value;
    }

    public function getCreador(): string
    {
        $creador = Personaje::get_x_id($this->personaje_creador_id);
        return $creador ? $creador->getNombreCompleto() : "Desconocido";
    }

    public function setCreador_id(int $value)
    {
        $this->personaje_creador_id = $value;
    }

    public function getUsuario(): string
    {
        $usuario = Personaje::get_x_id($this->personaje_usuario_id);

        return $usuario ? $usuario->getNombreCompleto() : "Desconocido";
    }

    public function setUsuario_id(int $value)
    {
        $this->personaje_usuario_id = $value;
    }

    public function getOrigen(): string
    {
        return $this->origen;
    }

    public function setOrigen(string $value)
    {
        $this->origen = $value;
    }

    public function getNivel_peligro(): int
    {
        return $this->nivel_peligro;
    }

    public function setNivel_peligro(int $value)
    {
        $this->nivel_peligro = $value;
    }

    public function getFecha_fabricacion(): string
    {
        return $this->fecha_fabricacion;
    }

    public function setFecha_fabricacion(string $value)
    {
        $this->fecha_fabricacion = $value;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $value)
    {
        $this->descripcion = $value;
    }

    public function getImagen(): string
    {
        return $this->imagen;
    }

    public function setImagen(string $value)
    {
        $this->imagen = $value;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function setPrecio(float $value)
    {
        $this->precio = $value;
    }

    public function getRobado(): bool
    {
        return $this->robado;
    }

    public function setRobado(bool $value)
    {
        $this->robado = $value;
    }
}