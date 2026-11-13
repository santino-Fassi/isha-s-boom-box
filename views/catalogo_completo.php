<?PHP
$termino = $_GET['termino'] ?? '';
$origenFiltro = $_GET['origen'] ?? '';
$peligroMin = isset($_GET['peligro_min']) && $_GET['peligro_min'] !== '' ? (int) $_GET['peligro_min'] : 0;


$catalogo = Artefacto::catalogo_filtrado($termino, $origenFiltro, $peligroMin);

?>

<section class="catalogo-jinx py-5">
    <div class="container">

        <div class="catalogo-encabezado-fila">

            <img src="img/grafitis/pow.webp" alt="" class="grafiti-pow">

            <header class="encabezado-catalogo text-center mb-5">
                <span class="subtitulo-catalogo">ZAUN // INVENTARIO CLANDESTINO</span>
                <h2 class="h1">EL <span>ARSENAL</span></h2>
                <p><strong>Artefactos, inventos y otras pequeñas maravillas</strong> listas para hacer ruido.</p>
            </header>

            <div class="bomba-catalogo-zona">

                <button class="bomba-interactiva bomba-catalogo" id="bombaCatalogo" type="button"
                    aria-label="Hacer explotar la bombita de Jinx">
                    <img src="img/bombas/bomba.webp" alt="Bombita del mono de Jinx">
                </button>

                <div class="mensaje-jinx-catalogo" id="mensajeJinxCatalogo" role="status" aria-live="polite">
                    <span class="mensaje-jinx-etiqueta">JINX</span>
                    <p id="textoJinxCatalogo"></p>
                    <span class="mensaje-jinx-firma">— LA GENIA DE ZAUN 💣</span>
                </div>
            </div>
        </div>


        <!-- PANEL DE BUSQUEDA Y FILTROS -->
        <section class="panel-inventario">

            <div class="panel-inventario-encabezado">
                <div>
                    <span class="panel-etiqueta">ZAUN // SISTEMA DE BÚSQUEDA</span>
                    <h2>LOCALIZÁ TU <span>ARTEFACTO</span></h2>
                    <p>Encontrá tu próximo juguete. Si explota, no es mi culpa.</p>
                </div>

                <span class="panel-codigo">SYS. 09 // JX</span>
            </div>

            <form action="index.php" method="GET" class="formulario-inventario">

                <input type="hidden" name="sec" value="catalogo_completo">

                <!-- BUSCADOR -->
                <div class="campo-inventario campo-busqueda">
                    <label for="termino">BUSCAR EN EL INVENTARIO</label>

                    <div class="busqueda-input-contenedor">
                        <span class="icono-busqueda">⌕</span>

                        <input type="text" id="termino" name="termino" placeholder="Nombre, alias o modelo..."
                            value="<?= htmlspecialchars($termino) ?>">
                    </div>
                </div>

                <!-- FILTRO DE ORIGEN -->
                <div class="campo-inventario">
                    <label for="origen">ORIGEN</label>

                    <select name="origen" id="origen">
                        <option value="">Todos los orígenes</option>
                        <option value="Zaun" <?= $origenFiltro === 'Zaun' ? 'selected' : '' ?>>ZAUN</option>
                        <option value="Piltover" <?= $origenFiltro === 'Piltover' ? 'selected' : '' ?>>PILTOVER</option>
                        <option value="Noxus" <?= $origenFiltro === 'Noxus' ? 'selected' : '' ?>>NOXUS</option>
                    </select>
                </div>

                <!-- FILTRO DE PELIGRO -->
                <div class="campo-inventario">
                    <label for="peligro_min">NIVEL DE PELIGRO</label>

                    <select name="peligro_min" id="peligro_min">
                        <option value="">Todos los niveles</option>
                        <option value="8" <?= $peligroMin == 8 ? 'selected' : '' ?>>PELIGRO 8+ // ALTO</option>
                        <option value="10" <?= $peligroMin == 10 ? 'selected' : '' ?>>PELIGRO 10 // LETAL</option>
                    </select>
                </div>

                <!-- BOTONES -->
                <div class="acciones-inventario">

                    <button type="submit" class="btn-buscar-jinx">
                        <span>⌕</span> EJECUTAR BÚSQUEDA
                    </button>

                    <?PHP if ($termino !== '' || $origenFiltro !== '' || $peligroMin > 0) { ?>
                        <a href="index.php?sec=catalogo_completo" class="btn-limpiar-jinx" title="Limpiar filtros">
                            ✕
                        </a>
                    <?PHP } ?>

                </div>

            </form>

        </section>

        <div class="row g-4">
            <?PHP if (!empty($catalogo)) { ?>
                <?PHP foreach ($catalogo as $artefacto) { ?>
                    <div class="col-12 col-md-6 col-lg-4 d-flex">
                        <article
                            class="card artefacto-card h-100 w-100 <?= $artefacto->getRobado() ? 'artefacto-robado border-danger' : '' ?>">

                            <!-- IMAGEN -->
                            <div class="artefacto-imagen">
                                <span class="etiqueta-artefacto <?= $artefacto->getRobado() ? 'bg-danger text-light' : '' ?>">
                                    <?= $artefacto->getRobado() ? '¡EXPROPIADO POR JINX!' : 'FABRICACIÓN ZAUNITA' ?>
                                </span>
                                <img src="img/artefactos/<?= $artefacto->getImagen() ?>" class="card-img-top"
                                    alt="Imagen ilustrativa de <?= $artefacto->getNombre() ?> (<?= $artefacto->getAlias() ?>)">
                            </div>

                            <!-- INFORMACION -->
                            <div class="card-body artefacto-body">
                                <p class="artefacto-creador">
                                    <strong><?= strtoupper($artefacto->getCategoria()->getNombre()) ?></strong> //
                                    <em><?= $artefacto->getAlias() ?></em>
                                </p>

                                <h3 class="card-title">
                                    <?= $artefacto->getNombre() ?>
                                </h3>

                                <p class="card-text artefacto-descripcion">
                                    <strong>Nota de Jinx:</strong> <em><?= $artefacto->get_descripcion_reducida(14) ?></em>
                                </p>
                            </div>

                            <!-- DATOS TECNICOS -->
                            <ul class="list-group list-group-flush artefacto-datos">
                                <li class="list-group-item">
                                    <span>CREADOR</span>
                                    <?= $artefacto->getCreador()->getNombreCompleto() ?>
                                </li>
                                <li class="list-group-item">
                                    <span>ORIGEN</span>
                                    <?= $artefacto->getOrigen() ?>
                                </li>
                                <li class="list-group-item">
                                    <span>PELIGRO</span>
                                    <?= $artefacto->getNivel_peligro() ?> / 10
                                </li>
                            </ul>

                            <!-- PRECIO Y BOTON -->
                            <div class="artefacto-footer">
                                <div class="artefacto-precio">
                                    <span>PRECIO DEL ARTEFACTO</span>
                                    <p><strong><?= $artefacto->get_precio_formateado() ?></strong></p>
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
                        <p>No encontramos ningún artefacto con esos parámetros en el escondite de <strong>Jinx</strong>.</p>
                    </div>
                </div>
            <?PHP } ?>
        </div>
    </div>
</section>