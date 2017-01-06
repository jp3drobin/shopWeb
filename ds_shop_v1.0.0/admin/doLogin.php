<?php
session_start();
$username=$_POST['username'];
$password=$_POST['password'];
$verify=$_POST['verify'];
$verify1=$_SESSION['verify'];