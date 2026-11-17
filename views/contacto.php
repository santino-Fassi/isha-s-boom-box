<section class="contacto-jinx py-5">
    <div class="container">

        <header class="encabezado-catalogo text-center mb-5">
            <span class="subtitulo-catalogo">ZAUN // CANAL NO AUTORIZADO</span>

            <h2 class="h1">BUZÓN DE <span>CONTRABANDO</span></h2>

            <p>
                ¿Necesitás algo especial? ¿Tenés una idea peligrosa?
                <br>
                <span class="fw-bold">Jinx está escuchando... probablemente.</span>
            </p>
        </header>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-9">

                <article class="terminal-jinx">

                    <div class="terminal-barra">
                        <div class="terminal-luces">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                        <span class="terminal-nombre">JINX_COMMS.exe</span>

                        <span class="terminal-version">V.09.13</span>
                    </div>

                    <div class="terminal-encabezado">

                        <div>
                            <span class="terminal-etiqueta">
                                <span class="indicador-online"></span>
                                TRANSMISIÓN DISPONIBLE
                            </span>

                            <h3>INICIAR CONTACTO</h3>

                            <p>
                                Dejá tu mensaje. Si me gusta, tal vez te conteste.
                                Si explota algo, no fui yo.
                            </p>
                        </div>

                        <div class="terminal-sello">
                            <span>NOXUS</span>
                            <span class="fw-bold sello-signo">?</span>
                        </div>

                    </div>

                    <div class="terminal-separador"></div>

                    <form action="index.php?sec=gracias" method="POST" class="formulario-jinx row g-4">

                        <div class="col-12 col-md-6">
                            <label for="alias">
                                <span>01 //</span> TU ALIAS
                            </label>

                            <input type="text" id="alias" name="alias" placeholder="¿Cómo te llamás, desconocido?"
                                required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="email">
                                <span>02 //</span> SEÑAL DE CONTACTO
                            </label>

                            <input type="email" id="email" name="email" placeholder="nombre@zaun.com" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="faccion">
                                <span>03 //</span> ZONA DE ENTREGA
                            </label>

                            <select id="faccion" name="faccion" required>
                                <option value="" selected disabled>Seleccioná una zona...</option>
                                <option value="Zaun (Las Líneas)">Zaun (Las Líneas)</option>
                                <option value="Piltover (Distrito del Puerto)">Piltover (Distrito del Puerto)</option>
                                <option value="Noxus (Campamento Exterior)">Noxus (Campamento Exterior)</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <span class="form-label-jinx mb-2">
                                <span>04 //</span> OBJETOS DE INTERÉS
                            </span>

                            <p class="mensaje-ayuda mb-3">
                                Seleccioná todos los tipos de artefactos que te interesan.
                                Nunca está de más tener varias opciones...
                            </p>

                            <div class="opciones-artefactos">

                                <label class="opcion-artefacto">
                                    <input type="checkbox" name="objetos_interes[]" value="Armas y explosivos">
                                    <span class="check-artefacto"></span>
                                    <span>Armas y explosivos</span>
                                </label>

                                <label class="opcion-artefacto">
                                    <input type="checkbox" name="objetos_interes[]" value="Tecnología hextech">
                                    <span class="check-artefacto"></span>
                                    <span>Tecnología hextech</span>
                                </label>

                                <label class="opcion-artefacto">
                                    <input type="checkbox" name="objetos_interes[]" value="Dispositivos mecánicos">
                                    <span class="check-artefacto"></span>
                                    <span>Dispositivos mecánicos</span>
                                </label>

                                <label class="opcion-artefacto">
                                    <input type="checkbox" name="objetos_interes[]" value="Pociones y sustancias">
                                    <span class="check-artefacto"></span>
                                    <span>Pociones y sustancias</span>
                                </label>

                                <label class="opcion-artefacto">
                                    <input type="checkbox" name="objetos_interes[]" value="Artefactos experimentales">
                                    <span class="check-artefacto"></span>
                                    <span>Artefactos experimentales</span>
                                </label>

                                <label class="opcion-artefacto">
                                    <input type="checkbox" name="objetos_interes[]" value="Objetos misteriosos">
                                    <span class="check-artefacto"></span>
                                    <span>Objetos misteriosos</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="artefacto" class="form-label-jinx">
                                <span>05 //</span> ¿BUSCÁS ALGO EN PARTICULAR?
                                <small>(OPCIONAL)</small>
                            </label>

                            <input type="text" name="artefacto" id="artefacto" class="campo-jinx"
                                placeholder="Describí ese artefacto que tanto necesitás...">

                            <p class="mensaje-ayuda mt-2">
                                ¿Tenés un encargo específico? Dejá los detalles acá.
                            </p>
                        </div>

                        <div class="col-12">
                            <label for="mensaje">
                                <span>06 //</span> DETALLES DE LA OPERACIÓN
                            </label>

                            <textarea id="mensaje" name="mensaje" rows="5"
                                placeholder="Escribí tu pedido... ¡Y no te olvides de mencionar si tiene que explotar!"
                                required></textarea>

                            <div class="mensaje-ayuda">
                                <span>TIP // No aceptamos quejas por explosiones accidentales.</span>
                                <span>MAX CHAOS: 100%</span>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <button type="submit" class="btn-enviar-jinx">
                                <span>TRANSMITIR MENSAJE</span>
                                <span class="fw-bold flecha-envio">→</span>
                            </button>
                        </div>

                    </form>

                    <div class="terminal-pie">
                        <span>ZAUN NETWORK // ENCRYPTED CONNECTION</span>
                        <span>DON'T TRUST ANYONE.</span>
                    </div>

                </article>

                <p class="contacto-nota">
                    <span>!</span> La comunicación puede ser interceptada.
                    Jinx no se responsabiliza por daños colaterales.
                </p>

            </div>
        </div>

    </div>
</section>