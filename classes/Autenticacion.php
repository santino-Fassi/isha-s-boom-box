<?PHP

class Autenticacion
{

    /**
     * Verifica las credenciales del usuario, y de ser correctas, guarda los datos en la sesión
     * @param string $usuario El nombre de usuario provisto
     * @param string $password El password provisto
     * @return mixed Devuelve el rol en caso que las credenciales sean correctas, FALSE en caso de que no lo sean y Null en caso que el usuario no se encuentre en la BDD
     */
    public static function log_in(string $usuario, string $password) : mixed
    {


        $datosUsuario = Usuario::usuario_x_username($usuario);


        if ($datosUsuario) {
            // SE ENCONTRÓ EL USUARIO EN LA BASE DE DATOS, PROCEDEMOS A LOGUEAR";
            if (password_verify($password, $datosUsuario->getPassword())) {
                //EL PASSWORD ES CORRECTO

                $datosLogin['username'] = $datosUsuario->getNombre_usuario();
                $datosLogin['nombre_completo'] = $datosUsuario->getNombre_completo();
                $datosLogin['id'] = $datosUsuario->getId();
                $datosLogin['rol'] = $datosUsuario->getRol();

                $_SESSION['loggedIn'] = $datosLogin;

                return $datosLogin["rol"];
            } 
            else {
                //EL PASSWORD NO ES CORRECTO
                return FALSE;
            }
        } 
        else {
            //NO SE ENCONTRÓ EL USUARIO EN LA BASE DE DATOS
            return NULL;
        }
    }


    /*LOG OUT */
    public static function log_out()
    {

        if (isset($_SESSION['loggedIn'])) {
            unset($_SESSION['loggedIn']);
        };
    }


        /* VERIFICAR CREDENCIALES*/
    public static function verify($nivel = 0)
    {

        if (!$nivel) { //RESTRICCION NIVEL 0 - ACCESO PÚBLICO
            return TRUE; //SIGA PARA ADELANTE!
        }

        if (isset($_SESSION['loggedIn'])) {  //RESTRICCION NIVEL 1 o + - ACCESO RESTRINGIDO

            if ($nivel > 1) { //RESTRICCION NIVEL 2 - ACCESO ÚNICAMENTE ADMINISTRADORES

                if ($_SESSION['loggedIn']['rol'] == "admin" || $_SESSION['loggedIn']['rol'] == "superadmin") {
                    return TRUE; //SIGA PARA ADELANTE!
                } 
                else {                    
                    header('location: ../admin/index.php?sec=login');
                    return FALSE;
                }
            } 
            else { //RESTRICCION NIVEL 1 - ACCESO PARA TODOS LOS USUARIOS
                return TRUE; //SIGA PARA ADELANTE!
            }
        } 
        else {
            header("location: index.php?sec=login");
            return FALSE;
        }
    }
}
