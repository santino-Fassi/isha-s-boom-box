<?php

class Autenticacion
{
    /**
     * Verifica las credenciales del usuario y, de ser correctas, almacena sus datos en la sesión.
     *
     * @param string $usuario Nombre de usuario ingresado.
     * @param string $password Contraseña ingresada.
     * @return mixed Rol del usuario si las credenciales son válidas, false si la contraseña falla o null si el usuario no existe.
     */
    public static function log_in(string $usuario, string $password): mixed
    {
        $datosUsuario = Usuario::usuario_x_username($usuario);

        if ($datosUsuario) {
            if (password_verify($password, $datosUsuario->getPassword())) {
                $datosLogin = [
                    'username' => $datosUsuario->getNombre_usuario(),
                    'nombre_completo' => $datosUsuario->getNombre_completo(),
                    'id' => $datosUsuario->getId(),
                    'rol' => $datosUsuario->getRol()
                ];

                $_SESSION['loggedIn'] = $datosLogin;

                return $datosLogin['rol'];
            } else {
                return false;
            }
        } else {
            return null;
        }
    }

    /**
     * Cierra la sesión activa del usuario eliminando sus datos de sesión.
     *
     * @return void
     */
    public static function log_out(): void
    {
        if (isset($_SESSION['loggedIn'])) {
            unset($_SESSION['loggedIn']);
        }
    }

    /**
     * Verifica si el usuario actual cumple con el nivel de permisos requerido para acceder a una vista.
     *
     * @param int $nivel Nivel de restricción (0 público, 1 usuario registrado, 2 administrador).
     * @return bool True si cuenta con permisos suficientes, false en caso contrario.
     */
    public static function verify(int $nivel = 0): bool
    {
        if (!$nivel) {
            return true;
        }

        if (isset($_SESSION['loggedIn'])) {
            if ($nivel > 1) {
                if ($_SESSION['loggedIn']['rol'] === 'admin' || $_SESSION['loggedIn']['rol'] === 'superadmin') {
                    return true;
                } else {
                    header('Location: index.php?sec=403');
                    return false;
                }
            } else {
                return true;
            }
        } else {
            header('Location: index.php?sec=login');
            return false;
        }
    }
}
