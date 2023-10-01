<?php
define('HOST','localhost'); //informar endereço do servidor mysql
define('USER','root'); //informar nome de usuário
define('PASS',''); //informar senha do usuário
define('DB','auto_mechanic'); //informar nome do banco de dados.

$con = mysqli_connect("auto-mechanic.mysql.uhserver.com","sofh_suport","Geovana*13022005","auto_mechanic") or die('Incapaz de acessar o banco de dados');
