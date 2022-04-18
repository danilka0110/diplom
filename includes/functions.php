<?php

/**
* распечатка массива
**/

function print_arr($arr){
	echo '<pre>'  . print_r($arr, true) . '</pre>';
}

/**
* получение списка тестов
**/

function get_tests(){
    $data = R::getAll("SELECT * 
		FROM test 
			WHERE enable = '1'");
	if(!$data) return false;
	return $data;
}
function get_popular_tests() {
	$data = R::getAll("SELECT id, test_name, img_link FROM test WHERE enable = '1'
		order by count_passes desc limit 10");
	return $data;
}

function get_tests_for_search($search_data){
    $data = R::getAll("SELECT * 
		FROM `test` 
    		WHERE enable = '1' and (test_name LIKE '%$search_data%' or description LIKE '%$search_data%' or author LIKE '%$search_data%')");
	if(!$data) return false;
	return $data;
}

function get_tests_for_category($category_data) {
    $data = R::getAll("SELECT * 
		FROM test t 
		LEFT JOIN category c 
			ON t.id = c.test_id 
				WHERE enable = '1' and c.category = '$category_data'");
	if(!$data) return false;
	return $data;
}


/**
* получение данных теста
**/

function get_test_data($test_id){
	if(!$test_id) return;
	$query = R::getAll("SELECT q.question, q.test_id, a.id, a.answer, a.question_id
		FROM questions q
		LEFT JOIN answers a
			ON q.id = a.question_id
		LEFT JOIN test
			ON test.id = q.test_id
				WHERE q.test_id = $test_id AND test.enable = '1'");
	$data = null;
    foreach($query as $item) {
        if( !$item['question_id'] ) return false;
		$data[$item['question_id']][0] = $item['question'];
		$data[$item['question_id']][$item['id']] = $item['answer'];
    }
	return $data;
}

function get_test_name($test_id) {
	if (!$test_id) return;
	$query = R::getAll("SELECT t.test_name, t.description, t.img_link, t.author
	FROM test t 
		WHERE t.id = $test_id AND t.enable = '1'");
	return $query;
}

/**
* получение id вопрос/ответ
**/

function get_correct_answers($test){
	if( !$test ) return false;
	$query = R::getAll("SELECT q.id AS question_id, a.id AS answer_id, q.type AS question_type
		FROM questions q
		LEFT JOIN answers a
			ON q.id = a.question_id
		LEFT JOIN test
			ON test.id = q.test_id
				WHERE q.test_id = $test AND a.correct_answer = '1' AND test.enable = '1'");

	$data = null;
    foreach($query as $item) {

		$data[$item['question_id']] = $item['answer_id'];		

    }
	return $data;
}

function get_user_img($user_login){
	$query = R::getAll("SELECT img_link
		FROM users
			WHERE login = '$user_login'");
    foreach($query as $item) {

		$data = $item['img_link'];

    }
	return $data;
}

/**
* строим пагинацию
**/

function pagination($count_questions, $test_data){
	$keys = array_keys($test_data);
	$pagination = '<div class="pagination-block">';
	for($i = 1; $i <= $count_questions; $i++){
		$key = array_shift($keys);
		if( $i == 1 ){
			$pagination .= '<div class="pag first-question" data-question=#question-'.$key.'><a class="pagination-answers nav-active-page first-question" href="#question-' . $key . '">&nbsp' . $i . '&nbsp</a></div>';
		}elseif ( $i == 2 ){
			$pagination .= '<div class="pag next" data-question=#question-'.$key.'><a class="pagination-answers" href="#question-' . $key . '">&nbsp' . $i . '&nbsp</a></div>';
		}elseif ( $i < 10 ){
			$pagination .= '<div class="pag" data-question=#question-'.$key.'><a class="pagination-answers" href="#question-' . $key . '">&nbsp' . $i . '&nbsp</a></div>';
		}else{
			$pagination .= '<div class="pag" data-question=#question-'.$key.'><a class="pagination-answers" href="#question-' . $key . '">' . $i . '</a></div>';
		}
	}

	$pagination .= '</div>';
	$key_next = 2;
	return $pagination;
}

/**
* итоги
* 1 - массив вопрос/ответы
* 2 - правильные ответы
* 3 - ответы пользователя
**/

function get_test_data_result($test_all_data, $result){
	// заполняем массив $test_all_data правильными ответами и данными о неотвеченных вопросах
	foreach($result as $q => $a){
		$test_all_data[$q]['correct_answer'] = $a;
		// добавим в массив данные о неотвеченных вопросах если вдруг такие окажутся
		if( !isset($_POST[$q]) ){
			$test_all_data[$q]['incorrect_answer'] = 0;
		}
	}

	// добавим неверный ответ, если таковой был
	foreach($_POST as $q => $a){
		// удалим из POST то что пользователь писал сам через панель разработчика
		if(!isset($test_all_data[$q])){
			unset($_POST[$q]);
			continue;
		}

		// если есть "левые" значения ответов
		if( !isset($test_all_data[$q][$a]) ){
			$test_all_data[$q]['incorrect_answer'] = 0;
			continue;
		}

		// добавим неверный ответ
		if( $test_all_data[$q]['correct_answer'] != $a ){
			$test_all_data[$q]['incorrect_answer'] = $a;
		}
	}
	return $test_all_data;
}


/**
* печать результатов
**/


function print_result($test_all_data_result, $test_id){
	// переменные результатов
	$all_count = count($test_all_data_result); // кол-во вопросов
	$correct_answer_count = 0; // кол-во верных ответов
	$incorrect_answer_count = 0; // кол-во неверных ответов
	$percent = 0; // процент верных ответов

	// подсчет результатов
	foreach($test_all_data_result as $item){
		if( isset($item['incorrect_answer']) )  {
			$incorrect_answer_count++;
		}
	}

	

	$correct_answer_count = $all_count - $incorrect_answer_count;
	$percent = round( ($correct_answer_count / $all_count * 100), 2);
	$percent_incorrect = round(100 - $percent, 2);
	// вывод результатов
	$print_res = '<div class="test-data">';
	$print_res = '<div class="test-results">';
	$print_res .= '<div class="text-center mb-4 test_ty">';
		$print_res .= '<img src="../img/success_passes.png">';
		$print_res .= '<span>Результат</span>';
	$print_res .= '</div>';
		$print_res .= '<div class="count-res">';

		$print_res .= "<div>";
		

			$print_res .= "<span>Всего вопросов: <b>{$all_count}</b></span>";


		$print_res .= "</div>";
		$print_res .= "<div>";

			$print_res .= "<span>Из них отвечено верно: <b>{$correct_answer_count}</b></span>";


		$print_res .= "</div>";
		$print_res .= "<div>";

			$print_res .= "<span>Из них отвечено неверно: <b>{$incorrect_answer_count}</b></span>";


		$print_res .= "</div>";
		$print_res .= "<div>";

			$print_res .= "<span>Процент верных ответов: <b>{$percent}%</b></span>";

		$print_res .= "</div>";
		$print_res .= "<div>";

			$print_res .= "<span>Процент неверных ответов: <b>{$percent_incorrect}%</b></span>";

		$print_res .= "</div>";


		$print_res .= '</div>';	// .count-res
		$print_res .= '<a class="btn btn-primary mt-2" id="btn-show-results">Показать результат</a>';
		$print_res .= '<a class="btn btn-primary mt-2" id="btn-show-stats">Показать статистику</a>';
		// вывод теста...
		$print_res .= '<div class="test-q-and-a none mt-4">';
		foreach($test_all_data_result as $id_question => $item){ // получаем вопрос + ответы
			$correct_answer = $item['correct_answer'];
			$incorrect_answer = null;
			if( isset($item['incorrect_answer']) ){
				$incorrect_answer = $item['incorrect_answer'];
				$classQ = 'question-res error';
			}else{
				$classQ = 'question-res ok';
			}
			$print_res .= "<div class='$classQ'>";
			foreach($item as $id_answer => $answer){ // проходимся по массиву ответов
				if( $id_answer === 0 ){
					// вопрос
					$print_res .= "<p class='q'>$answer</p>";
				}elseif( is_numeric($id_answer) ){
					// ответ
					if( $id_answer == $correct_answer ){
						// если это верный ответ
						$class = 'a ok2';
					}elseif( $id_answer == $incorrect_answer ){
						// если это неверный ответ
						$class = 'a error2';
					}else{
						$class = 'a';
					}
					if ($class == 'a error2') {
						$print_res .= "<p class='$class'><input type='radio' checked disabled><label style='margin-left: 5px'>$answer</label></p>";
					} else if ($class == 'a ok2' && $classQ == 'question-res ok') {
						$print_res .= "<p class='$class'><input type='radio' checked disabled><label style='margin-left: 5px'>$answer</label></p>";
					} else {
						$print_res .= "<p class='$class'><input type='radio' disabled><label style='margin-left: 5px'>$answer</label></p>";
					}
					
				}
			}
			$print_res .= '</div>'; // .question-res
		}
		$print_res .= '</div>';

		$print_res .= '<div class="stats none mt-4">';
		$query = R::getAll("SELECT correct_score
		FROM usersandtests
			WHERE test_id = '$test_id'");
		
		$count_all = 0;
		foreach($query as $item){
			$qr = $item;
			foreach($qr as $item){
				$correct_score += $item;
				$count_all++;	
			}
		}
		
			$print_res .= '<div style="width: 150px; height: 150px" id="correct_and_incorrect_answers_graph"><canvas id="graph"></canvas></div>';
			$avg_value = round(($correct_score / $count_all),2);
			$print_res .= "<p>Пользователей прошло тест: <b>{$count_all}</b></p>";
			$print_res .= "<p>Средний результат среди всех пользователей: <b>{$avg_value}</b></p>";
			$print_res .= '<div style="width: 260px; height: 160px" id="correct_and_incorrect_answers_graph_second"><canvas id="graph-2"></canvas></div>';
			$print_res .= "<script>
								const data = {
									labels: [
										'Верные ответы',
										'Неверные ответы'
									],
									datasets: [{
										label: 'My First Dataset',
										data: [{$correct_answer_count}, {$incorrect_answer_count}],
										backgroundColor: [
										'rgb(54, 162, 235)',
										'rgb(255, 99, 132)'
										],
										hoverOffset: 4,
										rotation: 180
									}]
								};
								
								
								
								const config = {
									type: 'doughnut',
									data: data,
									options: {
										animations: {
								
										}
									}
								};
								
								const myChart = new Chart(
									document.getElementById('graph'),
									config
								);
								
								
								const data_2 = {
									labels: [
									'Мой результат',
									'Средний результат'
									],
									datasets: [{
										type: 'bar',
										label: 'Результат',
										data: [{$correct_answer_count}, {$avg_value}],
										borderColor: 'rgba(255, 99, 132, 1)',
										backgroundColor: 'rgba(255, 99, 132, 0.3)'
									}, {
										type: 'line',
										label: 'Линия',
										data: [{$correct_answer_count}, {$avg_value}],
										fill: false,
										borderColor: 'rgb(54, 162, 235)'
									}]
								};
								
								
								
								const config_2 = {
									type: 'scatter',
									data: data_2,
									options: {
										scales: {
											y: {
												beginAtZero: true
											}
										}
									}
								};
								
								const myChart_2 = new Chart(
									document.getElementById('graph-2'),
									config_2
								);
								
							</script>";


		$print_res .= '</div>';


	$print_res .= "<div>"; // .test-results
	$print_res .= '</div>'; // .test-data

	return $print_res;
}

function get_test_by_author($user) {
	$query = R::getAll("SELECT t.id, t.test_name, t.description, t.img_link, t.author, t.date, t.count_passes, t.enable
	FROM test t 
		WHERE t.user_id = '$user'
			ORDER BY id DESC");

	return $query;
}

function save_result($test_all_data_result, $test_id, $user, $date) {
	$all_count = count($test_all_data_result); // кол-во вопросов
	$correct_answer_count = 0; // кол-во верных ответов
	$incorrect_answer_count = 0; // кол-во неверных ответов
	$percent = 0; // процент верных ответов

	// подсчет результатов
	foreach($test_all_data_result as $item){
		if( isset($item['incorrect_answer']) )  {
			$incorrect_answer_count++;
		}
	}
	$correct_answer_count = $all_count - $incorrect_answer_count;

	$test_name = get_test_name($test_id);
	foreach($test_name as $item) {
		$test_name = $item['test_name'];
	}

	$users_and_tests = R::findOne('usersandtests', 'user_id = :user_id AND test_id = :test_id', [':user_id' => $user, ':test_id' => $test_id]);
	if ($users_and_tests) {
		$users_and_tests->test_name = $test_name;
		$users_and_tests->correct_score = $correct_answer_count;
		$users_and_tests->incorrect_score = $incorrect_answer_count;
		$users_and_tests->all_count = $all_count;
		$users_and_tests->date = $date;
		R::store($users_and_tests);
	} else {
		$users_and_tests = R::dispense('usersandtests');
		$users_and_tests->user_id = $user;
		$users_and_tests->test_id = $test_id;
		$users_and_tests->test_name = $test_name;
		$users_and_tests->correct_score = $correct_answer_count;
		$users_and_tests->incorrect_score = $incorrect_answer_count;
		$users_and_tests->all_count = $all_count;
		$users_and_tests->date = $date;
		R::store($users_and_tests);
	}
}






function save($test_id, $user) {

	$test_name = get_test_name($test_id);
	foreach($test_name as $item) {
		$test_name = $item['test_name'];
	}


	$users_save_test = R::findOne('usertestresult', 'user_id = :user_id AND test_id = :test_id', [':user_id' => $user->id, ':test_id' => $test_id]);


	if($users_save_test) {
		$query = R::find('usertestresult', 'user_id = :user_id AND test_id = :test_id', [':user_id' => $user->id, ':test_id' => $test_id]);
		R::trashAll($query);
		foreach($_POST as $key => $item) {
			$users_save_test = R::dispense('usertestresult');
			$users_save_test->user_id = $user->id;
			$users_save_test->test_id = $test_id;
			$users_save_test->test_name = $test_name;
			$users_save_test->question_id = $key;
			$users_save_test->answer_id = $item;
		
			R::store($users_save_test);
		}
	} else {
		foreach($_POST as $key => $item) {
			$users_save_test = R::dispense('usertestresult');

			$users_save_test->user_id = $user->id;
			$users_save_test->test_id = $test_id;
			$users_save_test->test_name = $test_name;
			$users_save_test->question_id = $key;
			$users_save_test->answer_id = $item;
		
			R::store($users_save_test);
		}
	}



}











function get_test_data_result_for_user_profile($test_all_data, $result, $user_choice){
	// заполняем массив $test_all_data правильными ответами и данными о неотвеченных вопросах
	foreach($result as $q => $a){
		$test_all_data[$q]['correct_answer'] = $a;
		// добавим в массив данные о неотвеченных вопросах если вдруг такие окажутся
		if( !isset($user_choice[$q]) ){
			$test_all_data[$q]['incorrect_answer'] = 0;
		}
	}

	// добавим неверный ответ, если таковой был
	if($user_choice == null || $user_choice == undefined || empty($user_choice)) return false;
	foreach($user_choice as $q => $a){
		// удалим из POST "левые" значения вопросов
		if(!isset($test_all_data[$q])){
			unset($user_choice[$q]);
			continue;
		}

		// если есть "левые" значения ответов
		if( !isset($test_all_data[$q][$a]) ){
			$test_all_data[$q]['incorrect_answer'] = 0;
			continue;
		}

		// добавим неверный ответ
		if( $test_all_data[$q]['correct_answer'] != $a ){
			$test_all_data[$q]['incorrect_answer'] = $a;
		}
	}
	return $test_all_data;
}




function print_result_for_user_profile($test_all_data_result, $test_id){
	if($test_all_data_result == null || $test_all_data_result == undefined || empty($test_all_data_result)) return false;
	// переменные результатов
	$all_count = count($test_all_data_result); // кол-во вопросов
	$correct_answer_count = 0; // кол-во верных ответов
	$incorrect_answer_count = 0; // кол-во неверных ответов
	$percent = 0; // процент верных ответов

	// подсчет результатов
	foreach($test_all_data_result as $item){
		if( isset($item['incorrect_answer']) )  {
			$incorrect_answer_count++;
		}
	}

	$get_test_data = get_test_name($test_id);
	foreach ($get_test_data as $item) {
		$test_name = $item['test_name'];
		$test_author = $item['author'];
	}
	
	$correct_answer_count = $all_count - $incorrect_answer_count;
	$percent = round( ($correct_answer_count / $all_count * 100), 2);
	$percent_incorrect = round(100 - $percent, 2);
	// вывод результатов
	$print_res = '<div class="test-data">';
	$print_res .= '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
	$print_res .= '<div class="text-center mb-4" style="background: #9ad35f; height: 40px;">';
	$print_res .= '<img src="../img/success_passes.png" style="margin-top: -5px;">';
	$print_res .= '<span style="margin-left: 1%; font-size: 24px; font-family: Georgia, serif;">Результат</span>';
	$print_res .= '</div>';
	$print_res .= "<div>";
		$print_res .= "<span>Название теста: <b>$test_name</b></span>";
	$print_res .= "</div>";
	$print_res .= "<div>";
		$print_res .= "<span>Автор теста: <b>$test_author</b></span>";
	$print_res .= "</div>";


		$print_res .= '<div class="count-res">';

		$print_res .= "<div>";
		

			$print_res .= "<span>Всего вопросов: <b>{$all_count}</b></span>";


		$print_res .= "</div>";
		$print_res .= "<div>";

			$print_res .= "<span>Из них отвечено верно: <b>{$correct_answer_count}</b></span>";


		$print_res .= "</div>";
		$print_res .= "<div>";
	
			$print_res .= "<span>Из них отвечено неверно: <b>{$incorrect_answer_count}</b></span>";


		$print_res .= "</div>";
		$print_res .= "<div>";

			$print_res .= "<span>Процент верных ответов: <b>{$percent}%</b></span>";

		$print_res .= "</div>";
		$print_res .= "<div>";

			$print_res .= "<span>Процент неверных ответов: <b>{$percent_incorrect}%</b></span>";

		$print_res .= "</div>";


		$print_res .= '</div>';	// .count-res
		$print_res .= '<a class="btn btn-primary mt-2" id="btn-show-results">Показать результат</a>';
		$print_res .= '<a class="btn btn-primary mt-2" id="btn-show-stats">Показать статистику</a>';
		// вывод теста...
		$print_res .= '<div class="test-q-and-a none mt-4">';
		foreach($test_all_data_result as $id_question => $item){ // получаем вопрос + ответы
			$correct_answer = $item['correct_answer'];
			$incorrect_answer = null;
			if( isset($item['incorrect_answer']) ){
				$incorrect_answer = $item['incorrect_answer'];
				$classQ = 'question-res error';
			}else{
				$classQ = 'question-res ok';
			}
			$print_res .= "<div class='$classQ'>";
			foreach($item as $id_answer => $answer){ // проходимся по массиву ответов
				if( $id_answer === 0 ){
					// вопрос
					$print_res .= "<p class='q'>$answer</p>";
				}elseif( is_numeric($id_answer) ){
					// ответ
					if( $id_answer == $correct_answer ){
						// если это верный ответ
						$class = 'a ok2';
					}elseif( $id_answer == $incorrect_answer ){
						// если это неверный ответ
						$class = 'a error2';
					}else{
						$class = 'a';
					}
					if ($class == 'a error2') {
						$print_res .= "<p class='$class'><input type='radio' checked disabled><label style='margin-left: 5px'>$answer</label></p>";
					} else if ($class == 'a ok2' && $classQ == 'question-res ok') {
						$print_res .= "<p class='$class'><input type='radio' checked disabled><label style='margin-left: 5px'>$answer</label></p>";
					} else {
						$print_res .= "<p class='$class'><input type='radio' disabled><label style='margin-left: 5px'>$answer</label></p>";
					}
					
				}
			}
			$print_res .= '</div>'; // .question-res
		}
		$print_res .= '</div>';

		$print_res .= '<div class="stats none mt-4">';

		$query = R::getAll("SELECT correct_score
		FROM usersandtests
			WHERE test_id = '$test_id'");
		
		$count_all = 0;
		foreach($query as $item){
			$qr = $item;
			foreach($qr as $item){
				$correct_score += $item;
				$count_all++;	
			}
		}
		
			$print_res .= '<div style="width: 150px; height: 150px" id="correct_and_incorrect_answers_graph"><canvas id="graph"></canvas></div>';
			$avg_value = round(($correct_score / $count_all),2);
			$print_res .= "<p>Пользователей прошло тест: <b>{$count_all}</b></p>";
			$print_res .= "<p>Средний результат среди всех пользователей: <b>{$avg_value}</b></p>";
			$print_res .= '<div style="width: 260px; height: 160px" id="correct_and_incorrect_answers_graph_second"><canvas id="graph-2"></canvas></div>';
			$print_res .= "<script>
								const data = {
									labels: [
										'Верные ответы',
										'Неверные ответы'
									],
									datasets: [{
										label: 'My First Dataset',
										data: [{$correct_answer_count}, {$incorrect_answer_count}],
										backgroundColor: [
										'rgb(54, 162, 235)',
										'rgb(255, 99, 132)'
										],
										hoverOffset: 4,
										rotation: 180
									}]
								};
								
								
								
								const config = {
									type: 'doughnut',
									data: data,
									options: {
										animations: {
								
										}
									}
								};
								
								const myChart = new Chart(
									document.getElementById('graph'),
									config
								);
								
								
								const data_2 = {
									labels: [
									'Мой результат',
									'Средний результат'
									],
									datasets: [{
										type: 'bar',
										label: 'Результат',
										data: [{$correct_answer_count}, {$avg_value}],
										borderColor: 'rgba(255, 99, 132, 1)',
										backgroundColor: 'rgba(255, 99, 132, 0.3)'
									}, {
										type: 'line',
										label: 'Линия',
										data: [{$correct_answer_count}, {$avg_value}],
										fill: false,
										borderColor: 'rgb(54, 162, 235)'
									}]
								};
								
								
								
								const config_2 = {
									type: 'scatter',
									data: data_2,
									options: {
										scales: {
											y: {
												beginAtZero: true
											}
										}
									}
								};
								
								const myChart_2 = new Chart(
									document.getElementById('graph-2'),
									config_2
								);
								
							</script>";


		$print_res .= '</div>';



	$print_res .= '</div>'; // .test-data

	return $print_res;
}


function formatstr($str) {
        $str = trim($str);
        $str = stripslashes($str);
        $str = htmlspecialchars($str);
		if (is_numeric($str)):
			return $str;
		else:
			if ($str != NULL):
			return false;
			endif;
		endif;
    }

function category_list() {
	$categories = [
		'Бизнес',
		'Биология',
		'Информатика',
		'Искусство',
		'История',
		'Литература',
		'Логика',
		'Маркетинг',
		'Математика',
		'Медицина',
		'Программирование',
		'Психология',
		'Спорт',
		'Физика',
		'Философия',
		'Экономика',		
	];
	return $categories;
}

?>
