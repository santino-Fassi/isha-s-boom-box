<?php

class Artefacto
{
    private int $id;
    private string $nombre;
    private string $alias;
    private Categoria $categoria;
    private Personaje $personaje_creador;
    private Personaje $personaje_usuario;
    private array $componentes = [];
    private string $origen;
    private int $nivel_peligro;
    private string $fecha_fabricacion;
    private string $descripcion;
    private string $imagen;
    private float $precio;
    private bool $robado;

    private static array $campos_primitivos = [
        'id',
        'nombre',
        'alias',
        'origen',
        'nivel_peligro',
        'fecha_fabricacion',
        'descripcion',
        'imagen',
        'precio',
        'robado'
    ];

    /**
     * Construye e hidrata una instancia de Artefacto con sus objetos relacionados a partir de un registro asociativo.
     *
     * @param array $artefactoData Datos obtenidos de la base de datos.
     * @return Artefacto Instancia de Artefacto configurada.
     */
    private static function crearArtefacto(array $artefactoData): Artefacto
    {
        $artefacto = new self();

        foreach (self::$campos_primitivos as $campo) {
            $artefacto->{$campo} = $artefactoData[$campo];
        }

        $artefacto->categoria = Categoria::get_x_id((int) $artefactoData['categoria_id']);
        $artefacto->personaje_creador = Personaje::get_x_id((int) $artefactoData['personaje_creador_id']);
        $artefacto->personaje_usuario = Personaje::get_x_id((int) $artefactoData['personaje_usuario_id']);

        $artefacto->componentes = [];
        $componentesIds = !empty($artefactoData['componentes']) ? explode(',', $artefactoData['componentes']) : [];

        foreach ($componentesIds as $id) {
            $componente = Componente::get_x_id((int) $id);
            if ($componente) {
                $artefacto->componentes[] = $componente;
            }
        }

        return $artefacto;
    }

    /**
     * Devuelve el catálogo completo de artefactos disponibles junto con sus componentes asociados.
     *
     * @return Artefacto[] Array de instancias de Artefacto.
     */
    public static function catalogo_completo(): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) AS componentes
            FROM artefactos
            LEFT JOIN componentes_x_artefacto AS cxa ON artefactos.id = cxa.artefacto_id
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
     * Busca y devuelve un artefacto específico según su identificador único.
     *
     * @param int $id Identificador único del artefacto.
     * @return ?Artefacto Instancia de Artefacto o null si no se encuentra.
     */
    public static function get_x_id(int $id): ?Artefacto
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) AS componentes
            FROM artefactos
            LEFT JOIN componentes_x_artefacto AS cxa ON artefactos.id = cxa.artefacto_id
            WHERE artefactos.id = ?
            GROUP BY artefactos.id;";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute([$id]);

        $result = $PDOStatement->fetch();

        return $result !== false ? self::crearArtefacto($result) : null;
    }

    /**
     * Devuelve los artefactos pertenecientes a una categoría determinada.
     *
     * @param int $categoriaID Identificador único de la categoría.
     * @return Artefacto[] Array de instancias de Artefacto.
     */
    public static function catalogo_x_categoria(int $categoriaID): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) AS componentes
            FROM artefactos
            LEFT JOIN componentes_x_artefacto AS cxa ON artefactos.id = cxa.artefacto_id
            WHERE artefactos.categoria_id = ?
            GROUP BY artefactos.id;";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute([$categoriaID]);

        $catalogo = [];

        while ($result = $PDOStatement->fetch()) {
            $catalogo[] = self::crearArtefacto($result);
        }

        return $catalogo;
    }

    /**
     * Devuelve los artefactos diseñados por un personaje creador específico.
     *
     * @param int $creadorID Identificador único del personaje creador.
     * @return Artefacto[] Array de instancias de Artefacto.
     */
    public static function catalogo_x_creador(int $creadorID): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) AS componentes
            FROM artefactos
            LEFT JOIN componentes_x_artefacto AS cxa ON artefactos.id = cxa.artefacto_id
            WHERE artefactos.personaje_creador_id = ?
            GROUP BY artefactos.id;";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute([$creadorID]);

        $catalogo = [];

        while ($result = $PDOStatement->fetch()) {
            $catalogo[] = self::crearArtefacto($result);
        }

        return $catalogo;
    }

    /**
     * Devuelve los artefactos utilizados por un personaje portador específico.
     *
     * @param int $usuarioID Identificador único del personaje usuario.
     * @return Artefacto[] Array de instancias de Artefacto.
     */
    public static function catalogo_x_usuario(int $usuarioID): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) AS componentes
            FROM artefactos
            LEFT JOIN componentes_x_artefacto AS cxa ON artefactos.id = cxa.artefacto_id
            WHERE artefactos.personaje_usuario_id = ?
            GROUP BY artefactos.id;";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute([$usuarioID]);

        $catalogo = [];

        while ($result = $PDOStatement->fetch()) {
            $catalogo[] = self::crearArtefacto($result);
        }

        return $catalogo;
    }

    /**
     * Devuelve los artefactos filtrados según su región o ciudad de origen.
     *
     * @param string $origen Nombre del origen de fabricación.
     * @return Artefacto[] Array de instancias de Artefacto.
     */
    public static function catalogo_x_origen(string $origen): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT artefactos.*, GROUP_CONCAT(cxa.componente_id) AS componentes
            FROM artefactos
            LEFT JOIN componentes_x_artefacto AS cxa ON artefactos.id = cxa.artefacto_id
            WHERE artefactos.origen = ?
            GROUP BY artefactos.id;";

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
     * Devuelve los artefactos comprendidos dentro de un rango de precios determinado.
     *
     * @param float $minimo Precio mínimo a filtrar (por defecto 0).
     * @param float $maximo Precio máximo a filtrar (0 para no aplicar límite superior).
     * @return Artefacto[] Array de instancias de Artefacto.
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
     * Devuelve los artefactos comprendidos dentro de un rango de nivel de peligro.
     *
     * @param int $minimo Nivel de peligro mínimo (por defecto 0).
     * @param int $maximo Nivel de peligro máximo (0 para no aplicar límite superior).
     * @return Artefacto[] Array de instancias de Artefacto.
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
     * Busca artefactos cuyo nombre o alias coincidan parcialmente con el término indicado.
     *
     * @param string $terminoBusqueda Texto a buscar en nombre o alias.
     * @return Artefacto[] Array de instancias de Artefacto coincidentes.
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
            'terminoNombre' => "%$terminoSanitizado%",
            'terminoAlias' => "%$terminoSanitizado%"
        ]);

        $catalogo = [];

        while ($result = $PDOStatement->fetch()) {
            $catalogo[] = self::crearArtefacto($result);
        }

        return $catalogo;
    }

    /**
     * Filtra el catálogo combinando de manera opcional término de búsqueda, origen y nivel de peligro mínimo.
     *
     * @param string $termino Texto a buscar en nombre o alias.
     * @param string $origen Región de origen del artefacto.
     * @param int $peligroMin Nivel de peligro mínimo requerido.
     * @return Artefacto[] Lista de artefactos que cumplen con los filtros aplicados.
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
     * Inserta un nuevo artefacto en la base de datos y devuelve su identificador autogenerado.
     *
     * @param string $nombre Nombre del artefacto.
     * @param string $alias Código o alias del modelo.
     * @param int $categoria_id ID de la categoría asociada.
     * @param int $personaje_creador_id ID del personaje inventor.
     * @param int $personaje_usuario_id ID del personaje portador.
     * @param string $origen Ciudad o región de origen.
     * @param int $nivel_peligro Nivel de peligro en escala del 1 al 10.
     * @param string $fecha_fabricacion Fecha de registro en formato YYYY-MM-DD.
     * @param string $descripcion Descripción detallada del artefacto.
     * @param string $imagen Nombre del archivo de imagen.
     * @param float $precio Valor en el mercado.
     * @param bool $robado Indica si fue expropiado o robado.
     * @return int ID del artefacto recién insertado.
     */
    public static function insert(
        string $nombre,
        string $alias,
        int $categoria_id,
        int $personaje_creador_id,
        int $personaje_usuario_id,
        string $origen,
        int $nivel_peligro,
        string $fecha_fabricacion,
        string $descripcion,
        string $imagen,
        float $precio,
        bool $robado
    ): int {
        $conexion = Conexion::getConexion();
        $query = "INSERT INTO artefactos VALUES (NULL, :nombre, :alias, :categoria_id, :personaje_creador_id, :personaje_usuario_id, :origen, :nivel_peligro, :fecha_fabricacion, :descripcion, :imagen, :precio, :robado)";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
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
        ]);

        return (int) $conexion->lastInsertId();
    }

    /**
     * Registra un vínculo entre un artefacto y un componente en la tabla puente.
     *
     * @param int $artefacto_id ID del artefacto.
     * @param int $componente_id ID del componente.
     * @return void
     */
    public static function add_componente(int $artefacto_id, int $componente_id): void
    {
        $conexion = Conexion::getConexion();
        $query = "INSERT INTO componentes_x_artefacto VALUES (NULL, :artefacto_id, :componente_id)";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
            'artefacto_id' => $artefacto_id,
            'componente_id' => $componente_id
        ]);
    }

    /**
     * Elimina todas las relaciones de componentes asociadas a este artefacto.
     *
     * @return void
     */
    public function clear_componentes(): void
    {
        $conexion = Conexion::getConexion();
        $query = "DELETE FROM componentes_x_artefacto WHERE artefacto_id = :artefacto_id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
            'artefacto_id' => $this->id
        ]);
    }

    /**
     * Actualiza los datos de este artefacto en la base de datos.
     *
     * @param string $nombre Nombre del artefacto.
     * @param string $alias Código o alias del modelo.
     * @param int $categoria_id ID de la categoría asociada.
     * @param int $personaje_creador_id ID del personaje inventor.
     * @param int $personaje_usuario_id ID del personaje portador.
     * @param string $origen Ciudad o región de origen.
     * @param int $nivel_peligro Nivel de peligro en escala del 1 al 10.
     * @param string $fecha_fabricacion Fecha de registro en formato YYYY-MM-DD.
     * @param string $descripcion Descripción detallada del artefacto.
     * @param string $imagen Nombre del archivo de imagen.
     * @param float $precio Valor en el mercado.
     * @param bool $robado Indica si fue expropiado o robado.
     * @return void
     */
    public function edit(
        string $nombre,
        string $alias,
        int $categoria_id,
        int $personaje_creador_id,
        int $personaje_usuario_id,
        string $origen,
        int $nivel_peligro,
        string $fecha_fabricacion,
        string $descripcion,
        string $imagen,
        float $precio,
        bool $robado
    ): void {
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
        $PDOStatement->execute([
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
        ]);
    }

    /**
     * Elimina este artefacto y sus vínculos con componentes de la base de datos.
     *
     * @return void
     */
    public function delete(): void
    {
        $this->clear_componentes();

        $conexion = Conexion::getConexion();
        $query = "DELETE FROM artefactos WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([$this->id]);
    }

    /**
     * Devuelve el listado de objetos Componente asociados al artefacto.
     *
     * @return Componente[] Array de instancias de Componente.
     */
    public function get_componentes(): array
    {
        return $this->componentes;
    }

    /**
     * Devuelve un array con los identificadores numéricos de los componentes asociados.
     *
     * @return int[] Lista de IDs de componentes.
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
     * Recorta la descripción del artefacto a una cantidad determinada de palabras.
     *
     * @param int $cantidad Cantidad máxima de palabras a conservar (por defecto 10).
     * @return string Texto resumido con puntos suspensivos si fue truncado.
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
     * Devuelve el precio unitario formateado con separadores de miles y decimales.
     *
     * @return string Precio formateado con símbolo monetario.
     */
    public function get_precio_formateado(): string
    {
        return "$" . number_format($this->precio, 2, ",", ".");
    }

    /**
     * Calcula y devuelve el precio final con el 21% de IVA incluido.
     *
     * @return float Precio con IVA.
     */
    public function get_precio_iva(): float
    {
        return $this->precio * 1.21;
    }

    /**
     * Devuelve el identificador único del artefacto.
     *
     * @return int ID del artefacto.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Establece el identificador único del artefacto.
     *
     * @param int $value Nuevo ID del artefacto.
     * @return void
     */
    public function setId(int $value): void
    {
        $this->id = $value;
    }

    /**
     * Devuelve el nombre del artefacto.
     *
     * @return string Nombre del artefacto.
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Establece el nombre del artefacto.
     *
     * @param string $value Nuevo nombre del artefacto.
     * @return void
     */
    public function setNombre(string $value): void
    {
        $this->nombre = $value;
    }

    /**
     * Devuelve el alias o código de modelo del artefacto.
     *
     * @return string Alias del artefacto.
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * Establece el alias o código de modelo del artefacto.
     *
     * @param string $value Nuevo alias del artefacto.
     * @return void
     */
    public function setAlias(string $value): void
    {
        $this->alias = $value;
    }

    /**
     * Devuelve el objeto Categoria asociado al artefacto.
     *
     * @return Categoria Categoría del artefacto.
     */
    public function getCategoria(): Categoria
    {
        return $this->categoria;
    }

    /**
     * Establece el objeto Categoria asociado al artefacto.
     *
     * @param Categoria $value Nueva categoría.
     * @return void
     */
    public function setCategoria(Categoria $value): void
    {
        $this->categoria = $value;
    }

    /**
     * Devuelve el objeto Personaje correspondiente al inventor o creador.
     *
     * @return Personaje Creador del artefacto.
     */
    public function getCreador(): Personaje
    {
        return $this->personaje_creador;
    }

    /**
     * Establece el objeto Personaje correspondiente al inventor o creador.
     *
     * @param Personaje $value Nuevo personaje creador.
     * @return void
     */
    public function setCreador(Personaje $value): void
    {
        $this->personaje_creador = $value;
    }

    /**
     * Devuelve el objeto Personaje correspondiente al portador habitual.
     *
     * @return Personaje Usuario o portador del artefacto.
     */
    public function getUsuario(): Personaje
    {
        return $this->personaje_usuario;
    }

    /**
     * Establece el objeto Personaje correspondiente al portador habitual.
     *
     * @param Personaje $value Nuevo personaje portador.
     * @return void
     */
    public function setUsuario(Personaje $value): void
    {
        $this->personaje_usuario = $value;
    }

    /**
     * Devuelve el listado de objetos Componente del artefacto.
     *
     * @return Componente[] Array de componentes.
     */
    public function getComponentes(): array
    {
        return $this->componentes;
    }

    /**
     * Establece el listado de objetos Componente del artefacto.
     *
     * @param Componente[] $value Nuevo array de componentes.
     * @return void
     */
    public function setComponentes(array $value): void
    {
        $this->componentes = $value;
    }

    /**
     * Devuelve la región de origen de fabricación del artefacto.
     *
     * @return string Origen del artefacto.
     */
    public function getOrigen(): string
    {
        return $this->origen;
    }

    /**
     * Establece la región de origen de fabricación del artefacto.
     *
     * @param string $value Nuevo origen del artefacto.
     * @return void
     */
    public function setOrigen(string $value): void
    {
        $this->origen = $value;
    }

    /**
     * Devuelve el nivel de peligro del artefacto (1 a 10).
     *
     * @return int Nivel de peligro.
     */
    public function getNivel_peligro(): int
    {
        return $this->nivel_peligro;
    }

    /**
     * Establece el nivel de peligro del artefacto.
     *
     * @param int $value Nuevo nivel de peligro.
     * @return void
     */
    public function setNivel_peligro(int $value): void
    {
        $this->nivel_peligro = $value;
    }

    /**
     * Devuelve la fecha de fabricación o registro del artefacto.
     *
     * @return string Fecha en formato YYYY-MM-DD.
     */
    public function getFecha_fabricacion(): string
    {
        return $this->fecha_fabricacion;
    }

    /**
     * Establece la fecha de fabricación o registro del artefacto.
     *
     * @param string $value Nueva fecha de fabricación.
     * @return void
     */
    public function setFecha_fabricacion(string $value): void
    {
        $this->fecha_fabricacion = $value;
    }

    /**
     * Devuelve la descripción completa del artefacto.
     *
     * @return string Descripción del artefacto.
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * Establece la descripción completa del artefacto.
     *
     * @param string $value Nueva descripción.
     * @return void
     */
    public function setDescripcion(string $value): void
    {
        $this->descripcion = $value;
    }

    /**
     * Devuelve el nombre del archivo de imagen del artefacto.
     *
     * @return string Nombre de archivo de imagen.
     */
    public function getImagen(): string
    {
        return $this->imagen;
    }

    /**
     * Establece el nombre del archivo de imagen del artefacto.
     *
     * @param string $value Nuevo archivo de imagen.
     * @return void
     */
    public function setImagen(string $value): void
    {
        $this->imagen = $value;
    }

    /**
     * Devuelve el precio numérico del artefacto.
     *
     * @return float Precio del artefacto.
     */
    public function getPrecio(): float
    {
        return $this->precio;
    }

    /**
     * Establece el precio numérico del artefacto.
     *
     * @param float $value Nuevo precio.
     * @return void
     */
    public function setPrecio(float $value): void
    {
        $this->precio = $value;
    }

    /**
     * Indica si el artefacto figura como robado o expropiado.
     *
     * @return bool True si es robado, false si es diseño original.
     */
    public function getRobado(): bool
    {
        return $this->robado;
    }

    /**
     * Establece el estado de robado del artefacto.
     *
     * @param bool $value Nuevo estado booleano.
     * @return void
     */
    public function setRobado(bool $value): void
    {
        $this->robado = $value;
    }
}