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
     * Busca en la base de datos la configuración de regateo según el ID del personaje.
     *
     * @param int $personajeId ID del personaje portador.
     * @return array Datos asociativos del regateo desde MySQL.
     */
    private static function obtener_datos_x_personaje(int $personajeId): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM regateos WHERE personaje_id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute([$personajeId]);

        $result = $PDOStatement->fetch();

        if ($result === false) {
            $PDOStatementFallback = $conexion->prepare("SELECT * FROM regateos WHERE id = 1");
            $PDOStatementFallback->setFetchMode(PDO::FETCH_ASSOC);
            $PDOStatementFallback->execute();
            $result = $PDOStatementFallback->fetch();
        }

        return $result;
    }

    /**
     * Crea e inicializa una instancia de Regateo con sus 3 rondas a partir de un Artefacto.
     *
     * @param Artefacto $artefacto Instancia del artefacto a negociar.
     * @return Regateo Instancia completa de Regateo.
     */
    public static function crearRegateo(Artefacto $artefacto): Regateo
    {
        $regateo = new self();
        $regateo->artefacto = $artefacto;
        $regateo->vendedor = $artefacto->getUsuario();

        $datos = self::obtener_datos_x_personaje($regateo->vendedor->getId());

        foreach (self::$campos_primitivos as $campo) {
            $regateo->{$campo} = $datos[$campo];
        }

        $regateo->instancias = [
            1 => [
                'mensaje' => $datos['mensaje_1'],
                'opciones' => [
                    'tecnico' => $datos['opcion_tecnica_1'],
                    'frontal' => $datos['opcion_frontal_1'],
                    'caotico' => $datos['opcion_caotica_1']
                ]
            ],
            2 => [
                'mensaje' => $datos['mensaje_2'],
                'opciones' => [
                    'frontal' => $datos['opcion_frontal_2'],
                    'caotico' => $datos['opcion_caotica_2'],
                    'tecnico' => $datos['opcion_tecnica_2']
                ]
            ],
            3 => [
                'mensaje' => $datos['mensaje_3'],
                'opciones' => [
                    'caotico' => $datos['opcion_caotica_3'],
                    'tecnico' => $datos['opcion_tecnica_3'],
                    'frontal' => $datos['opcion_frontal_3']
                ]
            ]
        ];

        return $regateo;
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
     * Reinicia el progreso de las 3 instancias y el resultado guardado de un artefacto.
     */
    public static function reiniciarRegateo(int $artefactoId): void
    {
        unset($_SESSION['progreso_regateo'][$artefactoId]);
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

    public function getPersonaje_id(): int
    {
        return $this->personaje_id;
    }

    public function getPersonalidad(): string
    {
        return $this->personalidad;
    }

    public function getInstancias(): array
    {
        return $this->instancias;
    }

    public function getArtefacto(): Artefacto
    {
        return $this->artefacto;
    }

    public function getVendedor(): Personaje
    {
        return $this->vendedor;
    }
}