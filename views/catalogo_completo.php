<?PHP
$termino = $_GET['termino'] ?? '';
$origenFiltro = $_GET['origen'] ?? '';
$peligroMin = isset($_GET['peligro_min']) && $_GET['peligro_min'] !== '' ? $_GET['peligro_min'] : 0;


//TODO: Pasar los filtros a una unica funcion en Artefacto para no hacer 3 queries.
$catalogo = Artefacto::catalogo_completo();

$comparar = fn($a, $b) => $a->getId() <=> $b->getId();

if ($termino !== '') {
    $catalogo = Artefacto::buscador($termino);
}

if ($origenFiltro !== '') {
    $catalogo = array_uintersect(
        $catalogo,
        Artefacto::catalogo_x_origen($origenFiltro),
        $comparar
    );
}

if ($peligroMin > 0) {
    $catalogo = array_uintersect(
        $catalogo,
        Artefacto::catalogo_x_rango_peligro($peligroMin, 10),
        $comparar
    );
}

?>

<section class="catalogo-jinx py-5">
    <div class="container">

        <header class="encabezado-catalogo text-center mb-5">
            <span class="subtitulo-catalogo">ZAUN // INVENTARIO CLANDESTINO</span>
            <h2 class="h1">EL <span>ARSENAL</span></h2>
            <p><strong>Artefactos, inventos y otras pequeñas maravillas</strong> listas para hacer ruido.</p>
        </header>

        <!-- BARRA DE BUSQUEDA Y FILTROS RAPIDOS -->
        <div class="row mb-5 justify-content-center">
            <div class="col-12 col-lg-10">
                <form action="index.php" method="GET" class="row g-2 align-items-center bg-dark p-3 rounded border border-secondary">
                    <input type="hidden" name="sec" value="catalogo_completo">
                    <div class="col-12 col-md-5">
                        <label for="termino" class="d-none">Buscar por nombre o alias</label>
                        <input type="text" class="form-control bg-black text-light border-secondary" id="termino" name="termino"
                            placeholder="Buscar juguete o modelo (ej: Fishbones)..."
                            value="<?= htmlspecialchars($termino) ?>">
                    </div>

                    <div class="col-6 col-md-3">
                        <label for="origen" class="d-none">Filtrar por origen</label>
                        <select name="origen" id="origen" class="form-select bg-black text-light border-secondary">
                            <option value="">Todos los orígenes</option>
                            <option value="Zaun" <?= $origenFiltro === 'Zaun' ? 'selected' : '' ?>>Origen: Zaun</option>
                            <option value="Piltover" <?= $origenFiltro === 'Piltover' ? 'selected' : '' ?>>Origen: Piltover
                            </option>
                            <option value="Noxus" <?= $origenFiltro === 'Noxus' ? 'selected' : '' ?>>Origen: Noxus</option>
                        </select>
                    </div>

                    <div class="col-6 col-md-2">
                        <label for="peligro_min" class="d-none">Peligro mínimo</label>
                        <select name="peligro_min" id="peligro_min"
                            class="form-select bg-black text-light border-secondary">
                            <option value="">Peligro (Todos)</option>
                            <option value="8" <?= $peligroMin === 8 ? 'selected' : '' ?>>Peligro 8+ (Alto)</option>
                            <option value="10" <?= $peligroMin === 10 ? 'selected' : '' ?>>Peligro 10 (Letal)</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-danger w-100 fw-bold">FILTRAR</button>
                        <?PHP if ($termino !== '' || $origenFiltro !== '' || $peligroMin > 0) { ?>
                            <a href="index.php?sec=catalogo_completo" class="btn btn-outline-light">X</a>
                        <?PHP } ?>
                    </div>
                </form>
            </div>
        </div>

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
                                    <strong><?= strtoupper($artefacto->getCategoria()) ?></strong> //
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
                                    <?= $artefacto->getCreador() ?>
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
            <?PHP } 
            else { ?>
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