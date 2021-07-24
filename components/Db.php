<?php

class Db
{
	/*
	*Подключение к базе данных
	*/
	public static function getConnection()
	{
		//Подключение файла с настройками
		$paramsPath = ROOT.'/config/db_params.php';
		$params = include($paramsPath);

		$dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
		$db = new PDO($dsn, $params['user'], $params['password']);

		return $db;

	}

}