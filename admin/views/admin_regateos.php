<?php
$regateos = Regateo::listado_completo();
?>
<section class="row my-5">
    <div class="col">
        <h2 class="h1 text-center mb-5 fw-bold">Administración de Regateos</h2>

        <div class="table-responsive mb-4">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col" class="col-imagen-admin">Personaje</th>
                        <th scope="col">Personalidad</th>
                        <th scope="col">Estrategias</th>
                        <th scope="col">Mensajes (3 Instancias)</th>
                        <th scope="col">Respuestas Finales</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($regateos as $R) {
                        $vendedor = $R->getVendedor();
                        $instancias = $R->getInstancias();
                        ?>
                        <tr>
                            <td>
                                <img src="../img/personajes/<?= $vendedor->getImagen() ?>"
                                    alt="Ilustración de <?= $vendedor->getNombre() ?>"
                                    class="img-fluid rounded shadow-sm mb-2">
                                <span class="d-block fw-bold"><?= $vendedor->getNombreCompleto() ?></span>
                            </td>
                            <td><?= $R->getPersonalidad() ?></td>
                            <td>
                                <span class="badge bg-success d-block mb-1">Correcta:
                                    <?= strtoupper($R->getEstrategia_correcta()) ?></span>
                                <span class="badge bg-info text-dark d-block">Intermedia:
                                    <?= strtoupper($R->getEstrategia_intermedia()) ?></span>
                            </td>
                            <td class="small">
                                <?php foreach ($instancias as $num => $instancia) { ?>
                                    <p class="mb-1"><span class="fw-bold text-info">Instancia <?= $num ?>:</span>
                                        <?= $instancia['mensaje'] ?></p>
                                <?php } ?>
                            </td>
                            <td class="small">
                                <p class="mb-1"><span class="fw-bold text-success">Éxito:</span>
                                    <?= $R->getRespuesta_exito() ?></p>
                                <p class="mb-1"><span class="fw-bold text-info">Neutral:</span>
                                    <?= $R->getRespuesta_neutral() ?></p>
                                <p class="mb-0"><span class="fw-bold text-danger">Fallo:</span>
                                    <?= $R->getRespuesta_fallo() ?></p>
                            </td>
                            <td>
                                <a href="index.php?sec=edit_regateo&id=<?= $R->getId() ?>" role="button"
                                    class="btn btn-hextech btn-editar w-100">Editar</a>
                                <a href="index.php?sec=delete_regateo&id=<?= $R->getId() ?>" role="button"
                                    class="d-block btn btn-sm btn-hextech btn-eliminar mt-4">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <a href="index.php?sec=add_regateo" class="btn btn-hextech btn-agregar w-100 mt-3">Cargar nuevo Regateo</a>
    </div>
</section>