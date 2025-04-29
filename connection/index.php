<?php
$connection = new mysqli("app-peoplemarketing.ckkjycussdkq.us-east-1.rds.amazonaws.com", "apppeopl_bjimenez", "90#2B@j*g7r9", "apppeopl_corporativo_overall");
if ($connection->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $connection->connect_errno . ") " . $connection->connect_error;
}