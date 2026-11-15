<?php
$categorias = Categoria::listado_completo();
$personajes = Personaje::listado_completo();
$componentes = Componente::listado_completo();
?>

<section class="row my-5">
    <div class="col">

        <h2 class="h1 text-center mb-5 fw-bold">Crear un Artefacto</h2>

        <form class="row g-3" action="actions/add_artefacto_acc.php" method="POST" enctype="multipart/form-data">

            <div class="col-12 col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="alias" class="form-label">Alias / Modelo</label>
                <input type="text" class="form-control" id="alias" name="alias" required>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label for="categoria_id" class="form-label">Categoría</label>
                <select class="form-select" name="categoria_id" id="categoria_id" required>
                    <option value="" selected disabled>Elija una opción</option>
                    <?php foreach ($categorias as $C) { ?>
                        <option value="<?= $C->getId() ?>"><?= $C->getNombre() ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label for="personaje_creador_id" class="form-label">Personaje Creador</label>
                <select class="form-select" name="personaje_creador_id" id="personaje_creador_id" required>
                    <option value="" selected disabled>Elija una opción</option>
                    <?php foreach ($personajes as $P) { ?>
                        <option value="<?= $P->getId() ?>"><?= $P->getNombreCompleto() ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label for="personaje_usuario_id" class="form-label">Personaje Portador</label>
                <select class="form-select" name="personaje_usuario_id" id="personaje_usuario_id" required>
                    <option value="" selected disabled>Elija una opción</option>
                    <?php foreach ($personajes as $P) { ?>
                        <option value="<?= $P->getId() ?>"><?= $P->getNombreCompleto() ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label for="origen" class="form-label">Origen</label>
                <select class="form-select" name="origen" id="origen" required>
                    <option value="" selected disabled>Elija una opción</option>
                    <option value="Zaun">Zaun</option>
                    <option value="Piltover">Piltover</option>
                    <option value="Noxus">Noxus</option>
                </select>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label for="nivel_peligro" class="form-label">Nivel de Peligro (1 a 10)</label>
                <input type="number" class="form-control" id="nivel_peligro" name="nivel_peligro" min="1" max="10" required>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label for="fecha_fabricacion" class="form-label">Fecha de Fabricación</label>
                <input type="date" class="form-control" id="fecha_fabricacion" name="fecha_fabricacion" required>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input class="form-control" type="file" id="imagen" name="imagen" required>
            </div>

            <div class="col-12 col-md-3 mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
            </div>

            <div class="col-12 col-md-3 mb-3">
                <label for="robado" class="form-label">Procedencia</label>
                <select class="form-select" name="robado" id="robado" required>
                    <option value="0">Diseño Original</option>
                    <option value="1">Botín Robado</option>
                </select>
            </div>

            <div class="col-12 mb-3">
                <span class="form-label d-block">Componentes de Fabricación</span>
                <?php foreach ($componentes as $comp) { ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="componentes[]"
                            id="comp_<?= $comp->getId() ?>" value="<?= $comp->getId() ?>">
                        <label class="form-check-label mb-2" for="comp_<?= $comp->getId() ?>">
                            <?= $comp->getNombre() ?>
                        </label>
                    </div>
                <?php } ?>
            </div>

            <div class="col-12 mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required></textarea>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Cargar</button>
            </div>

        </form>

    </div>
</section>
