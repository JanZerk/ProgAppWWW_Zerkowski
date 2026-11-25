<?php

$alias = $_GET['idp'] ?? 'glowna';

if($alias == ''){
    $alias = 'glowna';
}

function PokazPodstrone($pdo, $alias)
{
    try{
        $pobierzRekord = $pdo->prepare(
        'SELECT id, page_title, page_content
         FROM page_list
         WHERE alias = :alias AND status = 1
         LIMIT 1'
    );
    $pobierzRekord->execute(['alias' => $alias]);

    $rekord = $pobierzRekord->fetch();

    }catch(PDOException $e) {
        error_log($e->getMessage() . "\n", 3 , __DIR__ . "/logs/error.log");
        http_response_code(500);
        echo "Błąd po stronie serwera";
        exit;
}
    

    return $rekord === false ? null : $rekord;
}

try{
    $pobierzMenu = $pdo->prepare('SELECT alias, page_title FROM page_list WHERE status = 1 ORDER BY id');
    $pobierzMenu->execute();
    $menu = $pobierzMenu ->fetchAll(PDO::FETCH_KEY_PAIR);
}catch(PDOException $e) {
        error_log($e->getMessage() . "\n", 3 , __DIR__ . "/logs/error.log");
    http_response_code(500);
    echo "Błąd po stronie serwera ";
    exit;
}

