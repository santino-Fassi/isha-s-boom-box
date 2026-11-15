<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$personaje = Personaje::get_x_id($id);
?>

<section class="row my-5 g-3">
    <h2 class="h1 text-center mb-5 fw-bold">¿Está seguro que desea eliminar este personaje?</h2>

    <?php if ($personaje) { ?>
        <div class="col-12 col-md-6">
            <img src="../img/personajes/<?= $personaje->getImagen() ?>"
                alt="Ilustración de <?= $personaje->getNombre() ?>"
                class="img-fluid rounded shadow-sm d-block mx-auto mb-3">
        </div>

        <div class="col-12 col-md-6">
            <h3 class="fs-6">Nombre</h3>
            <p><?= $personaje->getNombre() ?></p>

            <h3 class="fs-6">Alias</h3>
            <p><?= $personaje->getAlias() ?></p>

            <h3 class="fs-6">Facción</h3>
            <p><?= $personaje->getFaccion() ?></p>

            <h3 class="fs-6">Biografía</h3>
            <p><?= $personaje->getBiografia() ?></p>

            <a href="actions/delete_personaje_acc.php?id=<?= $personaje->getId() ?>" role="button"
                class="d-block btn btn-sm btn-danger mt-4">Eliminar</a>
        </div>
    <?php } else { ?>
        <div class="col-12 text-center">
            <p>El personaje solicitado no existe.</p>
        </div>
    <?php } ?>
</section>