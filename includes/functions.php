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
				WHERE q.test_id = $test AND a.score = '1' AND test.enable = '1'");

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
		$print_res .= '<div class="test-results">';
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


		$print_res .= "</div>"; // .test-results
	$print_res .= '</div>'; // .test-data



	$print_res .= '<hr>';




	$test_category = R::findOne('category', 'test_id = :test_id', [':test_id' => $test_id]);

	$query = R::getAll("SELECT test_id
							FROM category
								WHERE category = '$test_category->category'");


	foreach ($query as $keys => $item) {
		foreach ($item as $key => $it) {
			if ($it != $test_id) {
				$tests_id_for_recomendation[] = $it;
			}
		}
	}

	if ($tests_id_for_recomendation):

		foreach($tests_id_for_recomendation as $tests_id_for_recomendation_tests) {

			if ($tests_id_for_recomendation_tests == $test_id) {
				continue;
			}

			$tests_data_for_recomendation[] = R::getRow("SELECT id, test_name, img_link
									FROM test
										WHERE id = $tests_id_for_recomendation_tests");
		}




		$print_res .= '<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
						<div class="carousel-inner w-100">
							<h3 class="text-center">Рекомендуемые тесты</h3>
							<div class="row mt-4">';

		foreach ($tests_data_for_recomendation as $key => $recomendation_test) :

			$recomendation_test_id = $recomendation_test['id'];
			$recomendation_test_img_link = $recomendation_test['img_link'];
			$recomendation_test_test_name = $recomendation_test['test_name'];

			if ($key == 0):

				$print_res .= "<div class='carousel-item active text-center'>
									<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3 col-xl-3'>
										<div class='card card-body'>
											<a href='test?test=$recomendation_test_id'><img
													src='$recomendation_test_img_link' class='popular_test_img' alt='img'></a>
											<a href='test?test=$recomendation_test_id'
												style='margin-left: 5px;'>$recomendation_test_test_name</a>
										</div>
									</div>
								</div>";

			else:

				$print_res .= "<div class='carousel-item text-center'>
									<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3 col-xl-3'>
										<div class='card card-body'>
											<a href='test?test=$recomendation_test_id'><img
													src='$recomendation_test_img_link' class='popular_test_img' alt='img'></a>
											<a href='test?test=$recomendation_test_id'
												style='margin-left: 5px;''>$recomendation_test_test_name</a>
										</div>
									</div>
								</div>";

			endif;

		endforeach;

				$print_res .= '</div>
					<div class="text-center">
						<button class="carousel-control-btn" type="button" data-bs-target="#myCarousel"
						data-bs-slide="prev">

						<img src="img/prev.png" alt="" width="34" height="34"></img>
						</button>


						<button class="carousel-control-btn" type="button" data-bs-target="#myCarousel"
						data-bs-slide="next">

						<img src="img/next.png" alt="" width="34" height="34">
						</button>
					</div>
				</div>
			</div>';


		$print_res .= '<script src="js/tests.js"></script>';

	else:


		$print_res .= '<h3 class="text-center">Рекомендуемые тесты</h3>
							<div class="text-center" style="font-size:18px"><span>Нет рекомендованных тестов</span></div>';


	endif;


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
































function get_psychology_test_data($test_id){
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

	foreach($_POST as $q => $a){
		// удалим из POST то что пользователь писал сам через панель разработчика
		if(!isset($data[$q])){
			return false;
		}
	}

	return $data;
}














function savePsychologyTest($test_all_data, $test_id, $user, $date) {
	$all_count = (count($test_all_data)); // кол-во вопросов
	$count_score = 0; // кол-во набранных баллов

	foreach($test_all_data as $item) {
		foreach($item as $key => $score) {
			if ($key != 0) {
				if (in_array($key, $_POST)) {
					$count_score += $score;
				}
			}
		}
	}

	$test_name = get_test_name($test_id);
	foreach($test_name as $item) {
		$test_name = $item['test_name'];
	}

	$users_and_tests = R::findOne('usersandpsychologytest', 'user_id = :user_id AND test_id = :test_id', [':user_id' => $user, ':test_id' => $test_id]);
	if ($users_and_tests) {
		$users_and_tests->test_name = $test_name;
		$users_and_tests->score = $count_score;
		$users_and_tests->all_count = $all_count;
		$users_and_tests->date = $date;
		R::store($users_and_tests);
	} else {
		$users_and_tests = R::dispense('usersandpsychologytest');
		$users_and_tests->user_id = $user;
		$users_and_tests->test_id = $test_id;
		$users_and_tests->test_name = $test_name;
		$users_and_tests->score = $count_score;
		$users_and_tests->all_count = $all_count;
		$users_and_tests->date = $date;
		R::store($users_and_tests);
	}
}









function print_result_psychology_test($test_all_data, $test_id, $choices) {

	$all_count = count($test_all_data); // кол-во вопросов

	// подсчет результатов
	$count_score = 0;
	foreach($test_all_data as $item) {
		foreach($item as $key => $score) {
			if ($key != 0) {
				if (in_array($key, $choices)) {
					$count_score += $score;
				}
			}
		}
	}

	$result_query = R::getRow ("SELECT result
							FROM results
								WHERE test_id = $test_id AND $count_score
										BETWEEN score_min AND score_max");

	foreach ($result_query as $result_one) {
		$result = $result_one;
	}

	// вывод результатов
	$print_res = '<div class="test-data">';
		$print_res .= '<div class="test-results">';
			$print_res .= '<div class="text-center mb-4 test_ty">';
				$print_res .= '<img src="../img/success_passes.png">';
				$print_res .= '<span>Результат</span>';
			$print_res .= '</div>';

			$print_res .= '<div class="count-res">';

				$print_res .= "<div>";
					$print_res .= "<span>Всего вопросов: <b>{$all_count}</b></span>";
				$print_res .= "</div>";

				$print_res .= "<div>";
					$print_res .= "<span>Набрано баллов: <b>{$count_score}</b></span>";
				$print_res .= "</div>";

				$print_res .= "<br>";

				$print_res .= "<div>";
					$print_res .= "<span><b>Ваш результат: </b>$result</span>";
				$print_res .= "</div>";

			$print_res .= '</div>';	// .count-res

			// вывод теста...
			
		$print_res .= '</div>';
			
	$print_res .= '</div>';


	$print_res .= '<a class="btn btn-primary mt-2" id="btn-show-answers">Показать мои ответы</a>';
	$print_res .= '<a class="btn btn-primary mt-2" id="btn-show-stats-psychology">Показать статистику</a>';


	$print_res .= '<div class="test-q-and-a none mt-4" style="font-size: 14px">';
	foreach($test_all_data as $id_question => $item){ // получаем вопрос + ответы

		$print_res .= "<div class='question-res'>";
		foreach($item as $id_answer => $answer){ // проходимся по массиву ответов
			if( $id_answer === 0 ){
				// вопрос
				$print_res .= "<p class='q'>$answer</p>";
			}elseif( is_numeric($id_answer) ){


				$class = 'a';

				if (in_array($id_answer, $choices)) {
					$print_res .= "<p class='$class' style='margin-top:-20px; margin-bottom: 5px'><input type='radio' checked disabled><label style='margin-left: 5px;'>$answer</label></p>";
				} 

				else {
					$print_res .= "<p class='$class' style='margin-top:-20px; margin-bottom: 5px'><input type='radio' disabled><label style='margin-left: 5px;'>$answer</label></p>";
				}	
			}
		}
		$print_res .= '</div>'; // .question-res
	}

	$print_res .= '</div>'; // .question-res






	$avg = R::getRow("SELECT AVG(score)
						FROM usersandpsychologytest
							WHERE test_id = $test_id");

	$count_users_query = R::getAll("SELECT user_id
								FROM usersandpsychologytest
									WHERE test_id = $test_id");

	$count_users = 0;
	foreach ($count_users_query as $item) {
		$count_users++;
	}	

		$print_res .= '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';	


		$print_res .= '<div class="stats none mt-4" style="font-size: 14px">';		

			$avg_value = round(($avg['AVG(score)']), 2);

			$print_res .= "<p>Пользователей прошло тест: <b>{$count_users}</b></p>";
			$print_res .= "<p>Средний результат среди всех пользователей: <b>{$avg_value}</b></p>";

			$print_res .= '<div style="width: 250px; height: 125px" id="correct_and_incorrect_answers_graph"><canvas id="graph"></canvas></div>';

			$print_res .= "<script>													
								const data = {
									labels: [
									'Мой результат',
									'Средний результат'
									],
									datasets: [{
										type: 'bar',
										label: 'Результат',
										data: [{$count_score}, {$avg_value}],
										borderColor: 'rgba(255, 99, 132, 1)',
										backgroundColor: 'rgba(255, 99, 132, 0.3)'
									}, {
										type: 'line',
										label: 'Линия',
										data: [{$count_score}, {$avg_value}],
										fill: false,
										borderColor: 'rgb(54, 162, 235)'
									}]
								};
								
								
								
								const config = {
									type: 'scatter',
									data: data,
									options: {
										scales: {
											y: {
												beginAtZero: true
											}
										}
									}
								};
								
								const myChart = new Chart(
									document.getElementById('graph'),
									config
								);
								
							</script>";


		$print_res .= '</div>';





	if($_POST) {
		
	$print_res .= '<hr>';

	$test_category = R::findOne('category', 'test_id = :test_id', [':test_id' => $test_id]);

	$query = R::getAll("SELECT test_id
							FROM category
								WHERE category = '$test_category->category'");



	foreach ($query as $keys => $item) {
		foreach ($item as $key => $it) {
			if ($it != $test_id) {
				$tests_id_for_recomendation[] = $it;
			}
		}
	}

	if ($tests_id_for_recomendation):

		foreach($tests_id_for_recomendation as $tests_id_for_recomendation_tests) {

			if ($tests_id_for_recomendation_tests == $test_id) {
				continue;
			}

			$tests_data_for_recomendation[] = R::getRow("SELECT id, test_name, img_link
									FROM test
										WHERE id = $tests_id_for_recomendation_tests");
		}

		$print_res .= '<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
						<div class="carousel-inner w-100">
							<h3 class="text-center">Рекомендуемые тесты</h3>
							<div class="row mt-4">';

		foreach ($tests_data_for_recomendation as $key => $recomendation_test) :

			$recomendation_test_id = $recomendation_test['id'];
			$recomendation_test_img_link = $recomendation_test['img_link'];
			$recomendation_test_test_name = $recomendation_test['test_name'];

			if ($key == 0):

				$print_res .= "<div class='carousel-item active text-center'>
									<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3 col-xl-3'>
										<div class='card card-body'>
											<a href='test?test=$recomendation_test_id'><img
													src='$recomendation_test_img_link' class='popular_test_img' alt='img'></a>
											<a href='test?test=$recomendation_test_id'
												style='margin-left: 5px;'>$recomendation_test_test_name</a>
										</div>
									</div>
								</div>";

			else:

				$print_res .= "<div class='carousel-item text-center'>
									<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3 col-xl-3'>
										<div class='card card-body'>
											<a href='test?test=$recomendation_test_id'><img
													src='$recomendation_test_img_link' class='popular_test_img' alt='img'></a>
											<a href='test?test=$recomendation_test_id'
												style='margin-left: 5px;''>$recomendation_test_test_name</a>
										</div>
									</div>
								</div>";

			endif;

		endforeach;

				$print_res .= '</div>
					<div class="text-center">
						<button class="carousel-control-btn" type="button" data-bs-target="#myCarousel"
						data-bs-slide="prev">

						<img src="img/prev.png" alt="" width="34" height="34"></img>
						</button>


						<button class="carousel-control-btn" type="button" data-bs-target="#myCarousel"
						data-bs-slide="next">

						<img src="img/next.png" alt="" width="34" height="34">
						</button>
					</div>
				</div>
			</div>';


		$print_res .= '<script src="js/tests.js"></script>';

	else:


		$print_res .= '<h3 class="text-center">Рекомендуемые тесты</h3>
							<div class="text-center" style="font-size:18px"><span>Нет рекомендованных тестов</span></div>';


	endif;
	}

	return $print_res;


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
		$print_res .= '<div class="test-results">';
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
			
				$print_res .= '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';

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


		$print_res .= "</div>"; // .test-results
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
