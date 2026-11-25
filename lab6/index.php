<?php

require_once __DIR__ . "/cfg.php";
require_once __DIR__ . "/showpage.php";

$projectId = "GymShop";
$idp = $_GET['idp'] ?? 'glowna';

if($idp==''){
    $idp='glowna';
}

if(!is_string($idp)){
        http_response_code(404);
        echo "Nie znaleziono podstrony. <a href=index.php> Strona główna</a>";
        exit;       
}


$strona = PokazPodstrone($pdo, $idp);


if($strona === null || $pdo === null){
        http_response_code(404);
        echo "Nie znaleziono podstrony. <a href=index.php> Strona główna</a>";
        exit;       
}
?>

<!doctype html>
<html lang="pl" data-theme="light">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($strona['page_title'], ENT_QUOTES, 'UTF-8'); ?></title>
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
        <?php foreach ($menu as $alias => $page_title): ?>
        <a href="index.php?idp=<?php echo $alias; ?>"<?php if ($alias === $idp) echo ' aria-current="page"'; ?>>
            <?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?>
        </a>
        <?php endforeach; ?>
        <a href="lab4.php">Katalog PHP</a>
        <a href="admin/admin.php">Panel CMS</a>
        </nav>
        <button type="button" id="zmiana-motywu" aria-pressed="false">Tryb ciemny</button>
    </header>
    <main>
        <?php
        echo $strona['page_content']; 
         ?>
    </main>
    <footer><?php echo "Identyfikator projektu: " . $projectId. " v1.5" ?></footer>
    
</body>

</html>
