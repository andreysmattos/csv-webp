<?php

//$banco = new \PDO("mysql: host=localhost; dbname=andreyjoomla; charset=utf8", 'root','');

function limpaString($str) { 
	$str = preg_replace('/[áàãâä]/ui', 'a', $str);
	$str = preg_replace('/[éèêë]/ui', 'e', $str);
	$str = preg_replace('/[íìîï]/ui', 'i', $str);
	$str = preg_replace('/[óòõôö]/ui', 'o', $str);
	$str = preg_replace('/[úùûü]/ui', 'u', $str);
	$str = preg_replace('/[ç]/ui', 'c', $str);
	return $str;
}



$arquivo = fopen('email_senha.csv', 'r');

$contador = 0;

while(($linha = fgetcsv($arquivo)) !== false){	
	$andrey[$contador] = $linha;

	$nome = explode(' ', $linha[0]);
	$senha = $nome[0] . '2018';

	$andrey[$contador++]['senha'] = limpaString(strtolower($senha));
}

unset($andrey[0]);


jimport('joomla.user.helper');

foreach ($andrey as $key => $value) {
	set_time_limit(60);
	$data = array(
		"name"=>$value[0],
		"username"=>$value[1],
		"password"=>$value['senha'],
		"password2"=>$value['senha'],
		"email"=>$value[1],
		"block"=>0,
		"groups"=>array("2")
	); 
	$user = new JUser;
		//Grava no database
	if(!$user->bind($data)) {
		throw new Exception("Erro: " . $user->getError());
	}
	if (!$user->save()) {
		throw new Exception("Erro: " . $user->getError());
	}
}




?>