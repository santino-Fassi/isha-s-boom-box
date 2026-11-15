<?php
$personajes = Personaje::listado_completo();
?>

<section class="row my-5">
    <div class="col">

        <h2 class="h1 text-center mb-5 fw-bold">Administración de Personajes</h2>

        <div class="table-responsive mb-4">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col" class="col-imagen-admin">Imagen</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Alias</th>
                        <th scope="col">Facción</th>
                        <th scope="col" class="col-biografia-admin">Biografía</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($personajes as $P) { ?>
                        <tr>
                            <td>
                                <img src="../img/personajes/<?= $P->getImagen() ?>"
                                    alt="Ilustración de <?= $P->getNombre() ?>"
                                    class="img-fluid rounded shadow-sm">
                            </td>
                            <td><?= $P->getNombre() ?></td>
                            <td><?= $P->getAlias() ?></td>
                            <td><?= $P->getFaccion() ?></td>
                            <td><?= $P->getBiografia() ?></td>
                            <td>
                                <a href="index.php?sec=edit_personaje&id=<?= $P->getId() ?>" role="button"
                                    class="btn btn-hextech btn-editar w-100">Editar</a>
                                <a href="index.php?sec=delete_personaje&id=<?= $P->getId() ?>" role="button"
                                    class="d-block btn btn-sm btn-hextech btn-eliminar mt-4">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <a href="index.php?sec=add_personaje" class="btn btn-hextech btn-agregar w-100 mt-3">Cargar nuevo personaje</a>

    </div>
</section>