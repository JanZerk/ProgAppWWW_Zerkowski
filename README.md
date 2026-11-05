# Laboratorium 3: jQuery, animacje i AJAX

**Wersja jQuery:** 4.0.0

## Uruchomienie projektu

1. Projekt działa na lokalnym serwerze Apache, więc konieczne jest zainstalowanie XAMPP.
2. Przenieś folder projektu (`lab3`) do katalogu `htdocs` w folderze instalacyjnym XAMPP, np. `C:\xampp\htdocs\lab3`.
3. W panelu sterowania XAMPP włącz moduł Apache.
4. W przeglądarce wejdź na `http://localhost/lab3/`. Jeśli Apache działa na innym porcie, dopisz go do adresu (np. `http://localhost:8080/lab3/`).

## Pseudokod

### Przycisk A

    powiekszony = FAŁSZ

    JEŻELI (KLIK na A):
        powiekszony = NIE powiekszony
        PRZERWIJ bieżącą animację A i WYCZYŚĆ kolejkę
        JEŻELI (powiekszony):
            ZWIĘKSZ ROZMIAR DO 240 x 130
        W PRZECIWNYM RAZIE:
            PRZYWRÓĆ ROZMIAR DO 160 x 90

### Przycisk B

    maKursor = FAŁSZ, maFokus = FAŁSZ

    JEŻELI (kursor wszedł na B):       maKursor = PRAWDA
    JEŻELI (kursor opuścił B):         maKursor = FAŁSZ
    JEŻELI (FOKUS z klawiatury na B):  maFokus = PRAWDA
    JEŻELI (B stracił fokus):          maFokus = FAŁSZ

    PO KAŻDEJ ZMIANIE STANU:
        PRZERWIJ bieżącą animację B i WYCZYŚĆ kolejkę
        JEŻELI (maKursor LUB maFokus):
            ZWIĘKSZ ROZMIAR DO 220 x 120
        W PRZECIWNYM RAZIE:
            PRZYWRÓĆ ROZMIAR DO 160 x 90

### Przycisk C

    ileClick = 0

    JEŻELI (KLIK na C):
        JEŻELI (C w trakcie animacji):  ZAKOŃCZ
        JEŻELI (ileClick >= 5):         ZAKOŃCZ
        ileClick = ileClick + 1
        ZWIĘKSZ ROZMIAR DO (160 + 20 * ileClick) x (90 + 10 * ileClick)

## Próby animacji

### Próba 1: Szybkie kliknięcia A

**Kroki**
1. Użytkownik naciska przycisk **A**.
2. Użytkownik klika przycisk **A** szybko dziesięć razy.

**Wynik oczekiwany**
Po resecie i 10 kliknięciach A ma stan bazowy. Po zakończeniu klikania animacje nie odtwarzają zaległej kolejki.

**Wynik rzeczywisty**
Zgodny z oczekiwaniami.

---

### Próba 2: Kursor i fokus B

**Wynik oczekiwany**
Wyjście kursora przy zachowanym fokusie nie zmniejsza obiektu. Utrata obu stanów (kursor poza przyciskiem i brak fokusu) przywraca rozmiar bazowy 160 × 90 px.

**Wynik rzeczywisty**
Zgodny z oczekiwaniami.

---

### Próba 3: Limit i reset C

**Wynik oczekiwany**
Pięć kroków daje 260 × 140 px. Dalsze kliknięcia nie powiększają obiektu. Reset wykonany podczas animacji zeruje stan (160 × 90 px, licznik 0, status "0 na 5 razy"), a C znów przyjmuje kliknięcia.

**Wynik rzeczywisty**
Zgodny z oczekiwaniami.

---

### Próba 4: Klawiatura i ruch

**Wynik oczekiwany**
Tab dociera do przycisków. Enter i Spacja obsługują A, C i reset. Ograniczenie ruchu wyłącza przejścia (zmiany rozmiaru są natychmiastowe), zachowując wszystkie funkcje.

**Wynik rzeczywisty**
Zgodny z oczekiwaniami.

## Próby AJAX

1. **Poprawna odpowiedź:** po kliknięciu „Sprawdź serwer" pojawia się komunikat „PHP działa" ze skryptu `status.php` (kod 200).
2. **Błąd 404:** po zmianie nazwy pliku `status.php` serwer zwraca kod 404, a w obszarze wyniku pojawia się komunikat: `GET http://localhost/lab3/status.php [HTTP/1.1 404 Not Found 4ms]`.
3. **Ograniczona prędkość sieci:** najpierw wyświetla się „Oczekiwanie na odpowiedź serwera...", a po otrzymaniu odpowiedzi komunikat „PHP działa".