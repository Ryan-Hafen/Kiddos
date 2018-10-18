<?php    
    $dsn = 'mysql:host=localhost;dbname=ryanhaf1_scripture_journal';
    $username = 'ryanhaf1_root';
    $password = '3@bby@llieConnor';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../errors/database_error.php');
        exit();
    }
?>