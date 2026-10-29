W celu uruchomienia należy w wierszu poleceń Windows i w katalogu głównym projektu wpisać komendę
`python -m http.server 8000`. Następnie w przeglądarce otwrzyć adres
`http://localhost:8000/`.

## Opis przepływów

### 1. Wycena na żywo

- **Zdarzenie:** użytkownik zmienia produkt (`change` na `#input-produkt`) lub
  wpisuje ilość (`input` na `#input-ilosc`). Obsługuje je `aktualizujWartosc`.
- **Dane wejściowe:** wybrany produkt (`inpProdukt.value`, wyszukiwany w tablicy
  `produkty` po `id`) oraz ilość (`inpIlosc.value`, po `trim()` zamieniona na liczbę).
- **Obliczenie:** sprawdzam, czy produkt jest wybrany i czy ilość jest liczbą
  całkowitą z zakresu 1–5. Jeśli tak, `obliczCenaGrosze(cenaGrosze, ilosc)` zwraca
  iloczyn w całkowitych groszach, a po podzieleniu przez 100 `Intl.NumberFormat`
  (`pl-PL`, PLN) tworzy tekst, np. `59,97 zł`. Funkcja liczy bez odwołań do DOM.
- **Zmiana DOM:** wynik albo instrukcja (przy braku produktu lub błędnej ilości)
  trafia do `#wartosc-zapytania` przez `textContent`.

### 2. Wysłanie formularza (podgląd)

- **Zdarzenie:** `submit` na `#formularz-kontakt`. Najpierw przeglądarka sprawdza
  ograniczenia HTML, potem działa `sprawdzSubmit`, który wywołuje `preventDefault()`
  (bez przeładowania strony).
- **Dane wejściowe:** produkt, ilość i wiadomość z pól formularza.
- **Obliczenie:** długość wiadomości po `trim()`. Jeśli jest mniejsza niż 10, dane
  są odrzucone. W przeciwnym razie wartość zapytania liczy `obliczCenaGrosze`,
  a `Intl.NumberFormat` formatuje ją jako kwotę w PLN.
- **Zmiana DOM:**
  - wiadomość za krótka: `#podglad` dostaje `hidden`, `#blad-wiadomosc` jest
    pokazany, a fokus trafia na pole wiadomości;
  - wiadomość poprawna: `#podglad-produkt`, `#podglad-ilosc`, `#podglad-wartosc`
    i `#podglad-wiadomosc` są wypełniane przez `textContent` (dzięki temu wpisany
    HTML, np. `<b>Test</b>`, jest wyświetlony jako zwykły tekst), a `#podglad`
    jest odsłaniany;
  - po poprawieniu wiadomości (`input` na `#input-wiadomosc`) funkcja `poprawBlad`
    ukrywa komunikat błędu, gdy wiadomość ma co najmniej 10 znaków po `trim()`.

### 3. Zegar

- **Przy ładowaniu strony:** skrypt sprawdza, czy na stronie są elementy zegara
  (`#obecna-data`, `#obecny-czas`, `#zegar-start`, `#zegar-stop`). Jeśli tak,
  tworzy dwa formattery `Intl.DateTimeFormat` dla `pl-PL` (data oraz godzina
  z sekundami) i od razu wywołuje `zegarStart()`.
- **Start:**
  - **Zdarzenie:** kliknięcie `#zegar-start` (`click`) lub start przy ładowaniu strony.
  - **Dane wejściowe:** zmienna `idInterval`. Wartość `null` oznacza, że zegar nie działa.
  - **Obliczenie:** jeśli `idInterval` nie jest `null`, funkcja kończy się (kolejne
    kliknięcia nie tworzą nowych interwałów). W przeciwnym razie `aktualizujDate()`
    pobiera `new Date()` i formatuje datę oraz czas, a `setInterval` powtarza to
    co 1000 ms. Zwrócony identyfikator trafia do `idInterval`.
  - **Zmiana DOM:** `#obecna-data` i `#obecny-czas` dostają nowy tekst przez
    `textContent` co sekundę.
- **Stop:**
  - **Zdarzenie:** kliknięcie `#zegar-stop`.
  - **Dane wejściowe:** zapisany `idInterval`.
  - **Obliczenie:** `clearInterval(idInterval)` zatrzymuje odliczanie, a
    `idInterval` wraca do `null`, więc kolejny Start znów jest możliwy.
  - **Zmiana DOM:** tekst zostaje na ostatnio pokazanej godzinie. Po ponownym
    Start od razu pojawia się aktualny czas.

### 4. Wyszukiwarka katalogu

- **Zdarzenie:** `input` na `#katalog-search`, czyli każda zmiana tekstu w polu.
  Obsługuje ją `filtruj`.
- **Dane wejściowe:** wpisany tekst (`wyszukiwarka.value`) po `trim()` i
  `toLowerCase()` oraz wszystkie karty `.karta` (zebrane raz przy ładowaniu
  przez `querySelectorAll`).
- **Obliczenie:** dla każdej karty z `<h2>` pobierana jest nazwa zamieniona na
  małe litery. Sprawdzam `nazwa.includes(wpisanyTekst)`. Dzięki `trim()` i
  `toLowerCase()` wyszukiwanie ignoruje spacje na brzegach i wielkość liter.
  Licznik `wyniki` rośnie przy każdej pasującej karcie.
- **Zmiana DOM:**
  - `karta.hidden = !pasuje`: pasujące karty są widoczne, reszta ukryta;
  - `#licznik` pokazuje `Pasujące wyniki: N` (przy pustym polu tekst jest pusty);
  - `#brak-wynikow` jest ukryty, gdy `wyniki !== 0`, a widoczny, gdy nic nie
    pasuje. Wyczyszczenie pola sprawia, że każda nazwa zawiera pusty tekst, więc
    wszystkie karty wracają.
