<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$artefacto = Artefacto::get_x_id($id);
?>

<section class="catalogo-jinx py-5">
    <div class="container">
        <?php if (!empty($artefacto)) {
            $componentes = $artefacto->get_componentes();
            ?>
            <header class="encabezado-catalogo text-center mb-5">
                <span class="subtitulo-catalogo">
                    <?= strtoupper($artefacto->getCategoria()->getNombre()) ?>
                </span>
                <h2 class="h1">
                    <?= strtoupper($artefacto->getNombre()) ?>
                    <span>(<?= $artefacto->getAlias() ?>)</span>
                </h2>
                <p>Especificaciones completas del artefacto registradas en el <span class="fw-bold">archivo clandestino de
                        Zaun</span>.</p>
            </header>

            <article class="card artefacto-card mb-5 p-3 p-md-4 <?= $artefacto->getRobado() ? 'border-danger' : '' ?>">
                <div class="row g-4 align-items-center">

                    <div class="col-12 col-md-6">
                        <div class="artefacto-imagen position-relative">
                            <span class="etiqueta-artefacto <?= $artefacto->getRobado() ? 'bg-danger text-light' : '' ?>">
                                <?= $artefacto->getRobado() ? '¡BOTÍN ROBADO!' : 'DISEÑO ORIGINAL DEL SUBMUNDO' ?>
                            </span>
                            <img src="img/artefactos/<?= $artefacto->getImagen() ?>" class="img-fluid rounded w-100"
                                alt="Detalle de <?= $artefacto->getNombre() ?>">
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="card-body artefacto-body">
                            <p class="artefacto-creador">
                                <span class="fw-bold">CÓDIGO DE MODELO:</span>
                                <span class="fst-italic"><?= $artefacto->getAlias() ?></span>
                            </p>

                            <h3 class="card-title fs-2 mb-3">
                                <?= $artefacto->getNombre() ?>
                            </h3>

                            <p class="card-text artefacto-descripcion fs-5">
                                <span class="fw-bold">Descripción de Jinx:</span>
                                <span class="fst-italic"><?= $artefacto->getDescripcion() ?></span>
                            </p>
                        </div>
                    </div>

                    <div class="col-12 d-flex flex-column">

                        <ul class="list-group list-group-flush artefacto-datos mb-4">
                            <li class="list-group-item">
                                <span>CATEGORÍA</span>
                                <?= $artefacto->getCategoria()->getNombre() ?>
                            </li>
                            <li class="list-group-item">
                                <span>INVENTOR / CREADOR</span>
                                <?= $artefacto->getCreador()->getNombreCompleto() ?>
                            </li>
                            <li class="list-group-item">
                                <span>PORTADOR HABITUAL</span>
                                <?= $artefacto->getUsuario()->getNombreCompleto() ?>
                            </li>
                            <li class="list-group-item">
                                <span>ORIGEN DE FABRICACIÓN</span>
                                <?= $artefacto->getOrigen() ?>
                            </li>
                            <li class="list-group-item">
                                <span>NIVEL DE PELIGRO</span>
                                <?= $artefacto->getNivel_peligro() ?> / 10
                            </li>
                            <li class="list-group-item">
                                <span>FECHA DE REGISTRO</span>
                                <?= $artefacto->getFecha_fabricacion() ?>
                            </li>
                        </ul>

                        <div class="px-3 mb-4">
                            <h4 class="h5 text-uppercase fw-bold mb-3">Componentes de Fabricación:</h4>
                            <?php if (!empty($componentes)) { ?>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach ($componentes as $comp) { ?>
                                        <span class="badge bg-dark border border-info text-info p-2"
                                            title="<?= $comp->getDescripcion() ?>">
                                            ⚙️ <?= $comp->getNombre() ?>
                                        </span>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
                                <p><span class="fst-italic">Este artefacto no registra componentes específicos en el
                                        archivo.</span></p>
                            <?php } ?>
                        </div>

                        <div class="artefacto-footer mt-auto">
                            <div class="artefacto-precio">
                                <span>VALOR EN EL MERCADO NEGRO</span>
                                <p class="h1"><?= $artefacto->get_precio_formateado() ?></p>
                            </div>

                            <a href="#" class="btn btn-artefacto mb-3">ENCARGAR ESTE ARTEFACTO<span>→</span></a>
                            <?php if (Regateo::personaje_tiene_regateo($artefacto->getUsuario()->getId())) { ?>
                                <a href="index.php?sec=inspeccion&id=<?= $artefacto->getId() ?>"
                                    class="btn btn-outline-secondary d-flex align-items-center justify-content-between flex-fill text-decoration-none px-3">
                                    NEGOCIAR<span>→</span>
                                </a>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </article>
        <?php } else { ?>
            <div class="catalogo-vacio text-center my-5">
                <h2 class="h1">ARTEFACTO NO ENCONTRADO</h2>
                <p>El juguete que buscás <span class="fw-bold">ya fue vendido o explotó en mil pedazos</span>.</p>
                <a href="index.php?sec=catalogo_completo" class="btn btn-artefacto mt-3">VOLVER AL ARSENAL</a>
            </div>
        <?php } ?>
    </div>
</section>