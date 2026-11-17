
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

<section class="perfil-hextech py-5">
    <div class="container">

        <!-- ENCABEZADO -->
        <header class="perfil-hextech-encabezado text-center mb-5">
            <span> PILTOVER // HEXTECH SECURITY SYSTEM </span>
            <h1>CREDENCIAL DE <strong>ACCESO</strong></h1>
            <p>Registro de personal autorizado dentro del sistema de administración.</p>
        </header>

        <?PHP if ($userData): ?>

            <!-- CREDENCIAL -->
            <article class="credencial-hextech">

                <!-- BARRA SUPERIOR -->
                <div class="credencial-hextech-barra">

                    <div class="hextech-indicadores">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <p>HEXTECH // PERSONNEL DATABASE</p>

                    <span>V. 01.08</span>

                </div>

                <!-- CONTENIDO -->
                <div class="credencial-hextech-contenido">

                    <div class="credencial-hextech-cabecera">

                        <div>
                            <span class="hextech-etiqueta">
                                REGISTRO INSTITUCIONAL
                            </span>
                            <h2>IDENTIFICACIÓN DEL PERSONAL</h2>
                        </div>

                        <div class="hextech-estado">
                            <span></span>
                            ACCESO ACTIVO
                        </div>

                    </div>

                    <!-- IDENTIDAD -->
                    <div class="identidad-hextech">

                        <div class="hextech-icono">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>

                        <div class="hextech-presentacion">

                            <span class="hextech-etiqueta">
                                IDENTIFICADOR DEL USUARIO
                            </span>

                            <h3><?= $escapar($nombreUsuario); ?></h3>

                            <span class="hextech-verificado">
                                <i class="bi bi-patch-check-fill"></i>
                                CREDENCIAL VERIFICADA
                            </span>

                        </div>

                        <div class="hextech-sello">
                            <i class="bi bi-gem"></i>
                            <span>HEXTECH</span>
                            <strong>VALIDADO</strong>
                        </div>

                    </div>

                    <!-- DATOS -->
                    <div class="datos-hextech">

                        <div class="dato-hextech">
                            <span>01 // NOMBRE COMPLETO</span>
                            <p><?= $escapar($nombreCompleto); ?></p>
                        </div>

                        <div class="dato-hextech">
                            <span>02 // NIVEL DE AUTORIZACIÓN</span>
                            <p class="hextech-rol">
                                <?= strtoupper($escapar($rol)); ?>
                            </p>
                        </div>

                        <div class="dato-hextech dato-hextech-email">
                            <span>03 // CORREO INSTITUCIONAL</span>
                            <p><?= $escapar($email); ?></p>
                        </div>

                    </div>

                    <!-- PIE -->
                    <div class="credencial-hextech-pie">

                        <div>
                            <span class="hextech-etiqueta">
                                ESTADO DE SEGURIDAD
                            </span>

                            <p>
                                <i class="bi bi-shield-check"></i>
                                IDENTIDAD CONFIRMADA. SISTEMA OPERATIVO.
                            </p>
                        </div>

                        <div class="hextech-codigo">
                            <span>PILTOVER // ID N.º <?= $escapar($idUsuario); ?></span>
                            <div></div>
                            <small>HEXTECH SECURITY DIVISION</small>
                        </div>
                    </div>
                </div>
                <div class="credencial-hextech-decoracion"></div>
            </article>

        <?PHP else: ?>
            <div class="alert alert-dark text-center">
                No se encontró una sesión activa.
            </div>
        <?PHP endif; ?>
    </div>
</section>
