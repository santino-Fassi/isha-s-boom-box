<?php

class Regateo
{
    private int $id;
    private int $personaje_id;
    private string $personalidad;
    private array $instancias = [];
    private string $estrategia_correcta;
    private string $estrategia_intermedia;
    private string $respuesta_exito;
    private string $respuesta_neutral;
    private string $respuesta_fallo;
    private Artefacto $artefacto;
    private Personaje $vendedor;

    private static array $campos_primitivos = [
        'id',
        'personaje_id',
        'personalidad',
        'estrategia_correcta',
        'estrategia_intermedia',
        'respuesta_exito',
        'respuesta_neutral',
        'respuesta_fallo'
    ];

    /**
     * Construye e hidrata una instancia de Regateo a partir de un registro asociativo de la base de datos.
     *
     * @param array $regateoData Datos asociativos del regateo obtenidos de MySQL.
     * @return Regateo Instancia de Regateo configurada con sus 3 instancias de diálogo.
     */
    private static function crearRegateo(array $regateoData): Regateo
    {
        $regateo = new self();

        foreach (self::$campos_primitivos as $campo) {
            $regateo->{$campo} = $regateoData[$campo];
        }

        $regateo->vendedor = Personaje::get_x_id((int) $regateoData['personaje_id']);

        $regateo->instancias = [
            1 => [
                'mensaje' => $regateoData['mensaje_1'],
                'opciones' => [
                    'tecnico' => $regateoData['opcion_tecnica_1'],
                    'frontal' => $regateoData['opcion_frontal_1'],
                    'caotico' => $regateoData['opcion_caotica_1']
                ]
            ],
            2 => [
                'mensaje' => $regateoData['mensaje_2'],
                'opciones' => [
                    'frontal' => $regateoData['opcion_frontal_2'],
                    'caotico' => $regateoData['opcion_caotica_2'],
                    'tecnico' => $regateoData['opcion_tecnica_2']
                ]
            ],
            3 => [
                'mensaje' => $regateoData['mensaje_3'],
                'opciones' => [
                    'caotico' => $regateoData['opcion_caotica_3'],
                    'tecnico' => $regateoData['opcion_tecnica_3'],
                    'frontal' => $regateoData['opcion_frontal_3']
                ]
            ]
        ];

        return $regateo;
    }

    /**
     * Verifica si un personaje cuenta con al menos un regateo registrado en la base de datos.
     *
     * @param int $personajeId Identificador único del personaje portador.
     * @return bool True si tiene al menos un regateo asociado, false en caso contrario.
     */
    public static function personaje_tiene_regateo(int $personajeId): bool
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT id FROM regateos WHERE personaje_id = ? LIMIT 1";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([$personajeId]);

        return $PDOStatement->fetch() !== false;
    }

    /**
     * Busca todos los regateos asociados a un personaje y devuelve uno seleccionado al azar.
     *
     * @param int $personajeId Identificador único del personaje portador.
     * @return ?array Datos asociativos del regateo sorteado o null si no existen registros.
     */
    private static function obtener_datos_x_personaje(int $personajeId): ?array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM regateos WHERE personaje_id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute([$personajeId]);

        $resultados = $PDOStatement->fetchAll();

        if (empty($resultados)) {
            return null;
        }

        $indiceAleatorio = array_rand($resultados);
        return $resultados[$indiceAleatorio];
    }

    /**
     * Crea e inicializa una instancia de Regateo a partir de un Artefacto.
     * Si el personaje posee varios regateos, sortea uno al comenzar y lo preserva en sesión durante las 3 rondas.
     *
     * @param Artefacto $artefacto Instancia del artefacto a negociar.
     * @return ?Regateo Instancia de Regateo configurada o null si el portador no posee regateos.
     */
    public static function crear_regateo_x_artefacto(Artefacto $artefacto): ?Regateo
    {
        $artefactoId = $artefacto->getId();
        $personajeId = $artefacto->getUsuario()->getId();
        $regateo = null;

        if (isset($_SESSION['regateo_activo_id'][$artefactoId])) {
            $regateoGuardado = self::get_x_id((int) $_SESSION['regateo_activo_id'][$artefactoId]);
            if ($regateoGuardado && $regateoGuardado->getPersonaje_id() === $personajeId) {
                $regateo = $regateoGuardado;
            }
        }

        if (!$regateo) {
            $datos = self::obtener_datos_x_personaje($personajeId);
            if (!$datos) {
                return null;
            }
            $regateo = self::crearRegateo($datos);
            $_SESSION['regateo_activo_id'][$artefactoId] = $regateo->getId();
        }

        $regateo->artefacto = $artefacto;
        $regateo->vendedor = $artefacto->getUsuario();

        return $regateo;
    }

    /**
     * Devuelve el listado completo de regateos registrados en la base de datos.
     *
     * @return Regateo[] Array de instancias de Regateo.
     */
    public static function listado_completo(): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM regateos";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute();

        $lista = [];
        while ($result = $PDOStatement->fetch()) {
            $lista[] = self::crearRegateo($result);
        }

        return $lista;
    }

    /**
     * Busca y devuelve un regateo específico según su identificador único.
     *
     * @param int $id Identificador único del regateo.
     * @return ?Regateo Instancia de Regateo o null si no se encuentra.
     */
    public static function get_x_id(int $id): ?Regateo
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM regateos WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute([$id]);

        $result = $PDOStatement->fetch();

        return $result !== false ? self::crearRegateo($result) : null;
    }

    /**
     * Inserta un nuevo registro de regateo en la base de datos y devuelve su ID autogenerado.
     *
     * @param int $personaje_id ID del personaje vendedor.
     * @param string $personalidad Rasgo de personalidad del vendedor.
     * @param string $mensaje_1 Diálogo de la primera instancia.
     * @param string $opcion_tecnica_1 Argumento técnico de la primera instancia.
     * @param string $opcion_frontal_1 Argumento frontal de la primera instancia.
     * @param string $opcion_caotica_1 Argumento caótico de la primera instancia.
     * @param string $mensaje_2 Diálogo de la segunda instancia.
     * @param string $opcion_tecnica_2 Argumento técnico de la segunda instancia.
     * @param string $opcion_frontal_2 Argumento frontal de la segunda instancia.
     * @param string $opcion_caotica_2 Argumento caótico de la segunda instancia.
     * @param string $mensaje_3 Diálogo de la tercera instancia.
     * @param string $opcion_tecnica_3 Argumento técnico de la tercera instancia.
     * @param string $opcion_frontal_3 Argumento frontal de la tercera instancia.
     * @param string $opcion_caotica_3 Argumento caótico de la tercera instancia.
     * @param string $estrategia_correcta Clave de la estrategia que otorga descuento ('tecnico', 'frontal' o 'caotico').
     * @param string $estrategia_intermedia Clave de la estrategia que mantiene el precio ('tecnico', 'frontal' o 'caotico').
     * @param string $respuesta_exito Respuesta final del vendedor al lograr el descuento.
     * @param string $respuesta_neutral Respuesta final del vendedor al empatar la negociación.
     * @param string $respuesta_fallo Respuesta final del vendedor al fallar la negociación.
     * @return int Identificador único del regateo recién insertado.
     */
    public static function insert(
        int $personaje_id,
        string $personalidad,
        string $mensaje_1,
        string $opcion_tecnica_1,
        string $opcion_frontal_1,
        string $opcion_caotica_1,
        string $mensaje_2,
        string $opcion_tecnica_2,
        string $opcion_frontal_2,
        string $opcion_caotica_2,
        string $mensaje_3,
        string $opcion_tecnica_3,
        string $opcion_frontal_3,
        string $opcion_caotica_3,
        string $estrategia_correcta,
        string $estrategia_intermedia,
        string $respuesta_exito,
        string $respuesta_neutral,
        string $respuesta_fallo
    ): int {
        $conexion = Conexion::getConexion();
        $query = "INSERT INTO regateos VALUES (
            NULL, :personaje_id, :personalidad,
            :mensaje_1, :opcion_tecnica_1, :opcion_frontal_1, :opcion_caotica_1,
            :mensaje_2, :opcion_tecnica_2, :opcion_frontal_2, :opcion_caotica_2,
            :mensaje_3, :opcion_tecnica_3, :opcion_frontal_3, :opcion_caotica_3,
            :estrategia_correcta, :estrategia_intermedia,
            :respuesta_exito, :respuesta_neutral, :respuesta_fallo
        )";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
            'personaje_id' => $personaje_id,
            'personalidad' => $personalidad,
            'mensaje_1' => $mensaje_1,
            'opcion_tecnica_1' => $opcion_tecnica_1,
            'opcion_frontal_1' => $opcion_frontal_1,
            'opcion_caotica_1' => $opcion_caotica_1,
            'mensaje_2' => $mensaje_2,
            'opcion_tecnica_2' => $opcion_tecnica_2,
            'opcion_frontal_2' => $opcion_frontal_2,
            'opcion_caotica_2' => $opcion_caotica_2,
            'mensaje_3' => $mensaje_3,
            'opcion_tecnica_3' => $opcion_tecnica_3,
            'opcion_frontal_3' => $opcion_frontal_3,
            'opcion_caotica_3' => $opcion_caotica_3,
            'estrategia_correcta' => $estrategia_correcta,
            'estrategia_intermedia' => $estrategia_intermedia,
            'respuesta_exito' => $respuesta_exito,
            'respuesta_neutral' => $respuesta_neutral,
            'respuesta_fallo' => $respuesta_fallo
        ]);

        return (int) $conexion->lastInsertId();
    }

    /**
     * Actualiza los datos de este regateo en la base de datos.
     *
     * @param int $personaje_id ID del personaje vendedor.
     * @param string $personalidad Rasgo de personalidad del vendedor.
     * @param string $mensaje_1 Diálogo de la primera instancia.
     * @param string $opcion_tecnica_1 Argumento técnico de la primera instancia.
     * @param string $opcion_frontal_1 Argumento frontal de la primera instancia.
     * @param string $opcion_caotica_1 Argumento caótico de la primera instancia.
     * @param string $mensaje_2 Diálogo de la segunda instancia.
     * @param string $opcion_tecnica_2 Argumento técnico de la segunda instancia.
     * @param string $opcion_frontal_2 Argumento frontal de la segunda instancia.
     * @param string $opcion_caotica_2 Argumento caótico de la segunda instancia.
     * @param string $mensaje_3 Diálogo de la tercera instancia.
     * @param string $opcion_tecnica_3 Argumento técnico de la tercera instancia.
     * @param string $opcion_frontal_3 Argumento frontal de la tercera instancia.
     * @param string $opcion_caotica_3 Argumento caótico de la tercera instancia.
     * @param string $estrategia_correcta Clave de la estrategia que otorga descuento.
     * @param string $estrategia_intermedia Clave de la estrategia que mantiene el precio.
     * @param string $respuesta_exito Respuesta final del vendedor al lograr el descuento.
     * @param string $respuesta_neutral Respuesta final del vendedor al empatar la negociación.
     * @param string $respuesta_fallo Respuesta final del vendedor al fallar la negociación.
     * @return void
     */
    public function edit(
        int $personaje_id,
        string $personalidad,
        string $mensaje_1,
        string $opcion_tecnica_1,
        string $opcion_frontal_1,
        string $opcion_caotica_1,
        string $mensaje_2,
        string $opcion_tecnica_2,
        string $opcion_frontal_2,
        string $opcion_caotica_2,
        string $mensaje_3,
        string $opcion_tecnica_3,
        string $opcion_frontal_3,
        string $opcion_caotica_3,
        string $estrategia_correcta,
        string $estrategia_intermedia,
        string $respuesta_exito,
        string $respuesta_neutral,
        string $respuesta_fallo
    ): void {
        $conexion = Conexion::getConexion();
        $query = "UPDATE regateos SET
            personaje_id = :personaje_id,
            personalidad = :personalidad,
            mensaje_1 = :mensaje_1,
            opcion_tecnica_1 = :opcion_tecnica_1,
            opcion_frontal_1 = :opcion_frontal_1,
            opcion_caotica_1 = :opcion_caotica_1,
            mensaje_2 = :mensaje_2,
            opcion_tecnica_2 = :opcion_tecnica_2,
            opcion_frontal_2 = :opcion_frontal_2,
            opcion_caotica_2 = :opcion_caotica_2,
            mensaje_3 = :mensaje_3,
            opcion_tecnica_3 = :opcion_tecnica_3,
            opcion_frontal_3 = :opcion_frontal_3,
            opcion_caotica_3 = :opcion_caotica_3,
            estrategia_correcta = :estrategia_correcta,
            estrategia_intermedia = :estrategia_intermedia,
            respuesta_exito = :respuesta_exito,
            respuesta_neutral = :respuesta_neutral,
            respuesta_fallo = :respuesta_fallo
        WHERE id = :id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
            'id' => $this->id,
            'personaje_id' => $personaje_id,
            'personalidad' => $personalidad,
            'mensaje_1' => $mensaje_1,
            'opcion_tecnica_1' => $opcion_tecnica_1,
            'opcion_frontal_1' => $opcion_frontal_1,
            'opcion_caotica_1' => $opcion_caotica_1,
            'mensaje_2' => $mensaje_2,
            'opcion_tecnica_2' => $opcion_tecnica_2,
            'opcion_frontal_2' => $opcion_frontal_2,
            'opcion_caotica_2' => $opcion_caotica_2,
            'mensaje_3' => $mensaje_3,
            'opcion_tecnica_3' => $opcion_tecnica_3,
            'opcion_frontal_3' => $opcion_frontal_3,
            'opcion_caotica_3' => $opcion_caotica_3,
            'estrategia_correcta' => $estrategia_correcta,
            'estrategia_intermedia' => $estrategia_intermedia,
            'respuesta_exito' => $respuesta_exito,
            'respuesta_neutral' => $respuesta_neutral,
            'respuesta_fallo' => $respuesta_fallo
        ]);
    }

    /**
     * Elimina este registro de regateo de la base de datos.
     *
     * @return void
     */
    public function delete(): void
    {
        $conexion = Conexion::getConexion();
        $query = "DELETE FROM regateos WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([$this->id]);
    }

    /**
     * Devuelve el historial de elecciones realizadas en las rondas actuales (de 0 a 3).
     *
     * @return array Lista de rondas respondidas con su estado, puntaje e ícono.
     */
    public function obtenerProgreso(): array
    {
        return $_SESSION['progreso_regateo'][$this->artefacto->getId()] ?? [];
    }

    /**
     * Registra la respuesta de una instancia en su posición exacta (0, 1 o 2).
     *
     * @param array $estrategias Array asociativo recibido por POST (ej. [0 => 'caotico']).
     * @return void
     */
    public function registrarEleccion(array $estrategias): void
    {
        $artefactoId = $this->artefacto->getId();

        foreach ($estrategias as $indice => $eleccion) {

            if ($indice < 0 || $indice > 2 || $eleccion == '') {
                continue;
            }

            if ($eleccion == $this->estrategia_correcta) {
                $item = [
                    'eleccion' => $eleccion,
                    'estado' => 'correcta',
                    'icono' => '🎉',
                    'clase' => 'circulo-correcta',
                    'etiqueta' => '¡Elección acertada!',
                    'puntos' => 1
                ];
            } elseif ($eleccion == $this->estrategia_intermedia) {
                $item = [
                    'eleccion' => $eleccion,
                    'estado' => 'neutra',
                    'icono' => '😐',
                    'clase' => 'circulo-neutra',
                    'etiqueta' => 'Reacción neutra',
                    'puntos' => 0
                ];
            } else {
                $item = [
                    'eleccion' => $eleccion,
                    'estado' => 'error',
                    'icono' => '💣',
                    'clase' => 'circulo-error',
                    'etiqueta' => '¡Pésima elección!',
                    'puntos' => -1
                ];
            }

            $_SESSION['progreso_regateo'][$artefactoId][$indice] = $item;
        }
    }

    /**
     * Calcula el veredicto final de la negociación según el balance de aciertos, neutros y errores en las 3 instancias.
     *
     * @return ?array Resumen asociativo del resultado final o null si aún no se completaron las 3 instancias.
     */
    public function evaluarResultadoFinal(): ?array
    {
        $progreso = $this->obtenerProgreso();

        if (count($progreso) < 3) {
            return self::obtenerRegateoGuardado($this->artefacto->getId());
        }

        $correctas = 0;
        $neutras = 0;
        $erradas = 0;
        $puntajeTotal = 0;

        foreach ($progreso as $ronda) {
            $puntajeTotal += $ronda['puntos'];
            if ($ronda['estado'] === 'correcta') {
                $correctas++;
            } elseif ($ronda['estado'] === 'neutra') {
                $neutras++;
            } else {
                $erradas++;
            }
        }

        $precioBase = $this->artefacto->getPrecio();

        if ($puntajeTotal > 0) {
            $estado = 'exito';
            $modificador = -10;
            $factor = 0.90;
            $titulo = '¡TRATO CERRADO CON DESCUENTO! (-10%)';
            $badgeColor = 'success';
            $respuesta = $this->respuesta_exito;
        } elseif ($puntajeTotal === 0) {
            $estado = 'neutral';
            $modificador = 0;
            $factor = 1.00;
            $titulo = 'NEGOCIACIÓN EMPATADA (PRECIO SIN CAMBIOS)';
            $badgeColor = 'info';
            $respuesta = $this->respuesta_neutral;
        } else {
            $estado = 'fallo';
            $modificador = 5;
            $factor = 1.05;
            $titulo = '¡NEGOCIACIÓN FALLIDA! RECARGO DEL +5%';
            $badgeColor = 'danger';
            $respuesta = $this->respuesta_fallo;
        }

        $precioFinal = round($precioBase * $factor, 2);

        $resultado = [
            'artefacto_id' => $this->artefacto->getId(),
            'regateo_id' => $this->id,
            'estado' => $estado,
            'titulo' => $titulo,
            'badge_color' => $badgeColor,
            'modificador' => $modificador,
            'respuesta' => $respuesta,
            'precio_base' => $precioBase,
            'precio_final' => $precioFinal,
            'precio_final_formateado' => '$' . number_format($precioFinal, 2, ',', '.'),
            'historial' => $progreso,
            'correctas' => $correctas,
            'neutras' => $neutras,
            'erradas' => $erradas
        ];

        $_SESSION['regateos'][$this->artefacto->getId()] = $resultado;

        return $resultado;
    }

    /**
     * Reinicia en sesión el progreso de las 3 instancias, el regateo sorteado y el resultado previo de un artefacto.
     *
     * @param int $artefactoId Identificador único del artefacto.
     * @return void
     */
    public static function reiniciarRegateo(int $artefactoId): void
    {
        unset($_SESSION['progreso_regateo'][$artefactoId]);
        unset($_SESSION['regateo_activo_id'][$artefactoId]);
        unset($_SESSION['regateos'][$artefactoId]);
    }

    /**
     * Devuelve el número de instancia actual en curso (1, 2 o 3).
     *
     * @return int Número de instancia actual.
     */
    public function getRondaActual(): int
    {
        return min(3, count($this->obtenerProgreso()) + 1);
    }

    /**
     * Devuelve el mensaje de diálogo del personaje correspondiente a la instancia actual.
     *
     * @return string Mensaje de la instancia en curso.
     */
    public function getMensajeActual(): string
    {
        return $this->instancias[$this->getRondaActual()]['mensaje'];
    }

    /**
     * Devuelve las 3 opciones de argumento disponibles en la instancia actual.
     *
     * @return array<string, string> Mapa asociativo [clave_estrategia => texto_argumento].
     */
    public function getOpcionesActuales(): array
    {
        return $this->instancias[$this->getRondaActual()]['opciones'];
    }

    /**
     * Devuelve el resultado final almacenado en sesión para un artefacto si ya fue negociado previamente.
     *
     * @param int $artefactoId Identificador único del artefacto.
     * @return ?array Datos del resultado guardado o null si no existe.
     */
    public static function obtenerRegateoGuardado(int $artefactoId): ?array
    {
        return $_SESSION['regateos'][$artefactoId] ?? null;
    }

    /**
     * Devuelve el identificador único del regateo.
     *
     * @return int ID del regateo.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Establece el identificador único del regateo.
     *
     * @param int $value Nuevo ID del regateo.
     * @return void
     */
    public function setId(int $value): void
    {
        $this->id = $value;
    }

    /**
     * Devuelve el identificador del personaje asociado al regateo.
     *
     * @return int ID del personaje vendedor.
     */
    public function getPersonaje_id(): int
    {
        return $this->personaje_id;
    }

    /**
     * Establece el identificador del personaje asociado al regateo.
     *
     * @param int $value Nuevo ID del personaje.
     * @return void
     */
    public function setPersonaje_id(int $value): void
    {
        $this->personaje_id = $value;
    }

    /**
     * Devuelve la descripción de personalidad del vendedor en este regateo.
     *
     * @return string Personalidad del vendedor.
     */
    public function getPersonalidad(): string
    {
        return $this->personalidad;
    }

    /**
     * Establece la descripción de personalidad del vendedor.
     *
     * @param string $value Nueva personalidad.
     * @return void
     */
    public function setPersonalidad(string $value): void
    {
        $this->personalidad = $value;
    }

    /**
     * Devuelve la estructura completa de las 3 instancias de diálogo y opciones.
     *
     * @return array Estructura de las 3 instancias.
     */
    public function getInstancias(): array
    {
        return $this->instancias;
    }

    /**
     * Establece la estructura de las 3 instancias de diálogo y opciones.
     *
     * @param array $value Nueva estructura de instancias.
     * @return void
     */
    public function setInstancias(array $value): void
    {
        $this->instancias = $value;
    }

    /**
     * Devuelve la clave de la estrategia correcta que otorga descuento.
     *
     * @return string Clave de estrategia correcta ('tecnico', 'frontal' o 'caotico').
     */
    public function getEstrategia_correcta(): string
    {
        return $this->estrategia_correcta;
    }

    /**
     * Establece la clave de la estrategia correcta.
     *
     * @param string $value Nueva estrategia correcta.
     * @return void
     */
    public function setEstrategia_correcta(string $value): void
    {
        $this->estrategia_correcta = $value;
    }

    /**
     * Devuelve la clave de la estrategia intermedia o neutra.
     *
     * @return string Clave de estrategia intermedia ('tecnico', 'frontal' o 'caotico').
     */
    public function getEstrategia_intermedia(): string
    {
        return $this->estrategia_intermedia;
    }

    /**
     * Establece la clave de la estrategia intermedia.
     *
     * @param string $value Nueva estrategia intermedia.
     * @return void
     */
    public function setEstrategia_intermedia(string $value): void
    {
        $this->estrategia_intermedia = $value;
    }

    /**
     * Devuelve el mensaje de respuesta final en caso de éxito en la negociación.
     *
     * @return string Respuesta de éxito.
     */
    public function getRespuesta_exito(): string
    {
        return $this->respuesta_exito;
    }

    /**
     * Establece el mensaje de respuesta final en caso de éxito.
     *
     * @param string $value Nueva respuesta de éxito.
     * @return void
     */
    public function setRespuesta_exito(string $value): void
    {
        $this->respuesta_exito = $value;
    }

    /**
     * Devuelve el mensaje de respuesta final en caso de resultado neutral.
     *
     * @return string Respuesta neutral.
     */
    public function getRespuesta_neutral(): string
    {
        return $this->respuesta_neutral;
    }

    /**
     * Establece el mensaje de respuesta final en caso de resultado neutral.
     *
     * @param string $value Nueva respuesta neutral.
     * @return void
     */
    public function setRespuesta_neutral(string $value): void
    {
        $this->respuesta_neutral = $value;
    }

    /**
     * Devuelve el mensaje de respuesta final en caso de fallo en la negociación.
     *
     * @return string Respuesta de fallo.
     */
    public function getRespuesta_fallo(): string
    {
        return $this->respuesta_fallo;
    }

    /**
     * Establece el mensaje de respuesta final en caso de fallo.
     *
     * @param string $value Nueva respuesta de fallo.
     * @return void
     */
    public function setRespuesta_fallo(string $value): void
    {
        $this->respuesta_fallo = $value;
    }

    /**
     * Devuelve la instancia del objeto Artefacto vinculada a la negociación.
     *
     * @return Artefacto Artefacto en negociación.
     */
    public function getArtefacto(): Artefacto
    {
        return $this->artefacto;
    }

    /**
     * Establece la instancia del objeto Artefacto vinculada a la negociación.
     *
     * @param Artefacto $value Nuevo artefacto.
     * @return void
     */
    public function setArtefacto(Artefacto $value): void
    {
        $this->artefacto = $value;
    }

    /**
     * Devuelve la instancia del objeto Personaje que actúa como vendedor.
     *
     * @return Personaje Personaje vendedor.
     */
    public function getVendedor(): Personaje
    {
        return $this->vendedor;
    }

    /**
     * Establece la instancia del objeto Personaje que actúa como vendedor.
     *
     * @param Personaje $value Nuevo personaje vendedor.
     * @return void
     */
    public function setVendedor(Personaje $value): void
    {
        $this->vendedor = $value;
    }
}