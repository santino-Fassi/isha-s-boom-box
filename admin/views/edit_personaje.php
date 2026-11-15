<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$personaje = Personaje::get_x_id($id);
?>

<section class="row my-5">
    <div class="col">
        <h2 class="h1 text-center mb-5 fw-bold">Editar los datos de un personaje</h2>

        <?php if ($personaje) { ?>
            <form class="row g-3" action="actions/edit_personaje_acc.php?id=<?= $personaje->getId() ?>" method="POST"
                enctype="multipart/form-data">

                <div class="col-12 col-md-6 mb-3">
                    <span class="form-label d-block">Imagen actual</span>
                    <img src="../img/personajes/<?= $personaje->getImagen() ?>"
                        alt="Ilustración de <?= $personaje->getNombre() ?>" class="img-fluid rounded shadow-sm d-block">
                    <input type="hidden" id="imagen_og" name="imagen_og" value="<?= $personaje->getImagen() ?>">
                </div>

                <div class="col-12 col-md-6">

                    <div class="col-12 mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="<?= htmlspecialchars($personaje->getNombre()) ?>" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="alias" class="form-label">Alias</label>
                        <input type="text" class="form-control" id="alias" name="alias"
                            value="<?= htmlspecialchars($personaje->getAlias()) ?>" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="faccion" class="form-label">Facción</label>
                        <select class="form-select" id="faccion" name="faccion" required>
                            <option value="Zaun" <?= $personaje->getFaccion() === 'Zaun' ? 'selected' : '' ?>>Zaun</option>
                            <option value="Piltover" <?= $personaje->getFaccion() === 'Piltover' ? 'selected' : '' ?>>Piltover</option>
                            <option value="Noxus" <?= $personaje->getFaccion() === 'Noxus' ? 'selected' : '' ?>>Noxus</option>
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="biografia" class="form-label">Biografía</label>
                        <textarea class="form-control" id="biografia" name="biografia" rows="5"
                            required><?= htmlspecialchars($personaje->getBiografia()) ?></textarea>
                    </div>

                </div>

                <div class="col-12 col-md-4 mb-3">
                    <label for="imagen" class="form-label">Reemplazar Imagen</label>
                    <input class="form-control" type="file" id="imagen" name="imagen">
                </div>



                <div class="col-12">
                    <button type="submit" class="btn btn-hextech btn-editar w-100">Editar</button>
                </div>

            </form>
        <?php } else { ?>
            <p class="text-center">No se encontró el personaje solicitado.</p>
        <?php } ?>
    </div>
</section>