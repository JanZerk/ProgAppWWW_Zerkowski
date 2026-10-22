1. Struktura

Oczekiwany wynik: brak błędów



Zaobserwowany wynik: Jeden błąd, literówka w label dla textarea id="input-wiadomosc". Literówka została poprawiona. Po za tym Nu Html checker wyświetla następujący komunikat: Trailing slash on void elements has no effect and interacts badly with unquoted attribute values. Jest to informacja o slashach które dodałem na końcu niektórych elementów jak meta czy img które nie spełniały żadnej funkcjonalności ale nie wpływały na działanie kodu. Zostały one usuniętę. 



Po wyłączeniu css strona jest nadal czytelna, a kolejność nagłówków i treści poprawna.



2\. Widoki



Oczekiwany wynik: 1 kolumna dla widoków o szerkości mniejszej niż 768 px, 3 dla pozostałych. Proporcje obrazów i formularzy zachowane niezależnie od rozdzielczości.



Zaobserwowany wynik: W trybie responsywnym 375px x 1280px poprawnie widnieje jedna kolumna na stronie głównej, formularz nie jest ucinany i proporcje obrazów są zachowywane. Na stronie głównej poprawnie pojawiają się 3 kolumny po przekroczeniu granicy 768px szerkości.



3\. Klawiatura


Oczekiwany wynik: Można poruszać się po stronie używając Tab i Shift + Tab, linki można aktywować enterem.



Zaobserwowany wynik: Po stronie można poruszać się klawiaturą, zaznaczony element ma wokół siebie czerwoną obwódkę. Linki można aktywować enterem.



4\. Walidacja



Oczekiwany wynik: Nie będzie możliwe w prowadzenie błędnych danych.



Zaobserwowany wynik: Strona uniemożliwia wprowadzenie błędnych danych, za każdym razem podając odpowiedni komunikat o błędzie. Po wprowadzeniu poprawnych danych otrzymałem url: http://localhost:8000/kontakt.html?email=example%40mail.com\&produkt=produkt1\&ilosc=3\&wiadomosc=Hantel+jest+za+ci%C4%99%C5%BCki.



Widoczne parametry to kolejno email, produkt, ilosc i wiadomosc



5\. Eksperyment



Oczekiwany wynik: Strona nie będzie mogła pobrać maila z formularza, ponieważ nie będzie mogła się do niego odwołać.



Zaobserwowany wynik: Wpisując te same dane co powyżej otrzymujemy następujący url: http://localhost:8000/kontakt.html?produkt=produkt1\&ilosc=3\&wiadomosc=Hantel+jest+za+ci%C4%99%C5%BCki. Tym razem w url nie widnieje pole mail, z uwagi na brak pola "name" mail nie został uznany przy wysyłaniu formularza.



W dev tools, w zakładce Sieć widnieje zapytanie GET pod postacią: http://localhost:8000/kontakt.html?email=example%40mail.com\&produkt=produkt1\&ilosc=3\&wiadomosc=Hantel+jest+za+ci%C4%99%C5%BCki.







