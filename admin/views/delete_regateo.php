<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$regateo = Regateo::get_x_id($id);
?>
<section class="row my-5 g-3">
    <h2 class="h1 text-center mb-5 fw-bold">¿Está seguro que desea eliminar este regateo?</h2>
    <?php if ($regateo) {
        $vendedor = $regateo->getVendedor();
        $instancias = $regateo->getInstancias();
        ?>
        <div class="col-12 col-md-6">
            <img src="../img/personajes/<?= $vendedor->getImagen() ?>" alt="Ilustración de <?= $vendedor->getNombre() ?>"
                class="img-fluid rounded shadow-sm d-block mx-auto mb-3">
        </div>
        <div class="col-12 col-md-6">
            <h3 class="fs-6">Personaje</h3>
            <p><?= $vendedor->getNombreCompleto() ?></p>

            <h3 class="fs-6">Personalidad</h3>
            <p><?= $regateo->getPersonalidad() ?></p>

            <h3 class="fs-6">Estrategias</h3>
            <p>Correcta: <?= strtoupper($regateo->getEstrategia_correcta()) ?> — Intermedia:
                <?= strtoupper($regateo->getEstrategia_intermedia()) ?></p>

            <h3 class="fs-6">Mensajes de las 3 Instancias</h3>
            <?php foreach ($instancias as $num => $instancia) { ?>
                <p class="mb-1"><?= $num ?>. <?= $instancia['mensaje'] ?></p>
            <?php } ?>

            <a href="actions/delete_regateo_acc.php?id=<?= $regateo->getId() ?>" role="button"
                class="d-block btn btn-sm btn-hextech btn-eliminar mt-4">Eliminar</a>
        </div>
    <?php } else { ?>
        <div class="col-12 text-center">
            <p>El regateo solicitado no existe.</p>
        </div>
    <?php } ?>
</section>