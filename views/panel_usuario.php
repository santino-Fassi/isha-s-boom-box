
<?PHP

$userData = $_SESSION['loggedIn'] ?? [];

$idUsuario = $userData['id'] ?? '---';
$nombreCompleto = $userData['nombre_completo'] ?? 'No disponible';
$nombreUsuario = $userData['username'] ?? 'No disponible';
$email = $userData['email'] ?? 'No disponible';
$rol = $userData['rol'] ?? 'No disponible';

// Función para escapar los datos
$escapar = function ($dato) {
    return htmlspecialchars((string) $dato, ENT_QUOTES, 'UTF-8');
};

?>

<section class="panel-usuario-jinx py-5">

    <div class="container">

        <!-- ENCABEZADO -->
        <header class="perfil-encabezado text-center mb-5">

            <span class="perfil-subtitulo">
                ZAUN // BASE DE DATOS CLANDESTINA
            </span>

            <h1>
                REGISTRO DE <span>IDENTIDAD</span>
            </h1>

            <p>
                Parece que tenemos un nuevo socio en el negocio.
                Acá está todo lo que sabemos de vos... por ahora.
            </p>

        </header>


        <!-- EXPEDIENTE -->
        <?PHP if ($userData): ?>

            <article class="expediente-jinx">

                <!-- BARRA SUPERIOR -->
                <div class="expediente-barra">

                    <div class="expediente-luces">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <p>BLACK MARKET // USER DATABASE</p>

                    <span class="expediente-version">V. 02.06</span>

                </div>


                <!-- CONTENIDO -->
                <div class="expediente-contenido">

                    <div class="expediente-cabecera">

                        <div>
                            <span class="expediente-etiqueta">
                                ARCHIVO PERSONAL
                            </span>

                            <h2>IDENTIDAD DEL CLIENTE</h2>
                        </div>

                        <div class="expediente-estado">
                            <span class="estado-punto"></span>
                            SESIÓN ACTIVA
                        </div>

                    </div>


                    <!-- IDENTIFICACIÓN -->
                    <div class="identidad-usuario">

                        <div class="usuario-icono">
                            <span>
                                <i class="bi bi-person-fill"></i>
                            </span>
                        </div>

                        <div class="usuario-presentacion">

                            <span class="dato-etiqueta">
                                NOMBRE DE USUARIO
                            </span>

                            <h3>
                                <?= $escapar($nombreUsuario); ?>
                            </h3>

                            <span class="usuario-verificado">
                                <i class="bi bi-patch-check-fill"></i>
                                IDENTIDAD REGISTRADA
                            </span>

                        </div>

                        <div class="sello-usuario">
                            <span>ACCESO</span>
                            <strong>AUTORIZADO</strong>
                        </div>

                    </div>


                    <!-- DATOS PERSONALES -->
                    <div class="datos-usuario">

                        <div class="dato-usuario">
                            <span class="dato-etiqueta">
                                01 // NOMBRE COMPLETO
                            </span>

                            <p>
                                <?= $escapar($nombreCompleto); ?>
                            </p>
                        </div>

                        <div class="dato-usuario">
                            <span class="dato-etiqueta">
                                02 // ROL ASIGNADO
                            </span>

                            <p class="dato-rol">
                                <?= $escapar($rol); ?>
                            </p>
                        </div>

                        <div class="dato-usuario dato-email">
                            <span class="dato-etiqueta">
                                03 // CORREO ELECTRÓNICO
                            </span>

                            <p><?= $escapar($email); ?></p>
                        </div>

                    </div>


                    <!-- PIE DEL EXPEDIENTE -->
                    <div class="expediente-pie">

                        <div class="expediente-mensaje">
                            <span class="dato-etiqueta">
                                ESTADO DEL EXPEDIENTE
                            </span>

                            <p>
                                <i class="bi bi-shield-check"></i>
                                REGISTRO ENCONTRADO. TODO EN ORDEN.
                            </p>
                        </div>

                        <div class="codigo-barras">
                            <span>ZAUN // EXPEDIENTE N.º <?= $escapar($idUsuario); ?></span>
                            <div></div>
                            <small>BLACK MARKET DATABASE</small>
                        </div>

                    </div>

                </div>

                <!-- DECORACIÓN -->
                <div class="expediente-esquina"></div>

            </article>

        <?PHP else: ?>

            <div class="alert alert-dark text-center">
                No se encontró una sesión activa.
            </div>

        <?PHP endif; ?>

    </div>

</section>
