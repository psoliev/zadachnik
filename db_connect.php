<?php 

$conn = new mysqli('localhost','user','123','zadachnik') or die("Could not connect to mysql".mysqli_error($con));
$conn->query('set charset utf8');
