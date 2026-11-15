<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$artefacto = Artefacto::get_x_id($id);

if ($artefacto && isset($_GET['reiniciar'])) {
    unset($_SESSION['regateos'][$artefacto->getId()]);
}

if ($artefacto) {
    $regateo = Regateo::crearRegateo($artefacto);
    $vendedor = $regateo->getVendedor();
}
?>

<section class="catalogo-jinx py-3">
    <div class="container">
        <?php if ($artefacto) { ?>

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <a href="index.php?sec=artefacto&id=<?= $artefacto->getId() ?>" class="btn btn-sm btn-outline-info fw-bold">
                    ← Volver al artefacto
                </a>
                <span class="subtitulo-catalogo m-0">ZAUN // MESA DE INSPECCIÓN</span>
            </div>

            <header class="encabezado-catalogo text-center pb-3 mb-3">
                <h2 class="h1 titulo-inspeccion mb-1">NEGOCIAR <span>ARTEFACTO</span></h2>
                <p class="small mb-0">
                    Analizá a <span class="fw-bold"><?= $vendedor->getNombreCompleto() ?></span>: la opción correcta te da
                    un <span class="fw-bold">10% de descuento</span> y la incorrecta un <span class="fst-italic">5% de
                        recargo</span>.
                </p>
            </header>


            <div class="row g-3 align-items-stretch">


                <div class="col-12 col-lg-5 d-flex">
                    <article
                        class="card artefacto-card card-vendedor-giro w-100 p-3 border-info d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <img src="img/personajes/<?= $vendedor->getImagen() ?>"
                                    alt="Retrato de <?= $vendedor->getNombreCompleto() ?>"
                                    class="rounded border border-info shadow retrato-vendedor">
                                <div>
                                    <span class="badge bg-info text-dark fw-bold mb-1">
                                        FACCIÓN: <?= strtoupper($vendedor->getFaccion()) ?>
                                    </span>
                                    <h3 class="fs-3 mb-0"><?= $vendedor->getNombre() ?> (<?= $vendedor->getAlias() ?>)</h3>
                                    <p class="artefacto-creador small mb-0">
                                        <span class="fw-bold">PERSONALIDAD:</span> <span
                                            class="fst-italic"><?= $regateo->getPersonalidad() ?></span>
                                    </p>
                                </div>
                            </div>

                            <div class="p-2 px-3 bg-dark rounded border border-secondary mb-3">
                                <h4 class="h6 text-info text-uppercase fw-bold mb-1 small">Expediente Psicológico (Pista):
                                </h4>
                                <p class="small mb-0">
                                    <span class="fw-bold">Historial:</span> <span
                                        class="fst-italic"><?= $vendedor->getBiografia() ?></span>
                                </p>
                            </div>
                        </div>

                        <blockquote class="blockquote p-2 px-3 mb-0 rounded cita-vendedor">
                            <p class="small mb-0 text-light">
                                <span class="fw-bold"><?= $vendedor->getAlias() ?> te mira fijo:</span> <span
                                    class="fst-italic"><?= $regateo->getSaludo() ?></span>
                            </p>
                        </blockquote>
                    </article>
                </div>


                <div class="col-12 col-lg-7 d-flex">
                    <article
                        class="card artefacto-card w-100 p-3 d-flex flex-column justify-content-between card-foco-zaun">

                        <div class="d-flex align-items-center gap-3 p-2 bg-dark rounded border border-secondary mb-3">
                            <img src="img/artefactos/<?= $artefacto->getImagen() ?>"
                                alt="Miniatura de <?= $artefacto->getNombre() ?>" class="rounded miniatura-inspeccion">
                            <div class="flex-grow-1">
                                <p class="artefacto-creador small mb-0">
                                    <span class="fw-bold"><?= strtoupper($artefacto->getCategoria()->getNombre()) ?></span>
                                    // <span class="fst-italic"><?= $artefacto->getAlias() ?></span>
                                </p>
                                <h3 class="fs-4 mb-0 text-light"><?= $artefacto->getNombre() ?></h3>
                                <p class="small mb-0">
                                    <span class="fw-bold">Peligro:</span> <?= $artefacto->getNivel_peligro() ?>/10 — <span
                                        class="fst-italic">Origen: <?= $artefacto->getOrigen() ?></span>
                                </p>
                            </div>
                            <div class="text-end pe-2">
                                <span class="d-block small text-secondary fw-bold">PRECIO LISTA</span>
                                <p class="fs-4 mb-0 text-info">
                                    <span class="fw-bold"><?= $artefacto->get_precio_formateado() ?></span>
                                </p>
                            </div>
                        </div>


                        <form action="index.php?sec=resultado_inspeccion&id=<?= $artefacto->getId() ?>" method="POST"
                            class="d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <h4 class="h5 text-uppercase mb-2">Elegí tu estrategia de negociación:</h4>
                                <div class="d-flex flex-column gap-2">
                                    <?php foreach ($regateo->getOpciones() as $clave => $textoOpcion) { ?>
                                        <label
                                            class="d-flex align-items-center gap-3 p-2 px-3 rounded bg-dark border border-secondary opcion-regateo">
                                            <input class="form-check-input m-0 fs-5 flex-shrink-0" type="radio"
                                                name="estrategia" value="<?= $clave ?>" required>
                                            <span class="text-light small">
                                                <span class="fw-bold">Argumento:</span> <span
                                                    class="fst-italic">«<?= $textoOpcion ?>»</span>
                                            </span>
                                        </label>
                                    <?php } ?>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-artefacto w-100 mt-3 py-2">
                                REGATEAR PRECIO CON <?= strtoupper($vendedor->getAlias()) ?> <span>→</span>
                            </button>
                        </form>

                    </article>
                </div>
            </div>

        <?php } else { ?>
            <div class="catalogo-vacio text-center my-4">
                <h2 class="h1">ARTEFACTO NO ENCONTRADO</h2>
                <p>El juguete que intentás inspeccionar <span class="fw-bold">no existe en el inventario de Zaun</span>.</p>
                <a href="index.php?sec=catalogo_completo" class="btn btn-artefacto mt-3">VOLVER AL ARSENAL</a>
            </div>
        <?php } ?>
    </div>
</section>