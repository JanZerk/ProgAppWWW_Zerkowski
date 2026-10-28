const root = document.documentElement;
const button = document.getElementById("zmiana-motywu");

function zastosuj(motyw) {
    root.setAttribute("data-theme", motyw);
    if (button) {
        button.setAttribute("aria-pressed", motyw === "dark" ? "true" : "false");
    }
}

function zmienMotyw() {
    const nowy = root.getAttribute("data-theme") === "dark" ? "light" : "dark";
    zastosuj(nowy);
    localStorage.setItem("data-theme", nowy);
}

const zapisany = localStorage.getItem("data-theme");
zastosuj(zapisany === "dark" ? "dark" : "light");


button.addEventListener("click", zmienMotyw);


const czas = {
    hour: "numeric",
    minute: "numeric",
    second: "numeric",
};

const obecnaData = document.getElementById("obecna-data");
const obecnyCzas = document.getElementById("obecny-czas");
const startButton = document.getElementById("zegar-start");
const stopButton = document.getElementById("zegar-stop");
if (obecnaData && obecnyCzas && startButton && stopButton) {
    const dataFormater = new Intl.DateTimeFormat("pl-PL");
    const czasFormater = new Intl.DateTimeFormat("pl-PL", {
        hour: "numeric",
        minute: "numeric",
        second: "numeric",
    });

    let idInterval = null;

    function aktualizujDate() {
        const teraz = new Date();
        obecnaData.textContent = dataFormater.format(teraz);
        obecnyCzas.textContent = czasFormater.format(teraz);
    }

    function zegarStart() {
        if (idInterval !== null) return;
        aktualizujDate();
        idInterval = setInterval(aktualizujDate, 1000);
    }

    function zegarStop() {
        clearInterval(idInterval);
        idInterval = null;
    }

    startButton.addEventListener("click", zegarStart);
    stopButton.addEventListener("click", zegarStop);
    zegarStart();
}

const wyszukiwarka = document.getElementById("katalog-search");
const licznik = document.getElementById("licznik");
const brakWynikow = document.getElementById("brak-wynikow");
const karty = document.querySelectorAll(".karta");

if (wyszukiwarka && licznik && brakWynikow) {
    function filtruj() {
        const input = wyszukiwarka.value.trim().toLowerCase();
        let wyniki = 0;

        karty.forEach((karta) => {
            const nazwa = karta.querySelector("h2").textContent.toLowerCase();
            const pasuje = nazwa.includes(input);
            karta.hidden = !pasuje;
            if (pasuje) wyniki++;
        });

        licznik.hidden = false;
        licznik.textContent = input === "" ? "" : `Pasujące wyniki: ${wyniki}`;
        brakWynikow.hidden = wyniki !== 0;
    }

    wyszukiwarka.addEventListener("input", filtruj);
}

const produkty = [
    { id: "produkt1", nazwa: "Kettlebell", cenaGrosze: 20000 },
    { id: "produkt2", nazwa: "Shaker", cenaGrosze: 1500 },
    { id: "produkt3", nazwa: "Tanktop", cenaGrosze: 8000 }
];

const formatPLN = new Intl.NumberFormat("pl-PL", {
    style: "currency",
    currency: "PLN"
});

const formularz = document.getElementById("formularz-kontakt");
const inpProdukt = document.getElementById("input-produkt");
const inpIlosc = document.getElementById("input-ilosc");
const wartoscZapytania = document.getElementById("wartosc-zapytania");
const inpWiadomosc = document.getElementById("input-wiadomosc")
const bladWiadomosc = document.getElementById("blad-wiadomosc");
const podglad = document.getElementById("podglad");

function obliczCenaGrosze(cenaGrosze, ilosc) {
    return cenaGrosze * ilosc;
}

if (inpProdukt && inpIlosc && wartoscZapytania && inpWiadomosc && formularz) {
    function aktualizujWartosc() {
        const produkt = produkty.find((p) => p.id === inpProdukt.value);
        const tekstIlosc = inpIlosc.value.trim();
        const n = Number(tekstIlosc);
        if (!produkt) {
            wartoscZapytania.textContent = "Wartosc zapytania pojawi się po wybraniu produktu";
        } else if (!Number.isInteger(n) || n < 1 || n > 5) {
            wartoscZapytania.textContent = " Proszę podać liczbę całkowitą z zakresu 1–5.";
        } else {
            const wartosc = formatPLN.format(obliczCenaGrosze(produkt.cenaGrosze, n) / 100);
            wartoscZapytania.textContent = `Wartosc zapytania: ${wartosc}`;
        }
    }

    inpProdukt.addEventListener("change", aktualizujWartosc);
    inpIlosc.addEventListener("input", aktualizujWartosc);
    aktualizujWartosc();


    function sprawdzSubmit(submit) {
        submit.preventDefault();
        const produkt = produkty.find((p) => p.id === inpProdukt.value);
        const n = Number(inpIlosc.value);
        const wiadomoscDlugosc = inpWiadomosc.value.trim().length;
        if (wiadomoscDlugosc < 10) {
            podglad.hidden = true;
            bladWiadomosc.hidden = false;
            inpWiadomosc.focus();
        } else {
            const wartosc = formatPLN.format((produkt.cenaGrosze, n) / 100);
            document.getElementById("podglad-produkt").textContent = produkt.nazwa;
            document.getElementById("podglad-ilosc").textContent = n;
            document.getElementById("podglad-wartosc").textContent = wartosc;
            document.getElementById("podglad-wiadomosc").textContent = inpWiadomosc.value;

            podglad.hidden = false;
        }

    }

    function poprawBlad() {
        const wiadomoscDlugosc = inpWiadomosc.value.trim().length;
        if (wiadomoscDlugosc >= 10) {
            bladWiadomosc.hidden = true;
        }
    }

    formularz.addEventListener("submit", sprawdzSubmit);
    inpWiadomosc.addEventListener("input", poprawBlad);
}