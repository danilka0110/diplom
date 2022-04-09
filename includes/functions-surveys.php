<?php 

//************************// СОЗДАНИЕ ОПРОСА ************************//

function category_list() {
	$categories = [
        'Баланс работы и отдыха',
        'Бизнес',
        'Биология',
        'Благотворительность',
        'Гибкость мышления',
        'Имущество',
        'Информатика',
        'Искусство',
        'История',
        'Карьера',
        'Литература',
        'Личный бренд',
        'Маркетинг',
        'Математика',
        'Медицина',
        'Отношения с детьми',
        'Отношения с другими людьми',
        'Отношения с партнером',
        'Отношения с собой',
        'Питание',
        'Программирование',
        'Профориентация',
        'Психология',
        'Работа по дому',
        'Работа',
        'Свободное время',
        'Спорт',
        'Физика',
        'Философия',
        'Хобби',
        'Экономика',				
	];
	return $categories;
}



//************************// ВЫВОД ОПРОСОВ ************************//

function print_arr($arr) {
	echo '<pre>'  . print_r($arr, true) . '</pre>';
}

function survey_correct($survey_id, $survey_all_data) {
        $data = R::getAll("SELECT survey_name
                FROM survey
                        WHERE id = '$survey_id' AND enable = '1'");


        foreach($_POST as $q => $a){
                // удалим из POST то что пользователь писал сам через панель разработчика
                if(!isset($survey_all_data[$q])){
                        unset($_POST[$q]);
                        continue;
                }

        }


        if(!$data) return false; else return $data;
}

function get_surveys() {
        $data = R::getAll("SELECT * 
        FROM survey 
                WHERE enable = '1'");
        if(!$data) return false;
        return $data;
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


function get_popular_surveys() {
        $data = R::getAll("SELECT id, survey_name, img_link FROM survey WHERE enable = '1'
                order by count_passes desc limit 10");
        return $data;
}

function get_surveys_for_category($category_data) {
        $data = R::getAll("SELECT * 
                    FROM survey s
                    LEFT JOIN surveyscategory c 
                            ON s.id = c.survey_id 
                                    WHERE enable = '1' and c.category = '$category_data'");
            if(!$data) return false;
            return $data;
    }

function get_surveys_for_search($search_data){
$data = R::getAll("SELECT * 
                FROM survey
                WHERE enable = '1' and (survey_name LIKE '%$search_data%' or description LIKE '%$search_data%' or author LIKE '%$search_data%')");
        if(!$data) return false;
        return $data;
}



function get_survey_data($survey_id){
	if(!$survey_id) return;
	$query = R::getAll("SELECT q.question, q.survey_id, q.type, a.id, a.answer, a.question_id
		FROM surveyquestions q
		LEFT JOIN surveyanswers a
			ON q.id = a.question_id
		LEFT JOIN survey
			ON survey.id = q.survey_id
				WHERE q.survey_id = $survey_id AND survey.enable = '1'");
	$data = null;
    foreach($query as $item) {
        if( !$item['question_id'] ) return false;
		$data[$item['question_id']][0] = $item['question'];
                $data[$item['question_id']]['type'] = $item['type'];
		$data[$item['question_id']][$item['id']] = $item['answer'];
    }
	return $data;
}

function get_survey_name($survey_id) {
	if (!$survey_id) return;
	$query = R::getAll("SELECT s.survey_name, s.description, s.img_link, s.author
	FROM survey s 
		WHERE s.id = $survey_id AND s.enable = '1'");
	return $query;
}



function pagination($count_questions, $survey_data){
	$keys = array_keys($survey_data);
	$pagination = '<div class="pagination-block">';
	for($i = 1; $i <= $count_questions; $i++){
		$key = array_shift($keys);
		if( $i == 1 ){
			$pagination .= '<div class="pag"><a class="pagination-answers nav-active-page first-question" href="#question-' . $key . '">0' . $i . '</a></div>';
		}elseif ( $i < 10 ){
			$pagination .= '<div class="pag"><a class="pagination-answers" href="#question-' . $key . '">0' . $i . '</a></div>';
		}else{
			$pagination .= '<div class="pag"><a class="pagination-answers" href="#question-' . $key . '">' . $i . '</a></div>';
		}

	}
	$pagination .= '</div>';
	$key_next = 2;
	return $pagination;
}

function save($survey_id, $user_id) {

        $survey_name = get_survey_name($survey_id);
	foreach($survey_name as $item) {
		$survey_name = $item['survey_name'];
	}
        

	$user_save_survey = R::findOne('usersurveydata', 'user_id = :user_id AND survey_id = :survey_id', [':user_id' => $user_id, ':survey_id' => $survey_id]); 


	if($user_save_survey) {


                $query = R::find('usersurveydata', 'user_id = :user_id AND survey_id = :survey_id', [':user_id' => $user_id, ':survey_id' => $survey_id]);
		R::trashAll($query);


            		foreach($_POST as $key => $item) {
                        if(is_array($item)) {
                                foreach($item as $it) {
                                        // $key - номер вопроса ### $it - номер ответа

                                        $users_save_survey = R::dispense('usersurveydata');
                                        $users_save_survey->user_id = $user_id;
                                        $users_save_survey->survey_id = $survey_id;
                                        $users_save_survey->survey_name = $survey_name;
                                        $users_save_survey->question_id = $key;
                                        $users_save_survey->type = 'checkbox';
                                        $users_save_survey->answer_id = $it;
                                        R::store($users_save_survey);

                                }
                        }
                        
                        else {
                                // $key - номер вопроса ### $item - номер ответа

                                $users_save_survey = R::dispense('usersurveydata');
                                $users_save_survey->user_id = $user_id;
                                $users_save_survey->survey_id = $survey_id;
                                $users_save_survey->survey_name = $survey_name;
                                $users_save_survey->question_id = $key;
                                $users_save_survey->type = 'radio';
                                $users_save_survey->answer_id = $item;
                                R::store($users_save_survey);
                                
                        }
		}
	} 
        



        
        else {
		foreach($_POST as $key => $item) {
                        if(is_array($item)) {
                                foreach($item as $it) {
                                        // $key - номер вопроса ### $it - номер ответа
                                        
                                        $users_save_survey = R::dispense('usersurveydata');
                                        $users_save_survey->user_id = $user_id;
                                        $users_save_survey->survey_id = $survey_id;
                                        $users_save_survey->survey_name = $survey_name;
                                        $users_save_survey->question_id = $key;
                                        $users_save_survey->type = 'checkbox';
                                        $users_save_survey->answer_id = $it;
                                        R::store($users_save_survey);

                                }
                        }
                        
                        else {
                                // $key - номер вопроса ### $item - номер ответа

                                $users_save_survey = R::dispense('usersurveydata');
                                $users_save_survey->user_id = $user_id;
                                $users_save_survey->survey_id = $survey_id;
                                $users_save_survey->survey_name = $survey_name;
                                $users_save_survey->question_id = $key;
                                $users_save_survey->type = 'radio';
                                $users_save_survey->answer_id = $item;
                                R::store($users_save_survey);
                                
                        }
		}
	}

}


function get_test_data($survey_id){
	if(!$survey_id) return;
	$query = R::getAll("SELECT q.question, q.survey_id, a.id, a.answer, a.question_id
		FROM surveyquestions q
		LEFT JOIN surveyanswers a
			ON q.id = a.question_id
		LEFT JOIN survey
			ON survey_id = q.survey_id
				WHERE q.survey_id = $survey_id AND survey.enable = '1'");
	$data = null;
    foreach($query as $item) {
        if( !$item['question_id'] ) return false;
		$data[$item['question_id']][0] = $item['question'];
		$data[$item['question_id']][$item['id']] = $item['answer'];
    }
	return $data;
}




function print_result($survey_all_data, $survey_id) {
        $print_res = '<div class="test-data">';
                $print_res .= '<div class="text-center mb-4" style="background: #9ad35f; height: 40px;">';
                        $print_res .= '<img src="../img/success_passes.png" style="margin-top: -5px;">';
                        $print_res .= '<span style="margin-left: 1%; font-size: 24px; font-family: Georgia, serif;">Спасибо, что прошли наш опрос!</span>';
                $print_res .= '</div>';


                $get_survey_name = get_survey_name($survey_id);
                foreach ($get_survey_name as $item) {
                        $survey_name = $item['survey_name'];
                        $survey_description = $item['description'];
                        $survey_author = $item['author'];
                }

                $all_count = count($survey_all_data);
                

                $print_res .= "<div>";
		$print_res .= "<span>Название опроса: <b>$survey_name</b></span>";
                $print_res .= "</div>";
                $print_res .= "<div>";
                        $print_res .= "<span>Автор опроса: <b>$survey_author</b></span>";
                $print_res .= "</div>";






                // echo("_POST");
                // print_arr($_POST);
                // echo("<br><br><br><br><br>");
                // echo("survey_all_data");
                // print_arr($survey_all_data);


                
                foreach($_POST as $answer_id) {
                        if (is_array($answer_id)) {
                                foreach ($answer_id as $item) {
                                        $user_responded[] = $item; 
                                }
                        }
                        else {
                                $user_responded[] = $answer_id;
                        }
                        
                }



                $i = 1;
                foreach ($survey_all_data as $question_id => $key):
                
                        foreach ($key as $id_answer => $answer) {
                                if ($id_answer === 0) {
                                        $question = $answer; 

                                }

                                else {
                                        $answer_name_labels_data[] = $answer; 
                                        $users_answers_data[] = R::count('usersurveydata', ' answer_id = ? ', [ $id_answer ]); 
                                        if (in_array($id_answer, $user_responded)) {
                                                $user_responded_answer[] = $answer;
                                        }
                                }
                                
                        }



                        $labels = json_encode($answer_name_labels_data); 
                        $data = json_encode($users_answers_data); 

                        $print_res .= '<hr>';
                        $print_res .= '<div class="row mt-4">';
                                $print_res .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-12">';
                                        $print_res .= "<h4>$question</h4>";
                                        $print_res .= "<div class='center-block' style='width: 400px; height: 200px'id='correct_and_incorrect_answers_graph'><canvas id='myChart{$i}' width='2' height='1'></canvas></div>";
                                        $print_res .= "<script>

                                        var labels = $labels;
                                        var data = $data;
                                        const ctx = document.getElementById('myChart{$i}').getContext('2d');
                                        const myChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                                labels: labels,
                                                datasets: [{
                                                label: 'Ответы других пользователей:',
                                                data: data,
                                                backgroundColor: [
                                                        'rgba(255, 99, 132, 0.2)',
                                                        'rgba(54, 162, 235, 0.2)',
                                                        'rgba(255, 206, 86, 0.2)',
                                                        'rgba(75, 192, 192, 0.2)',
                                                        'rgba(153, 102, 255, 0.2)',
                                                        'rgba(255, 159, 64, 0.2)',
                                                        'rgba(255, 99, 132, 0.2)',
                                                        'rgba(54, 162, 235, 0.2)',
                                                        'rgba(255, 206, 86, 0.2)',
                                                        'rgba(75, 192, 192, 0.2)'
                                                ],
                                                borderColor: [
                                                        'rgba(255, 99, 132, 1)',
                                                        'rgba(54, 162, 235, 1)',
                                                        'rgba(255, 206, 86, 1)',
                                                        'rgba(75, 192, 192, 1)',
                                                        'rgba(153, 102, 255, 1)',
                                                        'rgba(255, 159, 64, 1)',
                                                        'rgba(255, 99, 132, 1)',
                                                        'rgba(54, 162, 235, 1)',
                                                        'rgba(255, 206, 86, 1)',
                                                        'rgba(75, 192, 192, 1)'
                                                ],
                                                borderWidth: 1
                                                }]
                                        },
                                        options: {
                                                scales: {
                                                y: {
                                                        beginAtZero: true
                                                }
                                                }
                                        }
                                        });
                                        </script>";
                                        foreach ($user_responded_answer as $ans):
                                                $print_res .= "<div>";
                                                $print_res .= "<span>Вы выбрали: <b>$ans</b></span>";
                                                $print_res .= "</div>";
                                        endforeach;


                                $print_res .= '</div>';
                        $print_res .= '</div>';
                        $user_responded_answer = [];
                        $answer_name_labels_data = [];
                        $users_answers_data = [];
                        $i++;
                endforeach;

        



        $print_res .= '</div>';

        return $print_res;

}


































?>