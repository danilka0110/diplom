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

function print_arr($arr){
	echo '<pre>'  . print_r($arr, true) . '</pre>';
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
	$query = R::getAll("SELECT q.question, q.survey_id, a.id, a.answer, a.question_id
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








































?>