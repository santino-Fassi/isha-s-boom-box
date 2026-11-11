<section class="catalogo-jinx py-5">
    <div class="container">

        <header class="encabezado-catalogo text-center mb-5">
            <span class="subtitulo-catalogo">ZAUN // MENSAJERÍA CLANDESTINA</span>
            <h2 class="h1">BUZÓN DE <span>CONTRABANDO</span></h2>
            <p>¿Querés encargar un <span class="fw-bold">artefacto a medida</span> o hacer un pedido especial sin que se
                entere nadie?</p>
        </header>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">

                <article class="card artefacto-card p-4">
                    <h3 class="h4 mb-4">Completá los datos para el envío clandestino</h3>

                    <form action="index.php?sec=gracias" method="POST" class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="alias" class="form-label fw-bold text-light">Tu Alias en el
                                Submundo</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" id="alias"
                                name="alias" placeholder="Ej: Silco / Comprador Anónimo" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label fw-bold text-light">Correo Electrónico de
                                Contacto</label>
                            <input type="email" class="form-control bg-dark text-light border-secondary" id="email"
                                name="email" placeholder="nombre@zaun.com" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="faccion" class="form-label fw-bold text-light">Punto de Entrega
                                (Facción)</label>
                            <select class="form-select bg-dark text-light border-secondary" id="faccion" name="faccion"
                                required>
                                <option value="" selected disabled>Seleccioná una zona...</option>
                                <option value="Zaun (Las Líneas)">Zaun (Las Líneas)</option>
                                <option value="Piltover (Distrito del Puerto)">Piltover (Distrito del Puerto)</option>
                                <option value="Noxus (Campamento Exterior)">Noxus (Campamento Exterior)</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="artefacto" class="form-label fw-bold text-light">Artefacto o Juguete de
                                Interés</label>
                            <input type="text" class="form-control bg-dark text-light border-secondary" id="artefacto"
                                name="artefacto" placeholder="Ej: Cara de Pescado / Z-Drive">
                        </div>

                        <div class="col-12">
                            <label for="mensaje" class="form-label fw-bold text-light">Especificaciones del Pedido o
                                Consulta</label>
                            <textarea class="form-control bg-dark text-light border-secondary" id="mensaje"
                                name="mensaje" rows="5" placeholder="Contame qué querés hacer volar por los aires..."
                                required></textarea>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-artefacto w-100">
                                ENVIAR PEDIDO <span>→</span>
                            </button>
                        </div>
                    </form>
                </article>

            </div>
        </div>

    </div>
</section>