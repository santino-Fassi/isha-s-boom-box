<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$categoria = Categoria::get_x_id($id);
?>

<section class="row my-5">
    <div class="col">
        <h2 class="h1 text-center mb-5 fw-bold">Editar los datos de una Categoría</h2>

        <?php if ($categoria) { ?>
            <form class="row g-3" action="actions/edit_categoria_acc.php?id=<?= $categoria->getId() ?>" method="POST">

                <div class="col-12 col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"
                        value="<?= htmlspecialchars($categoria->getNombre()) ?>" required>
                </div>

                <div class="col-12 mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="5"
                        required><?= htmlspecialchars($categoria->getDescripcion()) ?></textarea>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-warning w-100">Editar</button>
                </div>

            </form>
        <?php } else { ?>
            <p class="text-center">No se encontró la categoría solicitada.</p>
        <?php } ?>
    </div>
</section>