<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$estrategiasRecibidas = $_POST['estrategia'] ?? [];
$artefacto = Artefacto::get_x_id($id);

$resultado = null;
$regateo = $artefacto ? Regateo::crear_regateo_x_artefacto($artefacto) : null;

if ($artefacto && $regateo) {
    $vendedor = $regateo->getVendedor();

    if (!empty($estrategiasRecibidas)) {
        $regateo->registrarEleccion($estrategiasRecibidas);
    }

    $resultado = $regateo->evaluarResultadoFinal();
}
?>

<section class="catalogo-jinx py-3">
    <div class="container">
        <?php if ($artefacto && $resultado) { ?>
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <a href="index.php?sec=artefacto&id=<?= $artefacto->getId() ?>" class="btn btn-sm btn-outline-info fw-bold">
                    ← Volver a la ficha del artefacto
                </a>
                <span class="subtitulo-catalogo m-0">ZAUN // RESULTADO DE LA NEGOCIACIÓN</span>
            </div>

            <article class="card artefacto-card p-3 p-md-4 text-center border-<?= $resultado['badge_color'] ?>">
                <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                    <img src="img/personajes/<?= $vendedor->getImagen() ?>"
                        alt="Retrato de <?= $vendedor->getNombreCompleto() ?>"
                        class="rounded-circle border border-<?= $resultado['badge_color'] ?> miniatura-inspeccion">
                    <div class="text-start">
                        <span class="subtitulo-catalogo d-block mb-0">RESPUESTA DE
                            <?= strtoupper($vendedor->getAlias()) ?></span>
                        <h2 class="h2 text-<?= $resultado['badge_color'] ?> mb-0"><?= $resultado['titulo'] ?></h2>
                    </div>
                </div>

                <?php if (!empty($resultado['historial'])) { ?>
                    <div class="d-flex flex-column align-items-center my-2">
                        <div class="d-flex justify-content-center align-items-center gap-3 mb-2">
                            <?php foreach ($resultado['historial'] as $indice => $item) { ?>
                                <span class="circulo-instancia circulo-resultado <?= $item['clase'] ?>"
                                    title="Instancia <?= $indice + 1 ?>: <?= $item['etiqueta'] ?>">
                                    <?= $item['icono'] ?>
                                </span>
                            <?php } ?>
                        </div>
                        <p class="small mb-0">
                            <span class="fw-bold">Balance de tus 3 instancias:</span>
                            <?= $resultado['correctas'] ?> acierto(s) 🎉 ·
                            <?= $resultado['neutras'] ?> neutro(s) 😐 ·
                            <?= $resultado['erradas'] ?> error(es) 💣
                        </p>
                    </div>
                <?php } ?>

                <blockquote
                    class="blockquote my-3 p-3 bg-dark rounded border border-<?= $resultado['badge_color'] ?> mx-auto bloque-respuesta">
                    <p class="fs-5 mb-0 text-light">
                        <span class="fw-bold">Veredicto:</span> <span
                            class="fst-italic"><?= $resultado['respuesta'] ?></span>
                    </p>
                </blockquote>

                <div class="row justify-content-center my-3 g-3">
                    <div class="col-12 col-sm-5 col-md-4">
                        <div class="p-2 px-3 bg-dark rounded border border-secondary">
                            <span class="d-block small text-secondary fw-bold">PRECIO DE LISTA</span>
                            <p class="fs-5 mb-0 text-decoration-line-through">
                                <span class="fw-bold"><?= $artefacto->get_precio_formateado() ?></span>
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-5 col-md-4">
                        <div class="p-2 px-3 bg-dark rounded border border-<?= $resultado['badge_color'] ?>">
                            <span class="d-block small text-<?= $resultado['badge_color'] ?> fw-bold">PRECIO FINAL
                                ACORDADO</span>
                            <p class="fs-3 mb-0 text-<?= $resultado['badge_color'] ?>">
                                <span class="fw-bold"><?= $resultado['precio_final_formateado'] ?></span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-3 mt-2">
                    <a href="#" class="btn btn-artefacto btn-encargar-regateo">
                        ENCARGAR POR <?= $resultado['precio_final_formateado'] ?> <span>→</span>
                    </a>
                    <a href="index.php?sec=inspeccion&id=<?= $artefacto->getId() ?>&reiniciar=1"
                        class="btn btn-outline-light d-flex align-items-center px-4">
                        Intentar de nuevo
                    </a>
                </div>
            </article>

            <div class="zona-bombas-resultado estado-<?= $resultado['estado'] ?>" data-estado="<?= $resultado['estado'] ?>">
                <button class="bomba-interactiva bomba-resultado" type="button" aria-label="Bomba izquierda de resultado">
                    <img src="img/bombas/bomba.webp" alt="Bombita del mono de Jinx">
                </button>

                <button class="bomba-interactiva bomba-resultado" type="button" aria-label="Bomba derecha de resultado">
                    <img src="img/bombas/bomba.webp" alt="Bombita del mono de Jinx">
                </button>
            </div>

        <?php } else { ?>
            <div class="catalogo-vacio text-center my-4">
                <h2 class="h1">SIN NEGOCIACIÓN ACTIVA</h2>
                <p>Todavía no completaste las 3 instancias de oferta para <span class="fw-bold">este artefacto</span>.</p>
                <a href="index.php?sec=inspeccion&id=<?= $id ?>" class="btn btn-artefacto mt-3">IR A LA MESA DE
                    INSPECCIÓN</a>
            </div>
        <?php } ?>
    </div>
</section>