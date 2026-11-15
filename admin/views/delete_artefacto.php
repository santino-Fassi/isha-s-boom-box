<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$artefacto = Artefacto::get_x_id($id);
?>

<section class="row my-5 g-3">
    <h2 class="h1 text-center mb-5 fw-bold">¿Está seguro que desea eliminar este artefacto?</h2>

    <?php if ($artefacto) { ?>
        <div class="col-12 col-md-6">
            <img src="../img/artefactos/<?= $artefacto->getImagen() ?>"
                alt="Imagen ilustrativa de <?= $artefacto->getNombre() ?>"
                class="img-fluid rounded shadow-sm d-block mx-auto mb-3">
        </div>

        <div class="col-12 col-md-6">
            <h3 class="fs-6">Nombre</h3>
            <p><?= $artefacto->getNombre() ?> (<?= $artefacto->getAlias() ?>)</p>

            <h3 class="fs-6">Categoría</h3>
            <p><?= $artefacto->getCategoria()->getNombre() ?></p>

            <h3 class="fs-6">Descripción</h3>
            <p><?= $artefacto->getDescripcion() ?></p>

            <a href="actions/delete_artefacto_acc.php?id=<?= $artefacto->getId() ?>" role="button"
                class="d-block btn btn-sm btn-hextech btn-eliminar mt-4">Eliminar</a>
        </div>
    <?php } else { ?>
        <div class="col-12 text-center">
            <p>El artefacto solicitado no existe.</p>
        </div>
    <?php } ?>
</section>
