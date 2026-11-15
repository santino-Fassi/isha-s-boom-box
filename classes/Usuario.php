<?php

class Usuario
{
    private int $id;
    private string $email;
    private string $nombre_usuario;
    private string $nombre_completo;
    private string $password;
    private string $rol;

    /**
     * Busca y devuelve un usuario según su nombre de usuario.
     *
     * @param string $username Nombre de usuario a buscar.
     * @return ?Usuario Instancia de Usuario o null si no se encuentra.
     */
    public static function usuario_x_username(string $username): ?Usuario
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM usuarios WHERE nombre_usuario = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$username]);

        $result = $PDOStatement->fetch();

        return $result !== false ? $result : null;
    }

    /**
     * Devuelve el identificador único del usuario.
     *
     * @return int ID del usuario.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Establece el identificador único del usuario.
     *
     * @param int $id Nuevo ID del usuario.
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Devuelve el correo electrónico del usuario.
     *
     * @return string Email del usuario.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Establece el correo electrónico del usuario.
     *
     * @param string $email Nuevo email del usuario.
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Devuelve el nombre de usuario utilizado para iniciar sesión.
     *
     * @return string Nombre de usuario.
     */
    public function getNombre_usuario(): string
    {
        return $this->nombre_usuario;
    }

    /**
     * Establece el nombre de usuario.
     *
     * @param string $nombre_usuario Nuevo nombre de usuario.
     * @return void
     */
    public function setNombre_usuario(string $nombre_usuario): void
    {
        $this->nombre_usuario = $nombre_usuario;
    }

    /**
     * Devuelve el nombre completo del usuario.
     *
     * @return string Nombre completo.
     */
    public function getNombre_completo(): string
    {
        return $this->nombre_completo;
    }

    /**
     * Establece el nombre completo del usuario.
     *
     * @param string $nombre_completo Nuevo nombre completo.
     * @return void
     */
    public function setNombre_completo(string $nombre_completo): void
    {
        $this->nombre_completo = $nombre_completo;
    }

    /**
     * Devuelve el hash de contraseña del usuario.
     *
     * @return string Hash de contraseña.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Establece el hash de contraseña del usuario.
     *
     * @param string $password Nuevo hash de contraseña.
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Devuelve el rol asignado al usuario.
     *
     * @return string Rol del usuario.
     */
    public function getRol(): string
    {
        return $this->rol;
    }

    /**
     * Establece el rol asignado al usuario.
     *
     * @param string $rol Nuevo rol del usuario.
     * @return void
     */
    public function setRol(string $rol): void
    {
        $this->rol = $rol;
    }
}
