<?php

class Regateo
{
    private int $id;
    private int $personaje_id;
    private string $personalidad;
    private string $saludo;
    private array $opciones = [];
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
        'saludo',
        'estrategia_correcta',
        'estrategia_intermedia',
        'respuesta_exito',
        'respuesta_neutral',
        'respuesta_fallo'
    ];

    /**
     * Busca en la base de datos la configuración de regateo según el ID del personaje.
     * Si el personaje fue creado recientemente y no tiene fila propia, usa el registro 1 por defecto.
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
     * Crea e inicializa una instancia de Regateo a partir de un objeto Artefacto.
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

        $regateo->opciones = [
            'tecnico' => $datos['opcion_tecnica'],
            'frontal' => $datos['opcion_frontal'],
            'caotico' => $datos['opcion_caotica']
        ];

        return $regateo;
    }

    /**
     * Evalúa la opción elegida por el usuario, calcula el precio final y lo guarda en sesión.
     *
     * @param string $eleccion Clave de la opción seleccionada ('tecnico', 'frontal' o 'caotico').
     * @return array Resumen del resultado del regateo.
     */
    public function evaluarJugada(string $eleccion): array
    {
        $precioBase = $this->artefacto->getPrecio();

        if ($eleccion === $this->estrategia_correcta) {
            $estado = 'exito';
            $modificador = -10;
            $factor = 0.90;
            $titulo = '¡TRATO CERRADO CON DESCUENTO! (-10%)';
            $badgeColor = 'success';
            $respuesta = $this->respuesta_exito;
        } 
        elseif ($eleccion === $this->estrategia_intermedia) {
            $estado = 'neutral';
            $modificador = 0;
            $factor = 1.00;
            $titulo = 'NEGOCIACIÓN EMPATADA (PRECIO SIN CAMBIOS)';
            $badgeColor = 'info';
            $respuesta = $this->respuesta_neutral;
        } 
        else {
            $estado = 'fallo';
            $modificador = 5;
            $factor = 1.05;
            $titulo = '¡PÉSIMA ELECCIÓN! RECARGO DEL +5%';
            $badgeColor = 'danger';
            $respuesta = $this->respuesta_fallo;
        }

        $precioFinal = round($precioBase * $factor, 2);

        $resultado = [
            'artefacto_id' => $this->artefacto->getId(),
            'eleccion' => $eleccion,
            'estado' => $estado,
            'titulo' => $titulo,
            'badge_color' => $badgeColor,
            'modificador' => $modificador,
            'respuesta' => $respuesta,
            'precio_base' => $precioBase,
            'precio_final' => $precioFinal,
            'precio_final_formateado' => '$' . number_format($precioFinal, 2, ',', '.')
        ];

        $_SESSION['regateos'][$this->artefacto->getId()] = $resultado;

        return $resultado;
    }

    /**
     * Devuelve el resultado guardado en sesión para un artefacto si ya fue negociado.
     *
     * @param int $artefactoId ID del artefacto.
     * @return ?array Datos del regateo guardado o null si aún no se jugó.
     */
    public static function obtenerRegateoGuardado(int $artefactoId): ?array
    {
        return $_SESSION['regateos'][$artefactoId] ?? null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $value): void
    {
        $this->id = $value;
    }

    public function getPersonaje_id(): int
    {
        return $this->personaje_id;
    }

    public function setPersonaje_id(int $value): void
    {
        $this->personaje_id = $value;
    }

    public function getPersonalidad(): string
    {
        return $this->personalidad;
    }

    public function setPersonalidad(string $value): void
    {
        $this->personalidad = $value;
    }

    public function getSaludo(): string
    {
        return $this->saludo;
    }

    public function setSaludo(string $value): void
    {
        $this->saludo = $value;
    }

    public function getOpciones(): array
    {
        return $this->opciones;
    }

    public function setOpciones(array $value): void
    {
        $this->opciones = $value;
    }

    public function getEstrategia_correcta(): string
    {
        return $this->estrategia_correcta;
    }

    public function setEstrategia_correcta(string $value): void
    {
        $this->estrategia_correcta = $value;
    }

    public function getEstrategia_intermedia(): string
    {
        return $this->estrategia_intermedia;
    }

    public function setEstrategia_intermedia(string $value): void
    {
        $this->estrategia_intermedia = $value;
    }

    public function getRespuesta_exito(): string
    {
        return $this->respuesta_exito;
    }

    public function setRespuesta_exito(string $value): void
    {
        $this->respuesta_exito = $value;
    }

    public function getRespuesta_neutral(): string
    {
        return $this->respuesta_neutral;
    }

    public function setRespuesta_neutral(string $value): void
    {
        $this->respuesta_neutral = $value;
    }

    public function getRespuesta_fallo(): string
    {
        return $this->respuesta_fallo;
    }

    public function setRespuesta_fallo(string $value): void
    {
        $this->respuesta_fallo = $value;
    }

    public function getArtefacto(): Artefacto
    {
        return $this->artefacto;
    }

    public function setArtefacto(Artefacto $value): void
    {
        $this->artefacto = $value;
    }

    public function getVendedor(): Personaje
    {
        return $this->vendedor;
    }

    public function setVendedor(Personaje $value): void
    {
        $this->vendedor = $value;
    }
}