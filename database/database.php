<?php
//conexion a la base de datos lenault
class DataBase{
    public static function connect($host='localhost',$user='root',$pass='',$db='lenault'){
        $con= new mysqli($host,$user,$pass,$db);
        if($con==false){
            die('error al conectar a la base de datos!!');

        }else{
            return $con;
        }
    }
}

?>