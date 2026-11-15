<?php
$artefactos = Artefacto::catalogo_completo();
?>

<section class="row my-5">
    <div class="col">

        <h2 class="h1 text-center mb-5 fw-bold">Administración de Artefactos</h2>

        <div class="table-responsive mb-4">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col" class="col-imagen-admin">Imagen</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Alias</th>
                        <th scope="col">Categoría</th>
                        <th scope="col">Creador</th>
                        <th scope="col">Portador</th>
                        <th scope="col">Componentes</th>
                        <th scope="col">Origen</th>
                        <th scope="col">Peligro</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($artefactos as $A) { ?>
                        <tr>
                            <td>
                                <img src="../img/artefactos/<?= $A->getImagen() ?>"
                                    alt="Imagen ilustrativa de <?= $A->getNombre() ?>"
                                    class="img-fluid rounded shadow-sm">
                            </td>
                            <td><?= $A->getNombre() ?></td>
                            <td><?= $A->getAlias() ?></td>
                            <td><?= $A->getCategoria()->getNombre() ?></td>
                            <td><?= $A->getCreador()->getNombreCompleto() ?></td>
                            <td><?= $A->getUsuario()->getNombreCompleto() ?></td>
                            <td>
                                <?php foreach ($A->get_componentes() as $comp) { ?>
                                    <span class="badge bg-secondary d-inline-block mb-1"><?= $comp->getNombre() ?></span>
                                <?php } ?>
                            </td>
                            <td><?= $A->getOrigen() ?></td>
                            <td><?= $A->getNivel_peligro() ?> / 10</td>
                            <td><?= $A->get_precio_formateado() ?></td>
                            <td>
                                <a href="index.php?sec=edit_artefacto&id=<?= $A->getId() ?>" role="button"
                                    class="d-block btn btn-sm btn-warning mb-1">Editar</a>
                                <a href="index.php?sec=delete_artefacto&id=<?= $A->getId() ?>" role="button"
                                    class="d-block btn btn-sm btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <a href="index.php?sec=add_artefacto" class="btn btn-primary w-100 mt-3">Cargar nuevo Artefacto</a>

    </div>
</section>
