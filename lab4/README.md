# Laboratorium 4: PHP, formularze i sesja


## Uruchomienie projektu

1. Zainstaluj XAMPP.
2. Skopiuj folder projektu do katalogu `htdocs`, np. `C:\xampp\htdocs\lab4`.
3. W panelu XAMPP uruchom moduł **Apache**.
4. Otwórz w przeglądarce `http://localhost/lab4/`.

Jeśli Apache działa na innym porcie, dopisz go do adresu, np. `http://localhost:8080/lab4/`.


## Pseudokody

### Formularz GET (filtr)

```
filtr = $_GET['kategoria'] lub 'wszystkie' gdy brak parametru
komunikatFiltr = ''

JEŻELI filtr == ''
    filtr = 'wszystkie'
W PRZECIWNYM WYPADKU JEŻELI filtr nie jest jednym z ['wszystkie', 'ksiazki', 'akcesoria']
    filtr = 'wszystkie'
    komunikatFiltr = "Nieprawidłowa kategoria, wyświetlono pełną listę."
```

- **Poprawne:** `GET kategoria=ksiazki` → filtr jest na liście → tylko książki, HTTP 200, bez komunikatu.
- **Błędne:** `GET kategoria=abc` → filtr spoza listy → pełna lista, HTTP 200, komunikat „Nieprawidłowa kategoria, wyświetlono pełną listę."

### Formularz POST (zapis wyboru)

```
JEŻELI istnieje $_POST['produkt']
    produkt = $_POST['produkt']
    ilosc = $_POST['ilosc'] lub '' gdy brak
    stan = null

    JEŻELI produkt nie jest liczbą całkowitą
        ustaw HTTP 400, komunikat "błędne id produktu"
    W PRZECIWNYM WYPADKU JEŻELI ilosc nie jest liczbą całkowitą
        ustaw HTTP 400, komunikat "błędna ilość"
    W PRZECIWNYM WYPADKU JEŻELI ilosc < 1 LUB ilosc > 5
        ustaw HTTP 400, komunikat "ilość spoza zakresu 1-5"
    W PRZECIWNYM WYPADKU
        stan = stan produktu z katalogu o id == produkt (lub null, gdy brak)

        JEŻELI stan == null
            ustaw HTTP 400, komunikat "nie ma takiego produktu"
        W PRZECIWNYM WYPADKU JEŻELI ilosc > stan
            ustaw HTTP 400, komunikat "ilość przekracza stan"
        W PRZECIWNYM WYPADKU
            zapisz w sesji ostatni_wybor = {id: produkt, ilosc: ilosc}
            wyślij przekierowanie 303 do lab4.php
            zakończ skrypt
```

- **Poprawne:** `POST produkt=2, ilosc=3` → walidacje przechodzą → zapis do sesji → 303 → `GET lab4.php` → widok pokazuje „Ostatni wybór: nazwa, ilość 3".
- **Błędne:** `POST produkt=2, ilosc=9` → 400 i komunikat → bez zapisu i bez przekierowania → widok pokazuje komunikat błędu i poprzedni wybór.

## Wyniki prób

| Próba | Kroki | Oczekiwany wynik | Rzeczywisty wynik |
|---|---|---|---|
| Filtr GET | Otwórz `lab4.php?kategoria=ksiazki`, potem `?kategoria=abc` i `?kategoria[]=ksiazki` | `?kategoria=ksiazki` pokazuje tylko książki. Nieznana kategoria lub `?kategoria[]=ksiazki` pokazuje pełną listę i komunikat. | Książki są filtrowane poprawnie. Dla błędnych danych pojawia się komunikat i pełna lista. |
| Poprawny POST i odświeżenie | Wybierz dostępny produkt i poprawną ilość, kliknij „Wybierz", naciśnij F5, zmień filtr | W Network widać POST 303, potem GET 200. Po odświeżeniu i zmianie filtra zapisany wybór pozostaje widoczny. | W Network są odpowiednie kody. Po odświeżeniu i zmianie filtra wybór pozostaje widoczny. |
| Błędne wartości POST | W Inspektorze zmień wartość opcji ilości na `0`, `6`, `2.5`, `2abc`; usuń atrybut `name`; dopisz `[]` do nazwy pola; podaj nieznane id produktu | Każda próba daje HTTP 400 i pozostawia poprzedni wybór. | Każda próba daje HTTP 400, poprzedni wybór nie ulega zmianie i pojawia się odpowiedni komunikat. |
| Stan magazynowy | Wybierz produkt ze stanem 1 i ilość 2 | Serwer odrzuca wybór (HTTP 400), mimo że 2 mieści się w przedziale 1–5. | Serwer odrzuca próbę z kodem HTTP 400. |
| Odrębna sesja i tekst HTML | Otwórz `lab4.php` w oknie prywatnym. Zmień nazwę produktu na `<b>Test</b>`, odśwież, przywróć zwykłą nazwę | W nowej sesji nie ma wyboru. Nazwa `<b>Test</b>` wyświetla się jako tekst. | Nowa sesja nie ma zapisanego wyboru, `<b>Test</b>` wyświetla się jako tekst. |
| Strona po zmianie ścieżek | Otwórz stronę główną i podstrony z `html/` | Działają style, obrazy, linki i funkcje z lab3, w tym animacje i żądanie do `status.php`. | Wszystkie funkcje z lab3 działają poprawnie. |
