<?php
$userData = $_SESSION['loggedIn'] ?? [];

$idUsuario = htmlspecialchars((string) ($userData['id'] ?? '---'), ENT_QUOTES, 'UTF-8');
$nombreCompleto = htmlspecialchars((string) ($userData['nombre_completo'] ?? 'No disponible'), ENT_QUOTES, 'UTF-8');
$nombreUsuario = htmlspecialchars((string) ($userData['username'] ?? 'No disponible'), ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars((string) ($userData['email'] ?? 'No disponible'), ENT_QUOTES, 'UTF-8');
$rol = htmlspecialchars((string) ($userData['rol'] ?? 'No disponible'), ENT_QUOTES, 'UTF-8');
?>

<section class="perfil-hextech py-5">
    <div class="container">

        <header class="perfil-hextech-encabezado text-center mb-5">
            <span>PILTOVER // HEXTECH SECURITY SYSTEM</span>
            <h2 class="h1">CREDENCIAL DE <span>ACCESO</span></h2>
            <p>Registro de personal autorizado dentro del sistema de administración.</p>
        </header>

        <?php if (!empty($userData)) { ?>

            <article class="credencial-hextech">

                <div class="credencial-hextech-barra">

                    <div class="hextech-indicadores">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <p>HEXTECH // PERSONNEL DATABASE</p>

                    <span>V. 01.08</span>

                </div>

                <div class="credencial-hextech-contenido">

                    <div class="credencial-hextech-cabecera">

                        <div>
                            <span class="hextech-etiqueta">
                                REGISTRO INSTITUCIONAL
                            </span>
                            <h3>IDENTIFICACIÓN DEL PERSONAL</h3>
                        </div>

                        <div class="hextech-estado">
                            <span></span>
                            ACCESO ACTIVO
                        </div>

                    </div>

                    <div class="identidad-hextech">

                        <div class="hextech-icono">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>

                        <div class="hextech-presentacion">

                            <span class="hextech-etiqueta">
                                IDENTIFICADOR DEL USUARIO
                            </span>

                            <h4><?= $nombreUsuario ?></h4>

                            <span class="hextech-verificado">
                                <i class="bi bi-patch-check-fill"></i>
                                CREDENCIAL VERIFICADA
                            </span>

                        </div>

                        <div class="hextech-sello">
                            <i class="bi bi-gem"></i>
                            <span>HEXTECH</span>
                            <span class="fw-bold">VALIDADO</span>
                        </div>

                    </div>

                    <div class="datos-hextech">

                        <div class="dato-hextech">
                            <span>01 // NOMBRE COMPLETO</span>
                            <p><?= $nombreCompleto ?></p>
                        </div>

                        <div class="dato-hextech">
                            <span>02 // NIVEL DE AUTORIZACIÓN</span>
                            <p class="hextech-rol"><?= strtoupper($rol) ?></p>
                        </div>

                        <div class="dato-hextech dato-hextech-email">
                            <span>03 // CORREO INSTITUCIONAL</span>
                            <p><?= $email ?></p>
                        </div>

                    </div>

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
                            <span>PILTOVER // ID N.º <?= $idUsuario ?></span>
                            <div></div>
                            <small>HEXTECH SECURITY DIVISION</small>
                        </div>
                    </div>
                </div>
                <div class="credencial-hextech-decoracion"></div>
            </article>

        <?php } else { ?>
            <div class="alert alert-dark text-center">
                No se encontró una sesión activa.
            </div>
        <?php } ?>
    </div>
</section>
