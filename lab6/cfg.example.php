<?php
$dsn = 'mysql:host=exampleHost;port=examplePort;dbname=exampleDataBase;charset=utf8mb4';
$user = 'your user';
$password = 'your password';

try{
	$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}catch{
	error_log($e->getMessage() . "\n", 3 , __DIR__ . "/logs/error.log");
    http_response_code(500);
    echo "Błąd po stronie serwera";
    exit;
}
