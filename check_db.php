<?php
header('Content-Type: text/plain');
$c = new mysqli('localhost', 'root', '');
if ($c->connect_error) {
    echo "Connection failed: " . $c->connect_error . "\n";
} else {
    echo "Connected successfully to MySQL!\n";
    
    // Check if database lenault exists
    $db_selected = $c->select_db('lenault');
    if (!$db_selected) {
        echo "Database 'lenault' does not exist.\n";
    } else {
        echo "Database 'lenault' exists!\n";
        
        // List tables
        $result = $c->query("SHOW TABLES");
        echo "Tables in 'lenault':\n";
        while ($row = $result->fetch_row()) {
            echo "- " . $row[0] . "\n";
            
            // Show structure
            $tbl = $row[0];
            $desc = $c->query("DESCRIBE `$tbl`");
            while ($col = $desc->fetch_assoc()) {
                echo "  * " . $col['Field'] . " (" . $col['Type'] . ")\n";
            }
        }
    }
}
?>
