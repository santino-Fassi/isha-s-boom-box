<?php
$personajes = Personaje::listado_completo();
?>
<section class="row my-5">
    <div class="col">
        <h2 class="h1 text-center mb-5 fw-bold">Agregar nuevo Regateo</h2>

        <form class="row g-3" action="actions/add_regateo_acc.php" method="POST">

            <div class="col-12 col-md-6 mb-3">
                <label for="personaje_id" class="form-label">Personaje Portador</label>
                <select class="form-select" name="personaje_id" id="personaje_id" required>
                    <option value="" selected disabled>Elija una opción</option>
                    <?php foreach ($personajes as $P) { ?>
                        <option value="<?= $P->getId() ?>"><?= $P->getNombreCompleto() ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="personalidad" class="form-label">Personalidad</label>
                <input type="text" class="form-control" id="personalidad" name="personalidad" required>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="estrategia_correcta" class="form-label">Estrategia Correcta (-10%)</label>
                <select class="form-select" name="estrategia_correcta" id="estrategia_correcta" required>
                    <option value="" selected disabled>Elija una opción</option>
                    <option value="tecnico">Técnico</option>
                    <option value="frontal">Frontal</option>
                    <option value="caotico">Caótico</option>
                </select>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="estrategia_intermedia" class="form-label">Estrategia Intermedia (0%)</label>
                <select class="form-select" name="estrategia_intermedia" id="estrategia_intermedia" required>
                    <option value="" selected disabled>Elija una opción</option>
                    <option value="tecnico">Técnico</option>
                    <option value="frontal">Frontal</option>
                    <option value="caotico">Caótico</option>
                </select>
            </div>

            <?php for ($i = 1; $i <= 3; $i++) { ?>
                <div class="col-12 mt-4">
                    <h3 class="h4 border-bottom pb-2">Instancia <?= $i ?></h3>
                </div>
                <div class="col-12 mb-2">
                    <label for="mensaje_<?= $i ?>" class="form-label">Mensaje <?= $i ?></label>
                    <textarea class="form-control" id="mensaje_<?= $i ?>" name="mensaje_<?= $i ?>" rows="2"
                        required></textarea>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label for="opcion_tecnica_<?= $i ?>" class="form-label">Opción Técnica <?= $i ?></label>
                    <textarea class="form-control" id="opcion_tecnica_<?= $i ?>" name="opcion_tecnica_<?= $i ?>" rows="3"
                        required></textarea>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label for="opcion_frontal_<?= $i ?>" class="form-label">Opción Frontal <?= $i ?></label>
                    <textarea class="form-control" id="opcion_frontal_<?= $i ?>" name="opcion_frontal_<?= $i ?>" rows="3"
                        required></textarea>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label for="opcion_caotica_<?= $i ?>" class="form-label">Opción Caótica <?= $i ?></label>
                    <textarea class="form-control" id="opcion_caotica_<?= $i ?>" name="opcion_caotica_<?= $i ?>" rows="3"
                        required></textarea>
                </div>
            <?php } ?>

            <div class="col-12 mt-4">
                <h3 class="h4 border-bottom pb-2">Respuestas Finales</h3>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label for="respuesta_exito" class="form-label">Respuesta de Éxito (-10%)</label>
                <textarea class="form-control" id="respuesta_exito" name="respuesta_exito" rows="3" required></textarea>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label for="respuesta_neutral" class="form-label">Respuesta Neutral (0%)</label>
                <textarea class="form-control" id="respuesta_neutral" name="respuesta_neutral" rows="3"
                    required></textarea>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <label for="respuesta_fallo" class="form-label">Respuesta de Fallo (+5%)</label>
                <textarea class="form-control" id="respuesta_fallo" name="respuesta_fallo" rows="3" required></textarea>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Cargar</button>
            </div>
        </form>
    </div>
</section>