<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$componente = Componente::get_x_id($id);
?>

<section class="row my-5 g-3">
    <h2 class="h1 text-center mb-5 fw-bold">¿Está seguro que desea eliminar el componente?</h2>

    <?php if ($componente) { ?>

        <div class="col-12">
            <h3 class="fs-6">Nombre</h3>
            <p><?= $componente->getNombre() ?></p>

            <h3 class="fs-6">Descripción</h3>
            <p><?= $componente->getDescripcion() ?></p>

            <a href="actions/delete_componente_acc.php?id=<?= $componente->getId() ?>" role="button"
                class="d-block btn btn-sm btn-danger mt-4">Eliminar</a>
        </div>
    <?php } else { ?>
        <div class="col-12 text-center">
            <p>El componente solicitado no existe.</p>
        </div>
    <?php } ?>
</section>