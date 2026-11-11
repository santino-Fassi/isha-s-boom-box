
<?PHP
$catalogo = Comic::catalogo_completo();
?>

<section class="catalogo-jinx py-5">
    <div class="container">

        <div class="catalogo-encabezado-fila">

            <header class="encabezado-catalogo text-center">
                <span class="subtitulo-catalogo">
                    ZAUN // INVENTARIO CLANDESTINO
                </span>

                <h1>EL <span>INVENTARIO</span></h1>

                <p>Artefactos, inventos y otras pequeñas maravillas.</p>
            </header>

            <div class="bomba-catalogo-zona">

                <button
                    class="bomba-interactiva bomba-catalogo"
                    id="bombaCatalogo"
                    type="button"
                    aria-label="Hacer explotar la bombita de Jinx"
                >
                    <img src="img/bombas/bomba.png" alt="Bombita del mono de Jinx">
                </button>

                <div
                    class="mensaje-jinx-catalogo"
                    id="mensajeJinxCatalogo"
                    role="status"
                    aria-live="polite"
                >
                    <span class="mensaje-jinx-etiqueta">
                        JINX // MENSAJE DEL DÍA
                    </span>

                    <p id="textoJinxCatalogo"></p>

                    <span class="mensaje-jinx-firma">
                        — LA GENIA DE ZAUN 💣
                    </span>
                </div>

            </div>

        </div>

        <!-- PRODUCTOS DEL CATALOGO -->
        <div class="row g-4">
            <?PHP foreach ($catalogo as $comic) { ?>
                <div class="col-12 col-md-6 col-lg-4 d-flex">
                    <article class="card artefacto-card h-100 w-100">

                        <!-- IMAGEN -->
                        <div class="artefacto-imagen">

                            <span class="etiqueta-artefacto">
                                PIEZA DEL INVENTARIO
                            </span>

                            <img src="img/covers/<?= $comic->getPortada() ?>" class="card-img-top" alt="Portada de <?= $comic->get_nombre_completo() ?>" >

                        </div>

                        <!-- INFORMACION -->
                        <div class="card-body artefacto-body">

                            <p class="artefacto-creador">
                                <?= $comic->get_nombre_completo() ?>
                            </p>

                            <h2 class="card-title">
                                <?= $comic->getTitulo() ?>
                            </h2>

                            <p class="card-text artefacto-descripcion">
                                <?= $comic->get_bajada_reducida() ?>
                            </p>

                        </div>

                        <!-- DATOS TECNICOS -->
                        <ul class="list-group list-group-flush artefacto-datos">

                            <li class="list-group-item">
                                <span>GUION</span>
                                <?= $comic->getGuion() ?>
                            </li>

                            <li class="list-group-item">
                                <span>ARTE</span>
                                <?= $comic->getArte() ?>
                            </li>

                            <li class="list-group-item">
                                <span>REGISTRO</span>
                                <?= $comic->getPublicacion() ?>
                            </li>
                        </ul>

                        <!-- PRECIO Y BOTON -->
                        <div class="artefacto-footer">
                            <div class="artefacto-precio">
                                <span>PRECIO DEL ARTEFACTO</span>
                                <p><?= $comic->get_precio_formateado() ?></p>
                            </div>

                            <a href="index.php?sec=producto&id=<?= $comic->getId() ?>" class="btn btn-artefacto">
                                EXAMINAR ARTEFACTO
                                <span>↗</span>
                            </a>
                        </div>
                    </article>
                </div>
            <?PHP } ?>
        </div>
    </div>
</section>
