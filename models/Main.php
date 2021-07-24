<?php

class Main
{
	const SHOW_BY_DEFAULT = 5;

	/*
	*Возвращает все города с лимитом SHOW_BY_DEFAULT
	*/
	public static function getTownList($page=1)
	{
		$page = intval($page);
		$offset = ($page - 1) * self::SHOW_BY_DEFAULT;

		$db = Db::getConnection();
		$townList = array();
		$result = $db->query('SELECT * FROM `towns` ORDER BY `id` DESC LIMIT '.self::SHOW_BY_DEFAULT.' OFFSET '.$offset);

		$i = 0;
		while($row = $result->fetch()) {
			$townList[$i]['id'] = $row['id'];
			$townList[$i]['name'] = $row['name'];
			$i++;
		}

		return $townList;
	}
	/*
	*Проверяет есть в БД такой же город который хочет добавить пользователь
	*/
	public static function CheckTown($townName)
	{
		$db = Db::getConnection();

		$sql = 'SELECT COUNT(*) FROM `towns` WHERE `name` = :townName';

		$result = $db->prepare($sql);
		$result->bindParam(':townName', $townName, PDO::PARAM_STR);
		$result->execute();

		if ($result->fetchColumn()) {
			return true;
		}

		return false;
	}
	/*
	*Добавляет проверенный валидацией город в БД
	*/
	public static function InsertTown($townName, $id=NULL)
	{
		$db = Db::getConnection();

		$sql = ' INSERT INTO `towns` (id, name) VALUES (:id, :townName)';

		$result = $db->prepare($sql);
		$result->bindParam(':id', $id, PDO::PARAM_STR);
		$result->bindParam(':townName', $townName, PDO::PARAM_STR);

		$result->execute();
	}
	/*
	*Возвращает общее кол-во городов в БД
	*/
	public static function getTotalTowns()
	{
		$db = Db::getConnection();

		$sql = ' INSERT INTO `towns` (id, name) VALUES (:id, :townName)';

		$result = $db->query('SELECT COUNT(*) AS count FROM `towns`');
		$result->setFetchMode(PDO::FETCH_ASSOC);
		$row = $result->fetch();

		return $row['count'];
	}
}