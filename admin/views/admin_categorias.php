<?php
$categorias = Categoria::listado_completo();
?>

<section class="row my-5">
    <div class="col">

        <h2 class="h1 text-center mb-5 fw-bold">Administración de Categorías</h2>

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
                    <?php foreach ($categorias as $categoria) { ?>
                        <tr>
                            <td><?= $categoria->getNombre() ?></td>
                            <td><?= $categoria->getDescripcion() ?></td>
                            <td>
                                <a href="index.php?sec=edit_categoria&id=<?= $categoria->getId() ?>" role="button"
                                    class="btn btn-hextech btn-editar w-100">Editar</a>
                                <a href="index.php?sec=delete_categoria&id=<?= $categoria->getId() ?>" role="button"
                                    class="d-block btn btn-sm btn-hextech btn-eliminar mt-4">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <a href="index.php?sec=add_categoria" class="btn btn-hextech btn-agregar w-100 mt-3">Cargar nueva Categoría</a>

    </div>
</section>