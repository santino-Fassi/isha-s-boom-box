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
     * Construye una instancia de Regateo a partir de los datos de la base de datos.
     */
    private static function crearRegateo($regateoData): Regateo
    {
        $regateo = new self();

        foreach (self::$campos_primitivos as $campo) {
            $regateo->{$campo} = $regateoData[$campo];
        }

        $regateo->vendedor = Personaje::get_x_id($regateoData['personaje_id']);

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
     * Verifica si un personaje tiene al menos un regateo registrado en la base de datos.
     *
     * @param int $personajeId ID del personaje portador.
     * @return bool True si tiene al menos un regateo, false en caso contrario.
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
     * Busca todos los regateos asociados a un personaje y devuelve uno elegido al azar,
     * o null si el personaje no tiene regateos cargados.
     *
     * @param int $personajeId ID del personaje portador.
     * @return ?array Datos asociativos del regateo elegido o null.
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
     * Si el personaje tiene varios regateos, elige uno al azar al comenzar y lo mantiene
     * en sesión durante las 3 rondas. Si no tiene ninguno, devuelve null.
     *
     * @param Artefacto $artefacto Instancia del artefacto a negociar.
     * @return ?Regateo Instancia de Regateo o null si el portador no tiene regateos.
     */
    public static function crear_regateo_x_artefacto(Artefacto $artefacto): ?Regateo
    {
        $artefactoId = $artefacto->getId();
        $personajeId = $artefacto->getUsuario()->getId();
        $regateo = null;

        // Si ya hay un regateo sorteado activo para esta partida, lo mantenemos en las 3 rondas
        if (isset($_SESSION['regateo_activo_id'][$artefactoId])) {
            $regateoGuardado = self::get_x_id((int) $_SESSION['regateo_activo_id'][$artefactoId]);
            if ($regateoGuardado && $regateoGuardado->getPersonaje_id() === $personajeId) {
                $regateo = $regateoGuardado;
            }
        }

        // Si no hay uno activo en sesión, sorteamos uno aleatorio entre los que tenga el personaje
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
     * Devuelve el listado completo de regateos para el ABM.
     *
     * @return Regateo[]
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
     * Devuelve los datos de un regateo en particular según su ID.
     *
     * @param int $id El ID único del regateo.
     * @return ?Regateo
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
     * Inserta un nuevo regateo en la base de datos.
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
     * Edita los datos de este regateo en la base de datos.
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
    ) {
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
     * Elimina esta instancia de la base de datos.
     */
    public function delete()
    {
        $conexion = Conexion::getConexion();
        $query = "DELETE FROM regateos WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([$this->id]);
    }

    /**
     * Devuelve el historial de elecciones realizadas en las rondas actuales (0 a 3).
     *
     * @return array Lista de rondas respondidas con su estado e ícono.
     */
    public function obtenerProgreso(): array
    {
        return $_SESSION['progreso_regateo'][$this->artefacto->getId()] ?? [];
    }

    /**
     * Registra la respuesta de una instancia (confetti, cara de póker o bomba).
     *
     * @param string $eleccion Clave elegida ('tecnico', 'frontal' o 'caotico').
     * @return void
     */
    public function registrarEleccion(string $eleccion): void
    {
        $artefactoId = $this->artefacto->getId();
        $progreso = $this->obtenerProgreso();

        if (count($progreso) >= 3) {
            return;
        }

        if ($eleccion === $this->estrategia_correcta) {
            $item = [
                'eleccion' => $eleccion,
                'estado' => 'correcta',
                'icono' => '🎉',
                'clase' => 'circulo-correcta',
                'etiqueta' => '¡Elección acertada!',
                'puntos' => 1
            ];
        } elseif ($eleccion === $this->estrategia_intermedia) {
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

        $_SESSION['progreso_regateo'][$artefactoId][] = $item;
    }

    /**
     * Calcula el veredicto final según la cantidad de respuestas correctas, neutras y erradas.
     *
     * @return ?array Resultado final del regateo o null si aún no se completaron las 3 instancias.
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
     * Reinicia el progreso de las 3 instancias, el regateo sorteado y el resultado guardado de un artefacto.
     */
    public static function reiniciarRegateo(int $artefactoId): void
    {
        unset($_SESSION['progreso_regateo'][$artefactoId]);
        unset($_SESSION['regateo_activo_id'][$artefactoId]);
        unset($_SESSION['regateos'][$artefactoId]);
    }

    /**
     * Devuelve el número de instancia actual (1, 2 o 3).
     */
    public function getRondaActual(): int
    {
        return min(3, count($this->obtenerProgreso()) + 1);
    }

    /**
     * Devuelve el mensaje del personaje correspondiente a la instancia actual.
     */
    public function getMensajeActual(): string
    {
        return $this->instancias[$this->getRondaActual()]['mensaje'];
    }

    /**
     * Devuelve las 3 opciones de argumento de la instancia actual.
     */
    public function getOpcionesActuales(): array
    {
        return $this->instancias[$this->getRondaActual()]['opciones'];
    }

    /**
     * Devuelve el resultado guardado en sesión para un artefacto si ya fue negociado.
     */
    public static function obtenerRegateoGuardado(int $artefactoId): ?array
    {
        return $_SESSION['regateos'][$artefactoId] ?? null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $value)
    {
        $this->id = $value;
    }

    public function getPersonaje_id(): int
    {
        return $this->personaje_id;
    }

    public function setPersonaje_id(int $value)
    {
        $this->personaje_id = $value;
    }

    public function getPersonalidad(): string
    {
        return $this->personalidad;
    }

    public function setPersonalidad(string $value)
    {
        $this->personalidad = $value;
    }

    public function getInstancias(): array
    {
        return $this->instancias;
    }

    public function setInstancias(array $value)
    {
        $this->instancias = $value;
    }

    public function getEstrategia_correcta(): string
    {
        return $this->estrategia_correcta;
    }

    public function setEstrategia_correcta(string $value)
    {
        $this->estrategia_correcta = $value;
    }

    public function getEstrategia_intermedia(): string
    {
        return $this->estrategia_intermedia;
    }

    public function setEstrategia_intermedia(string $value)
    {
        $this->estrategia_intermedia = $value;
    }

    public function getRespuesta_exito(): string
    {
        return $this->respuesta_exito;
    }

    public function setRespuesta_exito(string $value)
    {
        $this->respuesta_exito = $value;
    }

    public function getRespuesta_neutral(): string
    {
        return $this->respuesta_neutral;
    }

    public function setRespuesta_neutral(string $value)
    {
        $this->respuesta_neutral = $value;
    }

    public function getRespuesta_fallo(): string
    {
        return $this->respuesta_fallo;
    }

    public function setRespuesta_fallo(string $value)
    {
        $this->respuesta_fallo = $value;
    }

    public function getArtefacto(): Artefacto
    {
        return $this->artefacto;
    }

    public function setArtefacto(Artefacto $value)
    {
        $this->artefacto = $value;
    }

    public function getVendedor(): Personaje
    {
        return $this->vendedor;
    }

    public function setVendedor(Personaje $value)
    {
        $this->vendedor = $value;
    }
}