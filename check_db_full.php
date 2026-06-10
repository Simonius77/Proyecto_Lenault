<?php
header('Content-Type: application/json');
$c = new mysqli('localhost', 'root', '');
if ($c->connect_error) {
    echo json_encode(["error" => $c->connect_error]);
} else {
    $db_selected = $c->select_db('lenault');
    if (!$db_selected) {
        echo json_encode(["error" => "db lenault does not exist"]);
    } else {
        $tables = [];
        $result = $c->query("SHOW TABLES");
        while ($row = $result->fetch_row()) {
            $tbl = $row[0];
            $cols = [];
            $desc = $c->query("DESCRIBE `$tbl`");
            while ($col = $desc->fetch_assoc()) {
                $cols[] = [
                    "field" => $col['Field'],
                    "type" => $col['Type'],
                    "null" => $col['Null'],
                    "key" => $col['Key'],
                    "default" => $col['Default'],
                    "extra" => $col['Extra']
                ];
            }
            $tables[$tbl] = $cols;
        }
        echo json_encode($tables, JSON_PRETTY_PRINT);
    }
}
?>
