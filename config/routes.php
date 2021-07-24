<?php
//Маршруты обработтки контроллеров и экшенов
return array(
	'main/page-([0-9]+)' => 'main/view/$1',
	'main' => 'main/view',
	'' => 'main/start'
);