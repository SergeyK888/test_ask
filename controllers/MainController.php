<?php
include_once ROOT.'/models/Main.php';
include_once ROOT.'/components/Pagination.php';

class MainController
{

	/*
	*Главный экшен метод просмотра главной страницы
	*/
	public function actionView($page=1)
	{
		$filter = ['#(\.|\?|!|\(|\)){3,}#',
				   '~(\\\|\*|\?|\[|\?|\]|\(|\\\$|\))~', 
				   '/(<([^>]+)>)/U',
				   '#<script[^>]*>.*?</script>#is',
				   '/(\r\n){3,}/'
		];


		$townName = '';
		//Валидация
		if (isset($_POST['onSubmit'])) {
			$townName = htmlspecialchars(preg_replace($filter, '', trim($_POST['townName'])));
			//Массив с ошибками
			$errors = [];

			//Если пустой инпут
			if (empty($townName)){
				$errors[] = 'Введите название города';
			}
			//Если такой город есть
			if (Main::CheckTown($townName)){
				$errors[] = 'Такой город уже существует в базе';
			}
			//Если нету ошибок добавляем
			if (empty($errors)){
				Main::InsertTown(ucfirst($townName));

				$townName = '';
			}
		}

		//Отображение заголовка на вкладке
		$title = 'Список городов';

		//Создание списка городов (пустой)
		$townList = array();

		//Вызов функции getTownList из модели Main для вывода городов из БД
		$townList = Main::getTownList($page);

		$total = Main::getTotalTowns();
		//Создание обьекта Pagination - постраничная навигация
		$pagination = new Pagination($total, $page, Main::SHOW_BY_DEFAULT, 'page-');

		//Подключение представления
		require_once(ROOT.'/views/main/index.php');

		return true;
	}

	/*
	*Редирект
	*/
	public static function actionStart(){
		$url = '/main';
		header('Location: '.$url);
	}

}