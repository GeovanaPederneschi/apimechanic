<?php
define('HOST','localhost'); //informar endereço do servidor mysql
define('USER','root'); //informar nome de usuário
define('PASS',''); //informar senha do usuário
define('DB','servicos_sofh'); //informar nome do banco de dados.

$con = mysqli_connect(HOST,USER,PASS,DB,3309) or die('Incapaz de acessar o banco de dados');
