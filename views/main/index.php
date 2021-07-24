<!-- Подключение Header с настройками -->
<?php include ROOT.'/layouts/header.php'; ?>


<div class="card m-2 p-3 bg-dark text-white">
	<label>Добавить город</label>


<!--Вывод ошибки валидации или успешного добавления в БД -->
<? if (isset($_POST['onSubmit'])):?>
	<? if(!empty($errors)):?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
		  <? echo $errors[0]; ?>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
	<? else:?>
		<div class="alert alert-success alert-dismissible fade show" role="alert">
		  Город добавлен в базу данных
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
	<? endif;?>
<? endif;?>


<!-- Форма отправки имени города -->
	<form action="/main/page-1" method="POST">
		<input type="text" name="townName" value="<? echo $townName; ?>">
		<button class="btn-info" type="submit" name="onSubmit">Добавить</button>
	</form>
</div>


<!--Вывод списка городов с параметрами пагинации -->
<div class="list-group m-2 p-3">
  <a href="#" class="list-group-item list-group-item-action active">
   	Список городов из базы данных
  </a>
	<? foreach($townList as $town):?>
		<a href="#" class="list-group-item list-group-item-action"><? echo '<p class="text-danger">№ в Базе:'.$town['id'].'</p> Город - «'.$town['name']; ?>»</a>
	<? endforeach; ?>
</div>



<!-- Блок с кнопками пагинации -->
<div class="d-flex justify-content-center">
	<nav aria-label="...">
	  <?php echo $pagination->get(); ?>
	</nav>
</div>


<!-- Подключение футера с настройками-->
<? include ROOT.'/layouts/footer.php';?> 