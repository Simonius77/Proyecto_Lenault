<?php
//conexion a la base de datos lenault
class DataBase
{
    public static function connect($host = 'localhost', $user = 'root', $pass = '', $db = 'lenault')
    {

        // Priorizar variables de entorno para Docker
        $host = getenv('DB_HOST') ?: $host;
        $user = getenv('DB_USER') ?: $user;
        $pass = getenv('DB_PASS') ?: $pass;
        $db = getenv('DB_NAME') ?: $db;

        $con = new mysqli($host, $user, $pass, $db);
        if ($con == false) {
            die('error al conectar a la base de datos!!');

        } else {
            return $con;
        }
    }
}

?>