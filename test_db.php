<?php
$c = new mysqli('localhost', 'root', '');
if ($c->connect_error) {
    echo "Connection failed: " . $c->connect_error . "\n";
} else {
    echo "Connected successfully to MySQL!\n";
    $result = $c->query("SHOW DATABASES");
    echo "Databases:\n";
    while ($row = $result->fetch_assoc()) {
        echo "- " . $row['Database'] . "\n";
    }
}
?>
