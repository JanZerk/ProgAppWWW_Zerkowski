# Laboratorium 6: PHP i baza danych w prostym CMS

## Uruchomienie projektu

1. Zainstaluj XAMPP.
2. Skopiuj folder projektu do katalogu `htdocs`, np. `C:\xampp\htdocs\lab6`.
3. W panelu XAMPP uruchom moduł **Apache**.
4. W panelu XAMPP uruchom moduł **MySQL**.
5. Otwórz w przeglądarce `http://localhost/lab6/`.

Jeśli Apache działa na innym porcie, dopisz go do adresu, np. `http://localhost:8080/lab6/`.

## Odtworzenie bazy danych

1. Otwórz w przeglądarce `http://localhost/phpmyadmin`
2. Utwórz bazę danych **moja_strona** za pomocą kodu w `sql\schema.sql`
3. W bazie moja_strona utwórz tabele **page_list** za pomocą kodu w `sql\seed.sql`
4. Utwórz lokalnego użytkownika z dostępem SELECT do page_list.
5. Utwórz plik konfiguracyjny cfg.php na podstawie schematu z cfg.example.php, podstaw swoje dane.

## Pseudokod odczytu strony

```
WYKONAJ ZAPYTANIE DO BAZY DANYCH (Próba połączenia)

$dsn = informacje o połączeniu
$user = login użytkownika
$password = hasło do bazy danych

SPRÓBUJ
    $pdo = NOWE PDO($dsn, $user, $password)
    USTAW dla $pdo PDO::ATTR_ERRMODE na PDO::ERRMODE_EXCEPTION
    USTAW dla $pdo PDO::ATTR_EMULATE_PREPARES na false
ZŁAP BŁĄD BAZY DANYCH
    ZAPISZ w logach błąd
    Odpowiedź http 500
    Podaj komunikat
    ZAKOŃCZ PROGRAM


WYKONAJ ZAPYTANIE DO BAZY DANYCH (Pobierz dane do pokazania podstrony)

$alias = POBIERZ idp z url, jeżeli brak, ustaw na 'glowna'

JEŻELI $alias = ''
    $alias = 'glowna'

SPRÓBUJ
    $pobierzRekord = zapytanie sql o id, page_title i page_content z page_list gdzie alias = :alias(placeholder) i status = 1, pobierz tylko 1 zapytanie.
    Pobierz dane z $pobierzRekord gdzie 'alias' = $alias
    $rekord = zapisz wartości z $pobierzRekord
ZŁAP BŁĄD BAZY DANYCH
    ZAPISZ w logach błąd
    Odpowiedź http 500
    Podaj komunikat
    ZAKOŃCZ PROGRAM
```

## Wyniki prób

| Próba | Kroki | Oczekiwany wynik | Rzeczywisty wynik |
|---|---|---|---|
| Odczyt i aktualizacja treści | Otwórz `index.php` i `?idp=`, zmień treść w phpMyAdmin i odśwież stronę | `index.php` i `?idp=` otwierają `glowna` z HTTP 200. Zmień treść w phpMyAdmin: po odświeżeniu widać zmianę bez edycji plików PHP i HTML. | Oba adresy otwierają `glowna` z HTTP 200. Po zmianie treści w phpMyAdmin i odświeżeniu widać zmianę bez edycji plików PHP i HTML. |
| Nowa strona i menu | Dodaj w bazie opublikowany rekord z nowym aliasem, odśwież stronę i kliknij nowy link w menu | Dodaj opublikowany rekord z nowym aliasem. Link pojawia się w menu i otwiera stronę bez zmiany kodu PHP. Aktywny link jest oznaczony. | Link z nowym aliasem pojawia się w menu i otwiera stronę bez zmiany kodu PHP. Aktywny link jest oznaczony. |
| Szkic i publikacja | Ustaw rekordowi status 0, sprawdź menu i bezpośredni adres, zmień status na 1, spróbuj dodać rekord z identycznym aliasem | Rekord ze statusem 0 znika z menu, a jego bezpośredni adres zwraca 404. Po zmianie statusu na 1 jest widoczny. Próba dodania identycznego aliasu jest odrzucana przez bazę. | Rekord ze statusem 0 znika z menu, a jego bezpośredni adres zwraca 404. Po zmianie statusu na 1 rekord jest widoczny. Próba dodania identycznego aliasu zostaje odrzucona przez bazę. |
| Błędne dane w adresie | Otwórz `?idp=nieznana`, `?idp[]=filmy`, `?idp=../cfg.php` oraz `?idp=' OR 1=1--` | `?idp=nieznana` i `?idp[]=filmy` dają 404. Jako `idp` sprawdź też `../cfg.php` oraz tekst `' OR 1=1--`. Każda próba daje 404 bez ostrzeżeń PHP. | Każda z prób (`?idp=nieznana`, `?idp[]=filmy`, `../cfg.php` i `' OR 1=1--`) zwraca 404. PHP nie wyświetla żadnych ostrzeżeń. |
| Awaria bazy | Tymczasowo ustaw błędny port w konfiguracji, otwórz stronę, sprawdź lokalny log, przywróć port | Ustaw tymczasowo błędny port w konfiguracji. Strona zwraca 500 bez szczegółów technicznych, a lokalny log pozwala ustalić przyczynę. | Strona zwraca 500 bez szczegółów technicznych, a lokalny log pozwala ustalić przyczynę awarii. Po przywróceniu portu strona działa. |
| Funkcje po migracji | Sprawdź style, obrazy, animacje i AJAX, uruchom trzy filmy, użyj filtra w katalogu (panel Network), przejdź między podstronami | Działają style, obrazy, animacje, AJAX i trzy filmy. Katalog filtruje produkty i zapisuje wybór: POST 303, potem GET 200. Wybór pozostaje po przejściu między podstronami. | Style, obrazy, animacje, AJAX i trzy filmy działają. Katalog filtruje produkty i zapisuje wybór: w Network widać POST 303, potem GET 200. Wybór pozostaje po przejściu między podstronami. |
| Odtworzenie środowiska | Utwórz pustą bazę testową, zaimportuj schemat i dane, uzupełnij lokalną konfigurację, uruchom projekt według README | Utwórz pustą bazę testową. Zaimportuj schemat i dane, uzupełnij lokalną konfigurację. Projekt uruchamia się zgodnie z README, także z polskimi znakami. | Po imporcie schematu i danych do pustej bazy testowej oraz uzupełnieniu lokalnej konfiguracji projekt uruchamia się zgodnie z README. Polskie znaki wyświetlają się poprawnie. |
