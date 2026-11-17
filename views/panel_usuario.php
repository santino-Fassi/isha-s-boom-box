<?php
$userData = $_SESSION['loggedIn'] ?? [];

$idUsuario = ($userData['id'] ?? '---');
$nombreCompleto = ($userData['nombre_completo'] ?? 'No disponible');
$nombreUsuario = ($userData['username'] ?? 'No disponible');
$email = ($userData['email'] ?? 'No disponible');
$rol = ($userData['rol'] ?? 'No disponible');
?>

<section class="panel-usuario-jinx py-5">

    <div class="container">

        <header class="perfil-encabezado text-center mb-5">

            <span class="perfil-subtitulo">
                ZAUN // BASE DE DATOS CLANDESTINA
            </span>

            <h2 class="h1">
                REGISTRO DE <span>IDENTIDAD</span>
            </h2>

            <p>
                Parece que tenemos un nuevo socio en el negocio.
                Acá está todo lo que sabemos de vos... por ahora.
            </p>

        </header>

        <?php if (!empty($userData)) { ?>

            <article class="expediente-jinx">

                <div class="expediente-barra">

                    <div class="expediente-luces">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <p>BLACK MARKET // USER DATABASE</p>

                    <span class="expediente-version">V. 02.06</span>

                </div>

                <div class="expediente-contenido">

                    <div class="expediente-cabecera">

                        <div>
                            <span class="expediente-etiqueta">
                                ARCHIVO PERSONAL
                            </span>

                            <h3>IDENTIDAD DEL CLIENTE</h3>
                        </div>

                        <div class="expediente-estado">
                            <span class="estado-punto"></span>
                            SESIÓN ACTIVA
                        </div>

                    </div>

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

                            <h4><?= $nombreUsuario ?></h4>

                            <span class="usuario-verificado">
                                <i class="bi bi-patch-check-fill"></i>
                                IDENTIDAD REGISTRADA
                            </span>

                        </div>

                        <div class="sello-usuario">
                            <span>ACCESO</span>
                            <span class="fw-bold">AUTORIZADO</span>
                        </div>

                    </div>

                    <div class="datos-usuario">

                        <div class="dato-usuario">
                            <span class="dato-etiqueta">
                                01 // NOMBRE COMPLETO
                            </span>

                            <p><?= $nombreCompleto ?></p>
                        </div>

                        <div class="dato-usuario">
                            <span class="dato-etiqueta">
                                02 // ROL ASIGNADO
                            </span>

                            <p class="dato-rol"><?= $rol ?></p>
                        </div>

                        <div class="dato-usuario dato-email">
                            <span class="dato-etiqueta">
                                03 // CORREO ELECTRÓNICO
                            </span>

                            <p><?= $email ?></p>
                        </div>

                    </div>

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
                            <span>ZAUN // EXPEDIENTE N.º <?= $idUsuario ?></span>
                            <div></div>
                            <small>BLACK MARKET DATABASE</small>
                        </div>

                    </div>

                </div>

                <div class="expediente-esquina"></div>

            </article>

        <?php } else { ?>

            <div class="alert alert-dark text-center">
                No se encontró una sesión activa.
            </div>

        <?php } ?>

    </div>

</section>
