<?php
header('Content-Type: text/plain');
$c = new mysqli('localhost', 'root', '');
if (!$c->connect_error && $c->select_db('lenault')) {
    $result = $c->query("SHOW TABLES");
    while ($row = $result->fetch_row()) {
        $tbl = $row[0];
        $cols = [];
        $desc = $c->query("DESCRIBE `$tbl`");
        while ($col = $desc->fetch_assoc()) {
            $cols[] = $col['Field'] . " " . $col['Type'] . ($col['Key'] ? " (".$col['Key'].")" : "");
        }
        echo "Table: $tbl\n  Columns: " . implode(', ', $cols) . "\n\n";
    }
} else {
    echo "DB Connection failed\n";
}
?>
