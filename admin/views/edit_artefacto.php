<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$artefacto = Artefacto::get_x_id($id);

$categorias = Categoria::listado_completo();
$personajes = Personaje::listado_completo();
$componentes = Componente::listado_completo();

$componentesSeleccionados = $artefacto ? $artefacto->get_componentes_ids() : [];
?>

<section class="row my-5">
    <div class="col">

        <?php if ($artefacto) { ?>
            <h2 class="h1 text-center mb-5 fw-bold">
                Edición de datos de: <span class="text-danger"><?= $artefacto->getNombre() ?></span>
            </h2>

            <form class="row g-3" action="actions/edit_artefacto_acc.php?id=<?= $artefacto->getId() ?>" method="POST"
                enctype="multipart/form-data">

                <div class="col-12 col-md-4 mb-3">
                    <span class="form-label d-block">Imagen Actual</span>
                    <img src="../img/artefactos/<?= $artefacto->getImagen() ?>"
                        alt="Imagen ilustrativa de <?= $artefacto->getNombre() ?>"
                        class="img-fluid rounded shadow-sm d-block">
                    <input type="hidden" id="imagen_og" name="imagen_og" value="<?= $artefacto->getImagen() ?>">
                </div>

                <div class="col-12 col-md-6 row">

                    <div class="col-12 col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required
                            value="<?= htmlspecialchars($artefacto->getNombre()) ?>">
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label for="alias" class="form-label">Alias / Modelo</label>
                        <input type="text" class="form-control" id="alias" name="alias" required
                            value="<?= htmlspecialchars($artefacto->getAlias()) ?>">
                    </div>

                    <div class="col-12 col-md-4 mb-3">
                        <label for="categoria_id" class="form-label">Categoría</label>
                        <select class="form-select" name="categoria_id" id="categoria_id" required>
                            <?php foreach ($categorias as $C) { ?>
                                <option value="<?= $C->getId() ?>" <?= $C->getId() === $artefacto->getCategoria()->getId() ? 'selected' : '' ?>>
                                    <?= $C->getNombre() ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-4 mb-3">
                        <label for="personaje_creador_id" class="form-label">Personaje Creador</label>
                        <select class="form-select" name="personaje_creador_id" id="personaje_creador_id" required>
                            <?php foreach ($personajes as $P) { ?>
                                <option value="<?= $P->getId() ?>" <?= $P->getId() === $artefacto->getCreador()->getId() ? 'selected' : '' ?>>
                                    <?= $P->getNombreCompleto() ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-4 mb-3">
                        <label for="personaje_usuario_id" class="form-label">Personaje Portador</label>
                        <select class="form-select" name="personaje_usuario_id" id="personaje_usuario_id" required>
                            <?php foreach ($personajes as $P) { ?>
                                <option value="<?= $P->getId() ?>" <?= $P->getId() === $artefacto->getUsuario()->getId() ? 'selected' : '' ?>>
                                    <?= $P->getNombreCompleto() ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-4 mb-3">
                        <label for="origen" class="form-label">Origen</label>
                        <select class="form-select" name="origen" id="origen" required>
                            <option value="Zaun" <?= $artefacto->getOrigen() === 'Zaun' ? 'selected' : '' ?>>Zaun</option>
                            <option value="Piltover" <?= $artefacto->getOrigen() === 'Piltover' ? 'selected' : '' ?>>Piltover
                            </option>
                            <option value="Noxus" <?= $artefacto->getOrigen() === 'Noxus' ? 'selected' : '' ?>>Noxus</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-4 mb-3">
                        <label for="nivel_peligro" class="form-label">Nivel de Peligro (1 a 10)</label>
                        <input type="number" class="form-control" id="nivel_peligro" name="nivel_peligro" min="1" max="10"
                            required value="<?= $artefacto->getNivel_peligro() ?>">
                    </div>

                    <div class="col-12 col-md-4 mb-3">
                        <label for="fecha_fabricacion" class="form-label">Fecha de Fabricación</label>
                        <input type="date" class="form-control" id="fecha_fabricacion" name="fecha_fabricacion" required
                            value="<?= $artefacto->getFecha_fabricacion() ?>">
                    </div>

                </div>


                <div class="col-12 col-md-4 mb-3">
                    <label for="imagen" class="form-label">Reemplazar Imagen</label>
                    <input class="form-control" type="file" id="imagen" name="imagen">
                </div>

                <div class="col-12 col-md-2 mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" required
                        value="<?= $artefacto->getPrecio() ?>">
                </div>

                <div class="col-12 col-md-2 mb-3">
                    <label for="robado" class="form-label">Procedencia</label>
                    <select class="form-select" name="robado" id="robado" required>
                        <option value="0" <?= !$artefacto->getRobado() ? 'selected' : '' ?>>Diseño Original</option>
                        <option value="1" <?= $artefacto->getRobado() ? 'selected' : '' ?>>Botín Robado</option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <span class="form-label d-block">Componentes de Fabricación</span>
                    <?php foreach ($componentes as $comp) { ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="componentes[]" id="comp_<?= $comp->getId() ?>"
                                value="<?= $comp->getId() ?>" <?= in_array($comp->getId(), $componentesSeleccionados) ? 'checked' : '' ?>>
                            <label class="form-check-label mb-2" for="comp_<?= $comp->getId() ?>">
                                <?= $comp->getNombre() ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-12 mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="5"
                        required><?= htmlspecialchars($artefacto->getDescripcion()) ?></textarea>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-hextech btn-editar w-100">Editar</button>
                </div>
            </form>
        <?php } else { ?>
            <p class="text-center">No se encontró el artefacto solicitado.</p>
        <?php } ?>

    </div>
</section>