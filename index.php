<?PHP
require_once 'functions/autoload.php';

$vista = Vista::validar_vista($_GET['sec'] ?? 'home');
$seccionActual = $vista->getNombre();
$categoriaActual = $_GET['id'] ?? '';

$userData = $_SESSION['loggedIn'] ?? FALSE;

$categoriasDisponibles = Categoria::listado_menu();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isha's Boom Box :: <?= $vista->getTitulo() ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&family=Rajdhani:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">



    <link href="css/styles.css?v=8" rel="stylesheet">

</head>

<body class="mercado-jinx">

    <header>
        <h1 class="p-3 text-light d-none">Isha's Boom Box</h1>
        <nav class="navbar navbar-expand-lg navbar-dark navbar-jinx">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Isha's Boom Box</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto text-center align-items-center">
                        <li class="nav-item">
                            <a class="nav-link <?= $seccionActual === 'home' ? 'active' : '' ?>"
                                href="index.php?sec=home" <?= $seccionActual === 'home' ? 'aria-current="page"' : '' ?>>
                                ¡BOOM! ¿Te asusté?
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= $seccionActual === 'quienes_somos' ? 'active' : '' ?>"
                                href="index.php?sec=quienes_somos" <?= $seccionActual === 'quienes_somos' ? 'aria-current="page"' : '' ?>>
                                Los sospechosos habituales
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= $seccionActual === 'catalogo_completo' ? 'active' : '' ?>"
                                href="index.php?sec=catalogo_completo" <?= $seccionActual === 'catalogo_completo' ? 'aria-current="page"' : '' ?>>
                                Arsenal
                            </a>
                        </li>


                        <?PHP foreach ($categoriasDisponibles as $c) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?= ($seccionActual === 'catalogo' && (string) $categoriaActual === (string) $c['id']) ? 'active' : '' ?>"
                                    href="index.php?sec=catalogo&id=<?= $c['id'] ?>" <?= ($seccionActual === 'catalogo' && (string) $categoriaActual === (string) $c['id']) ? 'aria-current="page"' : '' ?>>
                                    <?= $c['nombre'] ?>
                                </a>
                            </li>
                        <?PHP } ?>

                        <li class="nav-item">
                            <a class="nav-link <?= $seccionActual === 'contacto' ? 'active' : '' ?>"
                                href="index.php?sec=contacto" <?= $seccionActual === 'contacto' ? 'aria-current="page"' : '' ?>>
                                ¿Problemas? ¡Me encantan!
                            </a>
                        </li>

                        <?PHP if ($userData) { ?>
                            <li class="nav-item">
                                <a class="nav-link bg-danger text-light rounded me-2"
                                    href="index.php?sec=panel_usuario">🙍‍♂️​
                                    <?= $userData['nombre_completo'] ?? "" ?> </a>
                            </li>
                        <?PHP } ?>

                        <li class="nav-item <?= $userData ? "d-none" : "" ?>">
                            <a class="nav-link fw-bold active" href="index.php?sec=login">Login</a>
                        </li>

                        <li class="nav-item <?= $userData ? "" : "d-none" ?>">
                            <a class="nav-link fw-bold" href="admin/actions/auth_logout.php">Logout <span
                                    class="fw-light"></span></a>
                        </li>

                        <?php if ($userData) { ?>
                            <li class="nav-item">
                                <a class="nav-link active" href="admin/index.php">Ir al ABM</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <main>
        <?PHP
        require_once "views/{$vista->getNombre()}.php";
        ?>
    </main>

    <footer class="footer-jinx text-center">
        <p>Santino David Fassi y Camila Denis Gastager</p>
        <p>Isha's Boom Box</p>
        <small>Made in Zaun. No refunds. No regrets.</small>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="js/bomba.js?v=4" defer></script>
</body>

</html>