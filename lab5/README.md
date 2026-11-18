# Laboratorium 5: PHP: szablon i dynamiczne podstrony


## Uruchomienie projektu

1. Zainstaluj XAMPP.
2. Skopiuj folder projektu do katalogu `htdocs`, np. `C:\\xampp\\htdocs\\lab4`.
3. W panelu XAMPP uruchom moduł **Apache**.
4. Otwórz w przeglądarce `http://localhost/lab5/`.

Jeśli Apache działa na innym porcie, dopisz go do adresu, np. `http://localhost:8080/lab5/`.

## Pseudokod wyboru widoku

```

$idp = Pobierz klucz widoku z URL, w przypadku braku klucza, ustaw klucz na 'glowna'
JEŻELI klucz == ''
	klucz = 'glowna'

$widoki = TABLICA[klucz => (tytuł, plik)]

JEŻELI $idp nie jest stringiem LUB nie ma kluczu w $widoki takim jak $idp
	ustaw HTTP 404
	wyświetl komunikat 'Nie znaleziono podstrony' i podaj link do strony głównej
	ZAKOŃCZ PROGRAM

$plik = KATALOG/pobierz wartość 'plik' z $widoki o kluczu równym $idp
JEŻELI $plik nie jest plikiem LUB nie można odczytać $plik
	ustaw HTTP 500
	wyświetl komunikat 'Błąd po stronie serwera' i podaj link do strony głównej
	ZAKOŃCZ PROGRAM
		
```
## Wyniki prób

| Próba | Kroki | Oczekiwany wynik | Rzeczywisty wynik |
|---|---|---|---|
| Adres domyślny i menu | Otwórz `index.php` i `index.php?idp=`, kliknij kolejne odnośniki w menu | `index.php` i `index.php?idp=` pokazują stronę główną. Odnośniki otwierają właściwe treści ze wspólnym szablonem i poprawnym tytułem. | Oba adresy pokazują stronę główną. Odnośniki otwierają właściwe treści ze wspólnym szablonem i poprawnym tytułem. |
| Nieznany lub tablicowy klucz | Otwórz `?idp=nieznana` i `?idp[]=filmy` | Oba adresy dają HTTP 404 i odnośnik powrotny, bez ostrzeżeń PHP. | Oba adresy zwracają HTTP 404 z odnośnikiem powrotnym. PHP nie wyświetla żadnych ostrzeżeń. |
| Próba podania ścieżki | Otwórz `?idp=..%2Fstatus.php` | HTTP 404. Zawartość `status.php` nie zostaje dołączona. | Serwer zwraca HTTP 404, a zawartość `status.php` nie jest dołączona. |
| Brak pliku widoku | Tymczasowo zmień nazwę `html/filmy.html`, otwórz `?idp=filmy`, potem przywróć plik | `?idp=filmy` zwraca HTTP 500 bez ujawnienia ścieżki systemowej. | Serwer zwraca HTTP 500, w komunikacie nie ma ścieżki systemowej. Po przywróceniu pliku strona działa. |
| Strona główna i AJAX | Otwórz stronę główną z panelem Network | Działają style, grafiki i animacje. W Network widać udane żądanie do `status.php`, a na stronie jego wynik. | Style, grafiki i animacje działają. Żądanie do `status.php` kończy się sukcesem, a jego wynik jest widoczny na stronie. |
| Katalog i sesja po migracji | Otwórz katalog z menu, użyj filtra, wróć na stronę główną, otwórz Filmy i ponownie wejdź do katalogu | W Network POST 303, potem GET 200. Zapisany wybór nadal jest widoczny. | W Network są kody POST 303 i GET 200. Zapisany wybór jest nadal widoczny po powrocie do katalogu. |
| Filmy i układ mobilny | Uruchom trzy filmy, sprawdź odnośniki, ustaw szerokość 360 px | Trzy filmy można uruchomić, odnośniki działają, a przy 360 px nie ma przewijania poziomego. | Wszystkie trzy filmy się uruchamiają, odnośniki działają, a przy 360 px strona nie przewija się w poziomie. |



