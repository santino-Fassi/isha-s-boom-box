<?PHP
$idCategoria = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$catalogo = Artefacto::catalogo_x_categoria($idCategoria);
$datosCategoria = Categoria::get_x_id($idCategoria);
?>

<section class="catalogo-jinx py-5">
    <div class="container">

        <?PHP if ($datosCategoria) { ?>
            <header class="encabezado-catalogo text-center mb-5">
                <span class="subtitulo-catalogo">
                    ZAUN // COLECCIÓN CLASIFICADA
                </span>
                <h2 class="h1">
                    SECCIÓN:
                    <span><?= strtoupper($datosCategoria->getNombre()) ?></span>
                </h2>
                <p><span class="fst-italic"><?= $datosCategoria->getDescripcion() ?></span></p>
            </header>

            <div class="row g-4">
                <?PHP if (!empty($catalogo)) { ?>
                    <?PHP foreach ($catalogo as $artefacto) { ?>
                        <div class="col-12 col-md-6 col-lg-4 d-flex">
                            <article
                                class="card artefacto-card h-100 w-100 <?= $artefacto->getRobado() ? 'artefacto-robado border-danger' : '' ?>">

                                <div class="artefacto-imagen">
                                    <span class="etiqueta-artefacto <?= $artefacto->getRobado() ? 'bg-danger text-light' : '' ?>">
                                        <?= $artefacto->getRobado() ? '¡EXPROPIADO POR JINX!' : 'FABRICACIÓN ZAUNITA' ?>
                                    </span>
                                    <img src="img/artefactos/<?= $artefacto->getImagen() ?>" class="card-img-top"
                                        alt="Imagen ilustrativa de <?= $artefacto->getNombre() ?>">
                                </div>

                                <div class="card-body artefacto-body">
                                    <p class="artefacto-creador">
                                        <span class="fw-bold">MODELO:</span> <span class="fst-italic"><?= $artefacto->getAlias() ?></span>
                                    </p>

                                    <h3 class="card-title">
                                        <?= $artefacto->getNombre() ?>
                                    </h3>

                                    <p class="card-text artefacto-descripcion">
                                        <span class="fw-bold">Nota de Jinx:</span> <span class="fst-italic"><?= $artefacto->get_descripcion_reducida(14) ?></span>
                                    </p>
                                </div>

                                <ul class="list-group list-group-flush artefacto-datos">
                                    <li class="list-group-item">
                                        <span>CREADOR</span>
                                        <?= $artefacto->getCreador()->getNombreCompleto() ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span>PORTADOR</span>
                                        <?= $artefacto->getUsuario()->getNombreCompleto() ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span>PELIGRO</span>
                                        <?= $artefacto->getNivel_peligro() ?> / 10 (<?= $artefacto->getOrigen() ?>)
                                    </li>
                                </ul>

                                <div class="artefacto-footer">
                                    <div class="artefacto-precio">
                                        <span>PRECIO DEL ARTEFACTO</span>
                                        <p class="h1"><?= $artefacto->get_precio_formateado() ?></p>
                                    </div>

                                    <a href="index.php?sec=artefacto&id=<?= $artefacto->getId() ?>" class="btn btn-artefacto">
                                        EXAMINAR ARTEFACTO
                                        <span>→</span>
                                    </a>
                                </div>

                            </article>
                        </div>
                    <?PHP } ?>
                <?PHP } else { ?>
                    <div class="col-12">
                        <div class="catalogo-vacio text-center">
                            <h2>¡VAYA, QUÉ DESASTRE!</h2>
                            <p><span class="fw-bold">Jinx</span> todavía no tiene artefactos cargados en esta categoría.</p>
                        </div>
                    </div>
                <?PHP } ?>
            </div>
        <?PHP } else { ?>
            <div class="catalogo-vacio text-center my-5">
                <h2 class="h1">CATEGORÍA DESCONOCIDA</h2>
                <p>La sección que intentás buscar <span class="fw-bold">no existe en el inventario de Zaun</span>.</p>
                <a href="index.php?sec=catalogo_completo" class="btn btn-artefacto mt-3">VOLVER AL ARSENAL COMPLETO</a>
            </div>
        <?PHP } ?>

    </div>
</section>