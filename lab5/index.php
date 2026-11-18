<?php
$projectId = "GymShop";
$idp = $_GET['idp'] ?? 'glowna';
if($idp==''){
    $idp='glowna';
}
$widoki = [
    'glowna'  => ['tytul' => 'Strona główna', 'plik' => 'html/glowna.html'],
    'kontakt' => ['tytul' => 'Kontakt',       'plik' => 'html/kontakt.html'],
    'produkt' => ['tytul' => 'Produkt',       'plik' => 'html/produkt.html'],
    'filmy'   => ['tytul' => 'Filmy',         'plik' => 'html/filmy.html'],
];
if(!is_string($idp) || !isset($widoki[$idp])){
        http_response_code(404);
        echo "Nie znaleziono podstrony. <a href=index.php> Strona główna</a>";
        exit;       
    }
$plik = __DIR__ . '/' . $widoki[$idp]['plik']; 
        if(!is_file($plik) || !is_readable($plik)){
            http_response_code(500);
            echo "Błąd po stronie serwera <a href=index.php>Strona główna</a>";
            exit;
        }

?>

<!doctype html>
<html lang="pl" data-theme="light">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($widoki[$idp]['tytul']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-4.0.0.min.js" defer></script>
    <script src="js/main.js" defer></script>
    <script src="js/lab3.js" defer></script>
</head>

<body>
    <header>
        <h1>Gym Shop</h1>
        <div class="data-czas">
            <p> Data: <span id="obecna-data"></span>, <span id="obecny-czas"></span></p>
            <button type="button" id="zegar-start">Start zegara</button>
            <button type="button" id="zegar-stop">Stop zegara</button></div>
        <nav>
        <?php foreach ($widoki as $klucz => $widok): ?>
        <a href="index.php?idp=<?php echo $klucz; ?>"<?php if ($klucz === $idp) echo ' aria-current="page"'; ?>>
            <?php echo $widok['tytul']; ?>
        </a>
        <?php endforeach; ?>
        <a href="lab4.php">Katalog PHP</a>
        </nav>
        <button type="button" id="zmiana-motywu" aria-pressed="false">Tryb ciemny</button>
    </header>
    <main>
        <?php
        include $plik; 
         ?>
    </main>
    <footer><?php echo "Identyfikator projektu: " . $projectId; ?></footer>
    
</body>

</html>
