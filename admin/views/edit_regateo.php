<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$regateo = Regateo::get_x_id($id);
$personajes = Personaje::listado_completo();
?>
<section class="row my-5">
    <div class="col">
        <h2 class="h1 text-center mb-5 fw-bold">Editar los datos de un Regateo</h2>

        <?php if ($regateo) {
            $instancias = $regateo->getInstancias();
            ?>
            <form class="row g-3" action="actions/edit_regateo_acc.php?id=<?= $regateo->getId() ?>" method="POST">

                <div class="col-12 col-md-6 mb-3">
                    <label for="personaje_id" class="form-label">Personaje Portador</label>
                    <select class="form-select" name="personaje_id" id="personaje_id" required>
                        <?php foreach ($personajes as $P) { ?>
                            <option value="<?= $P->getId() ?>" <?= $P->getId() === $regateo->getPersonaje_id() ? 'selected' : '' ?>>
                                <?= $P->getNombreCompleto() ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="personalidad" class="form-label">Personalidad</label>
                    <input type="text" class="form-control" id="personalidad" name="personalidad"
                        value="<?= htmlspecialchars($regateo->getPersonalidad()) ?>" required>
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="estrategia_correcta" class="form-label">Estrategia Correcta (-10%)</label>
                    <select class="form-select" name="estrategia_correcta" id="estrategia_correcta" required>
                        <option value="tecnico" <?= $regateo->getEstrategia_correcta() === 'tecnico' ? 'selected' : '' ?>>
                            Técnico</option>
                        <option value="frontal" <?= $regateo->getEstrategia_correcta() === 'frontal' ? 'selected' : '' ?>>
                            Frontal</option>
                        <option value="caotico" <?= $regateo->getEstrategia_correcta() === 'caotico' ? 'selected' : '' ?>>
                            Caótico</option>
                    </select>
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="estrategia_intermedia" class="form-label">Estrategia Intermedia (0%)</label>
                    <select class="form-select" name="estrategia_intermedia" id="estrategia_intermedia" required>
                        <option value="tecnico" <?= $regateo->getEstrategia_intermedia() === 'tecnico' ? 'selected' : '' ?>>
                            Técnico</option>
                        <option value="frontal" <?= $regateo->getEstrategia_intermedia() === 'frontal' ? 'selected' : '' ?>>
                            Frontal</option>
                        <option value="caotico" <?= $regateo->getEstrategia_intermedia() === 'caotico' ? 'selected' : '' ?>>
                            Caótico</option>
                    </select>
                </div>

                <?php for ($i = 1; $i <= 3; $i++) { ?>
                    <div class="col-12 mt-4">
                        <h3 class="h4 border-bottom pb-2">Instancia <?= $i ?></h3>
                    </div>
                    <div class="col-12 mb-2">
                        <label for="mensaje_<?= $i ?>" class="form-label">Mensaje <?= $i ?></label>
                        <textarea class="form-control" id="mensaje_<?= $i ?>" name="mensaje_<?= $i ?>" rows="2"
                            required><?= htmlspecialchars($instancias[$i]['mensaje']) ?></textarea>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="opcion_tecnica_<?= $i ?>" class="form-label">Opción Técnica <?= $i ?></label>
                        <textarea class="form-control" id="opcion_tecnica_<?= $i ?>" name="opcion_tecnica_<?= $i ?>" rows="3"
                            required><?= htmlspecialchars($instancias[$i]['opciones']['tecnico']) ?></textarea>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="opcion_frontal_<?= $i ?>" class="form-label">Opción Frontal <?= $i ?></label>
                        <textarea class="form-control" id="opcion_frontal_<?= $i ?>" name="opcion_frontal_<?= $i ?>" rows="3"
                            required><?= htmlspecialchars($instancias[$i]['opciones']['frontal']) ?></textarea>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="opcion_caotica_<?= $i ?>" class="form-label">Opción Caótica <?= $i ?></label>
                        <textarea class="form-control" id="opcion_caotica_<?= $i ?>" name="opcion_caotica_<?= $i ?>" rows="3"
                            required><?= htmlspecialchars($instancias[$i]['opciones']['caotico']) ?></textarea>
                    </div>
                <?php } ?>

                <div class="col-12 mt-4">
                    <h3 class="h4 border-bottom pb-2">Respuestas Finales</h3>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label for="respuesta_exito" class="form-label">Respuesta de Éxito (-10%)</label>
                    <textarea class="form-control" id="respuesta_exito" name="respuesta_exito" rows="3"
                        required><?= htmlspecialchars($regateo->getRespuesta_exito()) ?></textarea>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label for="respuesta_neutral" class="form-label">Respuesta Neutral (0%)</label>
                    <textarea class="form-control" id="respuesta_neutral" name="respuesta_neutral" rows="3"
                        required><?= htmlspecialchars($regateo->getRespuesta_neutral()) ?></textarea>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label for="respuesta_fallo" class="form-label">Respuesta de Fallo (+5%)</label>
                    <textarea class="form-control" id="respuesta_fallo" name="respuesta_fallo" rows="3"
                        required><?= htmlspecialchars($regateo->getRespuesta_fallo()) ?></textarea>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-hextech btn-editar w-100">Editar</button>
                </div>
            </form>
        <?php } else { ?>
            <p class="text-center">No se encontró el regateo solicitado.</p>
        <?php } ?>
    </div>
</section>