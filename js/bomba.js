'use strict';

const coloresJinx = [
    "#EC399B",
    "#00C5F2",
    "#A35BE8",
    "#FFF16A",
    "#FFFFFF",
    "#FF5A36"
];

const frasesJinx = [
    "¡JAJ! ¿TE ASUSTASTE?",
    "¿QUÉ PODRÍA SALIR MAL?",
    "NO TOQUES MIS COSAS... BUENO, TOCALAS.",
    "¡BOOM! ¿VISTE ESO?",
    "UPS... CREO QUE ESO ERA CARO.",
    "¡SOY UN GENIO! NO DISCUTAS.",
    "¿ALGUIEN DIJO EXPLOSIÓN?",
    "¡UN POQUITO DE CAOS NUNCA VIENE MAL!"
];

function crearParticulas(boton, paleta) {
    const destello = document.createElement("span");
    destello.classList.add("destello-bomba");
    boton.appendChild(destello);

    const onda = document.createElement("span");
    onda.classList.add("onda-bomba");
    boton.appendChild(onda);

    const boom = document.createElement("span");
    boom.classList.add("texto-boom");
    boom.textContent = "BOOM!";
    boton.appendChild(boom);

    for (let i = 0; i < 36; i++) {
        const particula = document.createElement("span");
        particula.classList.add("particula-bomba");

        const angulo = Math.random() * Math.PI * 2;
        const distancia = 90 + Math.random() * 140;

        const x = Math.cos(angulo) * distancia;
        const y = Math.sin(angulo) * distancia;

        particula.style.setProperty("--x", `${x}px`);
        particula.style.setProperty("--y", `${y}px`);
        particula.style.setProperty("--rotacion", `${Math.random() * 720 - 360}deg`);
        particula.style.backgroundColor = paleta[Math.floor(Math.random() * paleta.length)];

        const forma = Math.random();

        if (forma < 0.4) {
            const diametro = 8 + Math.random() * 15;
            particula.style.width = `${diametro}px`;
            particula.style.height = `${diametro}px`;
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

        boton.appendChild(particula);
    }
}

function detonarBomba(boton, paleta, alExplotar) {
    if (boton.classList.contains("explotando")) {
        return;
    }

    boton.classList.remove("reapareciendo");
    boton.classList.add("explotando");
    boton.disabled = true;

    crearParticulas(boton, paleta);

    setTimeout(() => {
        boton.querySelectorAll(
            ".particula-bomba, .destello-bomba, .onda-bomba, .texto-boom"
        ).forEach(elemento => {
            elemento.remove();
        });

        boton.classList.remove("explotando");
        boton.classList.add("reapareciendo");
        boton.disabled = false;

        if (typeof alExplotar === "function") {
            alExplotar();
        }
    }, 1100);

    setTimeout(() => {
        boton.classList.remove("reapareciendo");
    }, 1700);
}

const bombaInicio = document.querySelector("#bombaJinx");

if (bombaInicio) {
    const coloresInicio = [
        "#EC399B",
        "#00C5F2",
        "#A35BE8",
        "#f4f3ee",
        "#FFFFFF",
        "#36f2ff"
    ];

    bombaInicio.addEventListener("click", () => {
        detonarBomba(bombaInicio, coloresInicio);
    });
}

const bombaCatalogo = document.querySelector("#bombaCatalogo");
const mensajeCatalogo = document.querySelector("#mensajeJinxCatalogo");
const textoCatalogo = document.querySelector("#textoJinxCatalogo");

if (bombaCatalogo && mensajeCatalogo && textoCatalogo) {
    let temporizadorMensaje;

    bombaCatalogo.addEventListener("click", () => {
        if (bombaCatalogo.classList.contains("explotando")) {
            return;
        }

        clearTimeout(temporizadorMensaje);
        mensajeCatalogo.classList.remove("visible");

        detonarBomba(bombaCatalogo, coloresJinx, () => {
            const frase = frasesJinx[Math.floor(Math.random() * frasesJinx.length)];
            textoCatalogo.textContent = frase;
            mensajeCatalogo.classList.add("visible");

            temporizadorMensaje = setTimeout(() => {
                mensajeCatalogo.classList.remove("visible");
            }, 4000);
        });
    });
}

const bombaSocios = document.querySelector("#bombaSocios");
const mensajeSocios = document.querySelector("#mensajeJinxSocios");
const tarjetasSocios = document.querySelector(".socios-contenedor");

if (bombaSocios && mensajeSocios && tarjetasSocios) {
    let temporizadorSocios;

    bombaSocios.addEventListener("click", () => {
        if (bombaSocios.classList.contains("explotando")) {
            return;
        }

        clearTimeout(temporizadorSocios);
        mensajeSocios.classList.remove("visible");
        tarjetasSocios.classList.remove("socios-revelados");

        detonarBomba(bombaSocios, coloresJinx, () => {
            mensajeSocios.classList.add("visible");
            tarjetasSocios.classList.add("socios-revelados");

            temporizadorSocios = setTimeout(() => {
                mensajeSocios.classList.remove("visible");
                tarjetasSocios.classList.remove("socios-revelados");
            }, 4500);
        });
    });
}
