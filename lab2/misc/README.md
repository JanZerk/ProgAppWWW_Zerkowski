W celu uruchomienia należy uruchomić wiersz poleceń Windows, w katalogu głównym projektu należy uruchomić serwer lokalny komendą python -m http.server 8000. W url przeglądarki wpisać http://localhost:8000/.



Opis przykładowego przepływu:

Zdarzenie: Użytkownik wysyła formularz używając przycisku "Sprawdź zapytanie". Uruchamia się 'submit' na '#formularz-kontakt, najpierw przeglądarka sprawdza ograniczenia HTML, potem działa 'sprawdzSubmit', który wywołuje 'preventDefault()' (bez przeładowania strony)

Dane wejściowe: Produkt, ilość i wiadomość z pól formularza

Obliczenie: Sprawdzana jest długość wiadomości po '.trim()', jeżeli jest mniejsza niż 10, dane są odrzucone. Obliczana jest wartość produktów za pomocą funkcji obliczCeneGrosz(cenaGrosz, ilosc) i aktualizujWartosc().

Zmiana DOM:

\- wiadomość za krótka: 'id=podglad' dostaje 'hidden', 'id=blad-wiadomosc' jest pokazany, a fokus trafia na pole wiadomości;

\- wiadomość poprawna: '#podglad-produkt, -ilosc, -wartosc, -wiadomosc' są wypełniane przez 'textContent' (dzięki temu wpisany HTML, np. '<b>Test</b>', jest wyświetlony jako  zwykły tekst), a '#podglad' jest odsłaniany.



