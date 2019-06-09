<?php
    $username = "bankroll";
    $password = "B@nkr0l1";
    $db = new PDO("pgsql:host=localhost;port=5432;dbname=bankroll", $username, $password, array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
    ));

?>