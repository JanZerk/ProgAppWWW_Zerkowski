Testy były wykonywane na przeglądarce Firefox w wersji 158.0.1.



Motyw i nawigacja

Oczekiwany wynik: Motyw utrzymuje się po odświeżeniu i zmianie podstrony, aria-pressed odpowiada stanowi

Zaobserwowany wynik: Zgodny z oczekiwaniami



Start trzy razy potem Stop i Start

Oczekiwany wynik: Działa jeden interwał; Stop zatrzymuje aktualizację, wznowienie pokazuje aktualny czas

Zaobserwowany wynik: Literówka `idInterv1al` zamiast `idInterval` – interwał nie był zapisywany, więc Stop nie działał; poprawiłem nazwę zmiennej, po poprawie działa zgodnie z oczekiwaniami



Fragment nazwy ze spacjami i inną wielkością liter

Oczekiwany wynik: Pasujące karty widoczne, licznik zgadza się z widokiem

Zaobserwowany wynik: Zgodny z oczekiwaniami



Brak dopasowania i wyczyszczenie pola

Oczekiwany wynik: Pojawia się komunikat o braku wyników, wyczyszczenie przywraca trzy karty

Zaobserwowany wynik: Zgodny z oczekiwaniami



Cena 1999 gr oraz ilość 3

Oczekiwany wynik: Wynik wynosi 59,97 zł; sprawdź samą funkcję obliczeniową również w konsoli

Zaobserwowany wynik: Zgodny z oczekiwania, funkcja obliczCenaGrosze() w konsoli podaje wynik 5997



lość pusta 0 6 oraz 1,5

Oczekiwany wynik: Wycena nie pokazuje błędnej wartości; formularz nie przechodzi

do poprawnego podsumowania

Zaobserwowany wynik: Zgodny z oczekiwaniami



Dziesięć spacji oraz tekst <b>Test</b>

Oczekiwany wynik: Same spacje są odrzucone; poprawna wiadomość ze znacznikami

jest pokazana jako dosłowny tekst.

Zaobserwowany wynik: Literówka 'prevenDefault', po prawieniu na 'preventDefault' działa zgodnie z oczekiwaniami.



Klawiatura widoki i wyłączony JavaScript

Oczekiwany wynik: Kontrolki działają klawiaturą przy 375 i 1280 px; bez JS katalog, treść i menu pozostają dostępne

Zaobserwowany wynik: Zgodny z oczekiwaniami.







