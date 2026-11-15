<section class="row my-5">
    <div class="col">
        <h2 class="h1 text-center mb-5 fw-bold">Agregar un nuevo personaje</h2>

        <form class="row g-3" action="actions/add_personaje_acc.php" method="POST" enctype="multipart/form-data">

            <div class="col-12 col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="alias" class="form-label">Alias</label>
                <input type="text" class="form-control" id="alias" name="alias" required>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="faccion" class="form-label">Facción</label>
                <select class="form-select" id="faccion" name="faccion" required>
                    <option value="" selected disabled>Elija una opción</option>
                    <option value="Zaun">Zaun</option>
                    <option value="Piltover">Piltover</option>
                    <option value="Noxus">Noxus</option>
                </select>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input class="form-control" type="file" id="imagen" name="imagen" required>
            </div>

            <div class="col-12 mb-3">
                <label for="biografia" class="form-label">Biografía</label>
                <textarea class="form-control" id="biografia" name="biografia" rows="5" required></textarea>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Cargar</button>
            </div>

        </form>
    </div>
</section>