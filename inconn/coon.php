<?Php
$local = "localhost";
$name = "root";
$pass = "";
$namedatabases = "library";

$connect = mysqli_connect($local , $name , $pass , $namedatabases);

if(!$connect){
    dir("Erroe to connect DataBase : ") ;
}else{
    return $connect;
}

?>