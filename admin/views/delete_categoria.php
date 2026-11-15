<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$categoria = Categoria::get_x_id($id);
?>

<section class="row my-5 g-3">
    <h2 class="h1 text-center mb-5 fw-bold">¿Está seguro que desea eliminar la categoría?</h2>

    <?php if ($categoria) { ?>

        <div class="col-12">
            <h3 class="fs-6">Nombre</h3>
            <p><?= $categoria->getNombre() ?></p>

            <h3 class="fs-6">Descripción</h3>
            <p><?= $categoria->getDescripcion() ?></p>

            <a href="actions/delete_categoria_acc.php?id=<?= $categoria->getId() ?>" role="button"
                class="d-block btn btn-sm btn-hextech btn-eliminar mt-4">Eliminar</a>
        </div>
    <?php } else { ?>
        <div class="col-12 text-center">
            <p>La categoría solicitada no existe.</p>
        </div>
    <?php } ?>
</section>