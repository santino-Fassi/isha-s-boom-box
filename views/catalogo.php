<?PHP
$perSeleccionado = $_GET['per'] ?? null;

$catalogo = Comic::catalogo_x_personaje($perSeleccionado);
$datosPersonaje = Personaje::get_x_id($perSeleccionado);

?>

<div class=" d-flex justify-content-center p-5">
    <div>
        <h1 class="text-center mb-5 fw-bold">CATÁLOGO DE <span class="text-danger"><?= strtoupper($datosPersonaje->getTitulo(TRUE)) ?></span></h1>
        <div class="container">

            <div class="row">

                <div class="row">
                    <?PHP if (!empty($catalogo)) { ?>
                        <?PHP foreach ($catalogo as $comic) { ?>
                            <div class="col-12 col-md-4">
                                <div class="card mb-3">
                                    <img src="img/covers/<?= $comic->getPortada() ?>" class="card-img-top" alt="Portada de <?= $comic->get_nombre_completo() ?>">
                                    <div class="card-body">
                                        <p class="fs-6 m-0 fw-bold text-danger"><?= $comic->get_nombre_completo() ?></p>
                                        <h5 class="card-title"><?= $comic->getTitulo() ?></h5>
                                        <p class="card-text"><?= $comic->get_bajada_reducida() ?></p>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><span class="fw-bold">Guion:</span> <?= $comic->getGuion() ?></li>
                                        <li class="list-group-item"><span class="fw-bold">Arte:</span> <?= $comic->getArte() ?></li>
                                        <li class="list-group-item"><span class="fw-bold">Publicación:</span> <?= $comic->getPublicacion() ?></li>
                                    </ul>
                                    <div class="card-body">
                                        <div class="fs-3 mb-3 fw-bold text-center text-danger"><?= $comic->get_precio_formateado() ?></div>
                                        <a href="index.php?sec=producto&id=<?= $comic->getId() ?>" class="btn btn-danger w-100 fw-bold">VER MÁS</a>
                                    </div>

                                </div>
                            </div>
                        <?PHP } ?>

                    <?PHP } else { ?>
                        <div class="col">
                            <h2 class="text-center m-5">No tenenemos comics de este personaje.</h2>
                        </div>
                    <?PHP } ?>
                </div>
            </div>
        </div>
    </div>
</div>