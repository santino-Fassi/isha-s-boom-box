<section class="row my-5">
    <div class="col">
        <h2 class="h1 text-center mb-5 fw-bold">Agregar nuevo componente</h2>

        <form class="row g-3" action="actions/add_componente_acc.php" method="POST">

            <div class="col-12 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="col-12 mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required></textarea>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Cargar</button>
            </div>

        </form>
    </div>
</section>