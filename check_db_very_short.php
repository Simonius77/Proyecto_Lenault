<?php
header('Content-Type: text/plain');
$c = new mysqli('localhost', 'root', '');
if (!$c->connect_error && $c->select_db('lenault')) {
    foreach (['producto', 'usuario'] as $tbl) {
        $cols = [];
        $desc = $c->query("DESCRIBE `$tbl`");
        if ($desc) {
            while ($col = $desc->fetch_assoc()) {
                $cols[] = $col['Field'] . " " . $col['Type'] . ($col['Key'] ? " (".$col['Key'].")" : "");
            }
            echo "Table: $tbl\n  Columns: " . implode(', ', $cols) . "\n\n";
        } else {
            echo "Table: $tbl does not exist!\n\n";
        }
    }
}
?>
