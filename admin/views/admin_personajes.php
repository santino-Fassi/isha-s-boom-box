<?PHP
$personajes = Personaje::listado_completo();
?>


<div class=" d-flex justify-content-center p-5">
    <div>
        <div class="row my-5">
            <div class="col">

                <h1 class="text-center mb-5 fw-bold">Administración de Personajes</h1>
                <div class="row mb-5 d-flex align-items-center">

                    <table class="table">

                        <thead>
                            <tr>
                                <th scope="col" width="15%">Imágen</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Alias</th>
                                <th scope="col">Creador</th>
                                <th scope="col" width="45%">Biografia</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?PHP foreach ($personajes as $P) { ?>
                                <tr>
                                    <td><img src="../img/personajes/<?= $P->getImagen() ?>" alt="Imágen Illustrativa de <?= $P->getNombre() ?>" class="img-fluid rounded shadow-sm"></td>
                                    <td><?= $P->getNombre() ?></td>
                                    <td><?= $P->getAlias() ?></td>
                                    <td><?= $P->getCreadores() ?></td>
                                    <td><?= $P->getBiografia() ?></td>
                                    <td>
                                        <a href="index.php?sec=edit_personaje&id=<?= $P->getId() ?>" role="button" class="d-block btn btn-sm btn-warning mb-1">Editar</a>
                                        <a href="index.php?sec=delete_personaje&id=<?= $P->getId() ?>" role="button" class="d-block btn btn-sm btn-danger">Eliminar</a>
                                    </td>
                                </tr>
                            <?PHP } ?>
                        </tbody>

                    </table>
                    <a href="index.php?sec=add_personaje" class="btn btn-primary mt-5"> Cargar nuevo personaje</a>
                </div>

            </div>
        </div>
    </div>
</div>