<?php 
function connect(){
    $base = mysqli_connect('localhost','root','2002','ecommerce');
    return $base;
}
?>