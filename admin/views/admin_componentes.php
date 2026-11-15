<?php
$componentes = Componente::listado_completo();
?>

<section class="row my-5">
    <div class="col">

        <h2 class="h1 text-center mb-5 fw-bold">Administración de Componentes</h2>

        <div class="table-responsive mb-4">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col" class="col-descripcion-admin">Descripción</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($componentes as $componente) { ?>
                        <tr>
                            <td><?= $componente->getNombre() ?></td>
                            <td><?= $componente->getDescripcion() ?></td>
                            <td>
                                <a href="index.php?sec=edit_componente&id=<?= $componente->getId() ?>" role="button"
                                    class="d-block btn btn-sm btn-warning mb-1">Editar</a>
                                <a href="index.php?sec=delete_componente&id=<?= $componente->getId() ?>" role="button"
                                    class="d-block btn btn-sm btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <a href="index.php?sec=add_componente" class="btn btn-primary w-100 mt-3">Cargar nuevo Componente</a>

    </div>
</section>