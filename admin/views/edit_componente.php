<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$componente = Componente::get_x_id($id);
?>

<section class="row my-5">
    <div class="col">
        <h2 class="h1 text-center mb-5 fw-bold">Editar los datos de un Componente</h2>

        <?php if ($componente) { ?>
            <form class="row g-3" action="actions/edit_componente_acc.php?id=<?= $componente->getId() ?>" method="POST">

                <div class="col-12 col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"
                        value="<?= htmlspecialchars($componente->getNombre()) ?>" required>
                </div>

                <div class="col-12 mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="5"
                        required><?= htmlspecialchars($componente->getDescripcion()) ?></textarea>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-hextech btn-editar w-100">Editar</button>
                </div>

            </form>
        <?php } else { ?>
            <p class="text-center">No se encontró el componente solicitado.</p>
        <?php } ?>
    </div>
</section>