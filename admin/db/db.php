<?php

$db=mysqli_connect("localhost","root","","ayurveda"); 

if(!$db){
    die("Connection failed:" . mysqli_connect_error());
}

?>