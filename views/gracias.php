<?PHP

$aliasCliente = htmlspecialchars(trim($_POST['alias'] ?? ''));
$emailCliente = htmlspecialchars(trim($_POST['email'] ?? ''));
$faccionCliente = htmlspecialchars(trim($_POST['faccion'] ?? ''));
$artefactoInteres = htmlspecialchars(trim($_POST['artefacto'] ?? ''));
$mensajeCliente = htmlspecialchars(trim($_POST['mensaje'] ?? ''));

?>

<section class="catalogo-jinx py-5">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <article class="card artefacto-card p-4 text-center border-info">
                    <h2 class="mb-3 h1">¡MENSAJE RECIBIDO!</h2>
                    <p>
                        Escuchame bien, <span class="fw-bold"><?= $aliasCliente ?></span>: tu paloma mecánica llegó sana
                        y salva a las profundidades de <span class="fst-italic"><?= $faccionCliente ?></span>.
                    </p>
                    <p>
                        Registramos tu interés por <span
                            class="fw-bold"><?= $artefactoInteres ?: 'nuestro arsenal general' ?></span> y te enviaremos
                        las coordenadas de entrega a <span class="fst-italic"><?= $emailCliente ?></span>.
                    </p>
                    <blockquote class="blockquote my-3 p-3 bg-dark rounded border border-secondary">
                        <p class="mb-0"><span class="fst-italic">"<?= $mensajeCliente ?>"</span></p>
                    </blockquote>
                    <a href="index.php?sec=catalogo_completo" class="btn btn-artefacto mt-3">SEGUIR REVISANDO EL
                        ARSENAL</a>
                </article>

            </div>
        </div>

    </div>
</section>