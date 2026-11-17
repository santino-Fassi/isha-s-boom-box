<?php
require_once '../functions/autoload.php';

$vista = Vista::validar_vista($_GET['sec'] ?? 'dashboard');
Autenticacion::verify($vista->getRestringida());

$userData = $_SESSION['loggedIn'] ?? false;

$seccionActual = $vista->getNombre();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Admin de Isha's Boom Box :: <?= $vista->getTitulo() ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&family=Rajdhani:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="css/styles.css" rel="stylesheet">
</head>

<body class="modo-admin">

    <header>
        <h1 class="p-3 text-light d-none">Panel de Administración - Isha's Boom Box</h1>
        <nav class="navbar navbar-expand-lg navbar-dark navbar-hextech">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php?sec=dashboard">Panel de Administración</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Alternar navegación">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto align-items-center">

                        <?php if ($userData) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $seccionActual === 'admin_categorias' ? 'active' : '' ?>"
                                    href="index.php?sec=admin_categorias">Administrar Categorías</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= $seccionActual === 'admin_personajes' ? 'active' : '' ?>"
                                    href="index.php?sec=admin_personajes">Administrar Personajes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= $seccionActual === 'admin_componentes' ? 'active' : '' ?>"
                                    href="index.php?sec=admin_componentes">Administrar Componentes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= $seccionActual === 'admin_artefactos' ? 'active' : '' ?>"
                                    href="index.php?sec=admin_artefactos">Administrar Artefactos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= $seccionActual === 'admin_regateos' ? 'active' : '' ?>"
                                    href="index.php?sec=admin_regateos">Administrar Regateos</a>
                            </li>
                            <li class="nav-item">
                                <a href="index.php?sec=panel_usuario" class="usuario-hextech">
                                    <span class="usuario-hextech-icono">
                                        <i class="bi bi-shield-lock-fill"></i>
                                    </span>

                                    <div class="usuario-hextech-info">
                                        <small>PERSONAL AUTORIZADO</small>
                                        <span class="fw-bold">
                                            <?= htmlspecialchars($userData['nombre_completo'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                    </div>
                                    <i class="bi bi-chevron-right usuario-hextech-flecha"></i>
                                </a>
                            </li>
                        <?php } ?>

                        <li class="nav-item <?= $userData ? 'd-none' : '' ?>">
                            <a class="nav-link fw-bold" href="index.php?sec=login">Login</a>
                        </li>

                        <li class="nav-item <?= $userData ? '' : 'd-none' ?>">
                            <a class="nav-link fw-bold" href="actions/auth_logout.php">Logout</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="../index.php?sec=home">Ir al Front</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container">
        <?php
        require_once "views/{$vista->getNombre()}.php";
        ?>
    </main>

    <footer class="footer-hextech text-center">
        <p>Santino David Fassi y Camila Denis Gastager</p>
        <p>HEXTECH CONTROL SYSTEM</p>
        <small>Authorized personnel only · Piltover technology</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>