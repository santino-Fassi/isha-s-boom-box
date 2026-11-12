
const bomba = document.querySelector("#bombaJinx");

if (bomba) {

    bomba.addEventListener("click", function () {

        if (bomba.classList.contains("explotando")) {
            return;
        }

        bomba.classList.remove("reapareciendo");
        bomba.classList.add("explotando");
        bomba.disabled = true;

        const colores = [
            "#EC399B",
            "#00C5F2",
            "#A35BE8",
            "#f4f3ee",
            "#FFFFFF",
            "#36f2ff"
        ];

        // DESTELLO
        const destello = document.createElement("span");
        destello.classList.add("destello-bomba");
        bomba.appendChild(destello);

        // ONDA EXPANSIVA
        const onda = document.createElement("span");
        onda.classList.add("onda-bomba");
        bomba.appendChild(onda);

        // TEXTO BOOM
        const boom = document.createElement("span");
        boom.classList.add("texto-boom");
        boom.textContent = "BOOM!";
        bomba.appendChild(boom);

        // PARTICULAS
        for (let i = 0; i < 36; i++) {

            const particula = document.createElement("span");
            particula.classList.add("particula-bomba");

            const angulo = Math.random() * Math.PI * 2;
            const distancia = 90 + Math.random() * 140;

            const x = Math.cos(angulo) * distancia;
            const y = Math.sin(angulo) * distancia;

            particula.style.setProperty("--x", `${x}px`);
            particula.style.setProperty("--y", `${y}px`);
            particula.style.setProperty(
                "--rotacion",
                `${Math.random() * 720 - 360}deg`
            );

            particula.style.backgroundColor =
                colores[Math.floor(Math.random() * colores.length)];

            
            const forma = Math.random();

            if (forma < 0.4) {
                particula.style.width = `${8 + Math.random() * 15}px`;
                particula.style.height = particula.style.width;
                particula.style.borderRadius = "50%";
            } else if (forma < 0.75) {
                particula.style.width = `${7 + Math.random() * 12}px`;
                particula.style.height = `${18 + Math.random() * 18}px`;
                particula.style.borderRadius = "2px";
            } else {
                particula.style.width = `${10 + Math.random() * 15}px`;
                particula.style.height = `${10 + Math.random() * 15}px`;
                particula.style.borderRadius = "0";
            }

            bomba.appendChild(particula);
        }

        // LIMPIAR Y REAPARECER
        setTimeout(function () {

            bomba.querySelectorAll(
                ".particula-bomba, .destello-bomba, .onda-bomba, .texto-boom"
            ).forEach(function (elemento) {
                elemento.remove();
            });

            bomba.classList.remove("explotando");
            bomba.classList.add("reapareciendo");
            bomba.disabled = false;

        }, 1100);

        setTimeout(function () {
            bomba.classList.remove("reapareciendo");
        }, 1700);

    });
}


// =====================================
// BOMBITA DEL CATALOGO
// =====================================

const bombaCatalogo = document.querySelector("#bombaCatalogo");
const mensajeCatalogo = document.querySelector("#mensajeJinxCatalogo");
const textoCatalogo = document.querySelector("#textoJinxCatalogo");

if (bombaCatalogo && mensajeCatalogo && textoCatalogo) {

    const frasesJinx = [
        "¡JAJAJA! ¿TE ASUSTASTE?",
        "¿QUÉ PODRÍA SALIR MAL?",
        "NO TOQUES MIS COSAS... BUENO, TOCALAS.",
        "¡BOOM! ¿VISTE ESO?",
        "UPS... CREO QUE ESO ERA CARO.",
        "¡SOY UN GENIO! NO DISCUTAS.",
        "¿ALGUIEN DIJO EXPLOSIÓN?",
        "¡UN POQUITO DE CAOS NUNCA VIENE MAL!"
    ];

    let temporizadorMensaje;

    bombaCatalogo.addEventListener("click", function () {

        if (bombaCatalogo.classList.contains("explotando")) {
            return;
        }

        clearTimeout(temporizadorMensaje);
        mensajeCatalogo.classList.remove("visible");

        bombaCatalogo.classList.remove("reapareciendo");
        bombaCatalogo.classList.add("explotando");
        bombaCatalogo.disabled = true;

        const colores = [
            "#EC399B",
            "#00C5F2",
            "#A35BE8",
            "#FFF16A",
            "#FFFFFF",
            "#FF5A36"
        ];

        // DESTELLO
        const destello = document.createElement("span");
        destello.classList.add("destello-bomba");
        bombaCatalogo.appendChild(destello);

        // ONDA EXPANSIVA
        const onda = document.createElement("span");
        onda.classList.add("onda-bomba");
        bombaCatalogo.appendChild(onda);

        // TEXTO BOOM
        const boom = document.createElement("span");
        boom.classList.add("texto-boom");
        boom.textContent = "BOOM!";
        bombaCatalogo.appendChild(boom);

        // PARTICULAS
        for (let i = 0; i < 36; i++) {

            const particula = document.createElement("span");
            particula.classList.add("particula-bomba");

            const angulo = Math.random() * Math.PI * 2;
            const distancia = 90 + Math.random() * 140;

            const x = Math.cos(angulo) * distancia;
            const y = Math.sin(angulo) * distancia;

            particula.style.setProperty("--x", `${x}px`);
            particula.style.setProperty("--y", `${y}px`);

            particula.style.setProperty(
                "--rotacion",
                `${Math.random() * 720 - 360}deg`
            );

            particula.style.backgroundColor =
                colores[Math.floor(Math.random() * colores.length)];

            const forma = Math.random();

            if (forma < 0.4) {
                particula.style.width = `${8 + Math.random() * 15}px`;
                particula.style.height = particula.style.width;
                particula.style.borderRadius = "50%";

            } else if (forma < 0.75) {
                particula.style.width = `${7 + Math.random() * 12}px`;
                particula.style.height = `${18 + Math.random() * 18}px`;
                particula.style.borderRadius = "2px";

            } else {
                particula.style.width = `${10 + Math.random() * 15}px`;
                particula.style.height = `${10 + Math.random() * 15}px`;
                particula.style.borderRadius = "0";
            }

            bombaCatalogo.appendChild(particula);
        }

        // LIMPIAR EXPLOSION Y MOSTRAR MENSAJE
        setTimeout(function () {

            bombaCatalogo.querySelectorAll(
                ".particula-bomba, .destello-bomba, .onda-bomba, .texto-boom"
            ).forEach(function (elemento) {
                elemento.remove();
            });

            bombaCatalogo.classList.remove("explotando");
            bombaCatalogo.classList.add("reapareciendo");
            bombaCatalogo.disabled = false;

            // FRASE ALEATORIA DE JINX
            const frase = frasesJinx[
                Math.floor(Math.random() * frasesJinx.length)
            ];

            textoCatalogo.textContent = frase;
            mensajeCatalogo.classList.add("visible");

            // OCULTAR MENSAJE DESPUES DE 4 SEGUNDOS
            temporizadorMensaje = setTimeout(function () {
                mensajeCatalogo.classList.remove("visible");
            }, 4000);

        }, 1100);

        // TERMINAR ANIMACION DE REAPARICION
        setTimeout(function () {
            bombaCatalogo.classList.remove("reapareciendo");
        }, 1700);

    });
}


/* =====================================
   BOMBITA DE SOBRE NOSOTROS
===================================== */

const bombaSocios = document.querySelector("#bombaSocios");
const mensajeSocios = document.querySelector("#mensajeJinxSocios");
const tarjetasSocios = document.querySelector(".socios-contenedor");


if (bombaSocios && mensajeSocios && tarjetasSocios) {

    let temporizadorSocios;

    bombaSocios.addEventListener("click", function () {
        console.log("¡SE HIZO CLIC EN LA BOMBITA DE SOCIOS!");

        if (bombaSocios.classList.contains("explotando")) {
            return;
        }

        clearTimeout(temporizadorSocios);

        mensajeSocios.classList.remove("visible");
        tarjetasSocios.classList.remove("socios-revelados");

        bombaSocios.classList.remove("reapareciendo");
        bombaSocios.classList.add("explotando");
        bombaSocios.disabled = true;

        const colores = [
            "#EC399B",
            "#00C5F2",
            "#A35BE8",
            "#FFF16A",
            "#FFFFFF",
            "#FF5A36"
        ];

        // DESTELLO
        const destello = document.createElement("span");
        destello.classList.add("destello-bomba");
        bombaSocios.appendChild(destello);

        // ONDA DE EXPLOSION
        const onda = document.createElement("span");
        onda.classList.add("onda-bomba");
        bombaSocios.appendChild(onda);

        // TEXTO BOOM
        const boom = document.createElement("span");
        boom.classList.add("texto-boom");
        boom.textContent = "BOOM!";
        bombaSocios.appendChild(boom);

        // PARTICULAS
        for (let i = 0; i < 36; i++) {

            const particula = document.createElement("span");
            particula.classList.add("particula-bomba");

            const angulo = Math.random() * Math.PI * 2;
            const distancia = 90 + Math.random() * 140;

            const x = Math.cos(angulo) * distancia;
            const y = Math.sin(angulo) * distancia;

            particula.style.setProperty("--x", x + "px");
            particula.style.setProperty("--y", y + "px");
            particula.style.setProperty(
                "--rotacion",
                Math.random() * 720 + "deg"
            );

            particula.style.backgroundColor =
                colores[Math.floor(Math.random() * colores.length)];

            if (Math.random() > 0.5) {
                particula.style.borderRadius = "50%";
            } else {
                particula.style.borderRadius = "2px";
            }

            bombaSocios.appendChild(particula);
        }

        // FINAL DE LA EXPLOSION
        setTimeout(function () {

            bombaSocios.querySelectorAll(
                ".particula-bomba, .destello-bomba, .onda-bomba, .texto-boom"
            ).forEach(function (elemento) {
                elemento.remove();
            });

            bombaSocios.classList.remove("explotando");
            bombaSocios.classList.add("reapareciendo");
            bombaSocios.disabled = false;

            // REVELAR EXPEDIENTE
            mensajeSocios.classList.add("visible");

            // RESALTAR LAS DOS TARJETAS
            tarjetasSocios.classList.add("socios-revelados");

            temporizadorSocios = setTimeout(function () {

                mensajeSocios.classList.remove("visible");
                tarjetasSocios.classList.remove("socios-revelados");

            }, 4500);

        }, 1100);

        setTimeout(function () {
            bombaSocios.classList.remove("reapareciendo");
        }, 1700);

    });
}


