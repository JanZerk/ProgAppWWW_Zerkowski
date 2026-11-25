<?php

session_start(); 

require_once __DIR__ . '/includes/produkty.php';

$filtr = $_GET['kategoria'] ?? 'wszystkie';
$komunikatFiltr = '';
$komunikatProdukt = '';
$komunikatSesja = '';

if($filtr == ''){
	$filtr = 'wszystkie';
}
elseif (!in_array($filtr, ['wszystkie', 'ksiazki', 'akcesoria'])) {
    $filtr = 'wszystkie';
    $komunikatFiltr = "Nieprawidłowa kategoria, wyświetlono pełną listę.";
}


if (isset($_POST['produkt'])) {
    $produkt = $_POST['produkt'];
    $ilosc = $_POST['ilosc'];
    $stan = null; 

    if (filter_var($produkt, FILTER_VALIDATE_INT) === false) {
        http_response_code(400);
        $komunikatProdukt = "Podano błędne dane dla id produktu";
    }
    elseif (filter_var($ilosc, FILTER_VALIDATE_INT) === false) {
        http_response_code(400);
        $komunikatProdukt = "Podano błędne dane dla ilości produktu";
    }
    elseif ($ilosc < 1 || $ilosc > 5) {
        http_response_code(400);
        $komunikatProdukt = "Ilość musi być z zakresu 1-5";
    }
    else {
        foreach($produkty as $p){
            if($p['id'] == $produkt){
                $stan = $p['stan'];
                break;
            }
        }

        if ($ilosc > $stan) {
            http_response_code(400);
            $komunikatProdukt = "Ilość przekracza stan produktu";
        }
        else{
            $_SESSION['ostatni_wybor'] = ['id' => $produkt, 'ilosc' => $ilosc];
            header('Location: lab4.php', true, 303);
            exit;
        }
    }
}
if(isset($_SESSION['ostatni_wybor'])){
    $wybor = $_SESSION['ostatni_wybor'];
    $nazwa = null;
    foreach($produkty as $p){
        if($p['id'] == $wybor['id']){
            $nazwa = $p['nazwa'];
            break;
        }
    }
    if ($nazwa !== null) {
        $komunikatSesja = "Ostatni wybór: " . htmlspecialchars($nazwa, ENT_QUOTES, 'UTF-8') . ", ilość: " . $wybor['ilosc'];
    } else {
        $komunikatSesja = "Zapisany produkt nie istnieje  w katalogu.";
    }
} else {
    $komunikatSesja = "Brak zapisanego wyboru.";

}

$tytul = "Katalog PHP";
$grupa = "A"; 
echo "<link rel='stylesheet' href='css/style.css'>";
echo "<h1>$tytul</h1>";
echo "<p>Identyfikator grupy: $grupa</p>";
echo "<a href='index.php'>Strona główna</a>";
echo "<a href='lab4.php'> Katalog php</a>";

include __DIR__ . '/includes/naglowek.php';

echo "<h2> Produkty </h2>";

echo "<form action='lab4.php' method='get'>";
echo "<label for='kategoria'>Kategoria:</label> ";
echo "<input type='text' name='kategoria' id='kategoria'>";

echo "<button type='submit'>Filtruj</button>";
echo "</form>";

echo "<p>$komunikatFiltr</p>";

echo "<ul>";
$i = 0;
while ($i < count($produkty)) {
    $produkt = $produkty[$i];

    if ($filtr === 'wszystkie' || $produkt['kategoria'] === $filtr) {
        if ($produkt['stan'] == 0) {
            $stan = "Niedostępny";
        } elseif ($produkt['stan'] <= 5) {
            $stan = "Niski stan";
        } else {
            $stan = "Dostępny";
        }

        switch ($produkt['kategoria']) {
            case 'ksiazki':
                $etykieta = "Książki";
                break;
            case 'akcesoria':
                $etykieta = "Akcesoria";
                break;
            default:
                $etykieta = "Inne";
                break;
        }

        echo "<li>" . htmlspecialchars($produkt['nazwa'], ENT_QUOTES, 'UTF-8') . " (" . $etykieta . ") : " . $stan . "</li>";
    }
    $i++;
}
echo "</ul>";

echo "<form action='lab4.php' method='post'>";
echo "<p>$komunikatProdukt</p>";
echo "<label for='produkt'>Produkt</label>";
echo "<select name='produkt' id='produkt'>";
foreach ($produkty as $p) {
    echo "<option value='" . $p['id'] . "'>" . htmlspecialchars($p['nazwa'], ENT_QUOTES, 'UTF-8') . "</option>";
}
echo "</select> ";
echo "<label for='ilosc'> Ilość </label>";
echo "<select name='ilosc' id='ilosc'>";
for ($i = 1; $i <= 5; $i++) {
    echo "<option value='$i'>$i</option>";
}
echo "</select>";
echo "<button type='submit'>Wybierz</button>";
echo "<p>$komunikatSesja</p>";
echo "</form>";