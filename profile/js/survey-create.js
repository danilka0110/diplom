let questionNum = 1;
let click = 0;
let questionsNumIfDelete = 0;
let prevQuestionForDeleteBtn;
$(document).on('click', '.addAnswer', function() {
    $('.question_' + $(this).data('question') + ' .answer-error').hide();
    let question = $(this).data('question');
    let answer = $(this).data('answer');
    let answerBlock = $(this).parents('.answers').find('.answer-items');
    let type = 'radio';

    if ($(`#ifcheckbox_${question}`).is(':checked')){ 

        let prevCreateAnswers = ($(`[id^=answer_radio_${question}]`))

        prevCreateAnswers.removeAttr('type');
        prevCreateAnswers.attr('type', 'checkbox');

        type = 'checkbox';
        
    } 
    
    else {
        let prevCreateAnswers = ($(`[id^=answer_radio_${question}]`))

        prevCreateAnswers.removeAttr('type');
        prevCreateAnswers.attr('type', 'radio');

        type = 'radio';
    }


    if ($('.question_' + question).hasClass('wasDelete')) {
        let takeLastAnswerData = ($('.question_' + $(this).data('question') + ' .answers .answer-items .row input:last').attr('data-numanswer'));
        if (takeLastAnswerData == undefined) {
            answer = 0;
        } else {
            answer = takeLastAnswerData;
            if (answer == 10) answer = 9;
        $('.question_' + question).removeClass('wasDelete');
        }

    }
    if (answer == 10) {
        return "нельзя создать больше 10 вариантов ответа";
    }
    answer++;

    $(this).data('answer', answer);


    if(type == 'radio') {
        if (answer == 1) {
            answerBlock.append(`
            <div class="row">
                <label for="answer_text_${question}_${answer}" class="form-label from-survey-answer-label">Варианты ответов:</label><br>    
                    <input type="radio" name="answer_radio_${question}_${answer}" id="answer_radio_${question}_${answer}" class="mt-3" disabled>
                    <label for="answer_radio_${question}_${answer}" class="form-label label-for-input first-input-radio-in-answers"></label>
                <div class="col-12 col-md-12 col-lg-12 col-xl-12"> 
                    <input required type="text" name="answer_text_${question}_${answer}" id="answer_text_${question}_${answer}" class="form-control mt-2" placeholder = "Вариант #${answer}" autocomplete="off" data-numanswer="${answer}">
                </div>
            </div>`);
        } else {
            answerBlock.append(`
            <div class="row">    
                    <input type="radio" name="answer_radio_${question}_${answer}" id="answer_radio_${question}_${answer}" class="mt-3" disabled>
                    <label for="answer_radio_${question}_${answer}" class="form-label label-for-input"></label>
                <div class="col-12 col-md-12 col-lg-12 col-xl-12"> 
                    <input required type="text" name="answer_text_${question}_${answer}" id="answer_text_${question}_${answer}" class="form-control mt-2" placeholder = "Вариант #${answer}" autocomplete="off" data-numanswer="${answer}">
                </div>
            </div>`);
        }
    }

    else if (type == 'checkbox') {
        if (answer == 1) {
            answerBlock.append(`
            <div class="row">
                    <label for="answer_text_1_${question}_${answer}" class="form-label from-survey-answer-label">Варианты ответов:</label><br>    
                    <input type="checkbox" name="answer_checkbox_${question}_${answer}" id="answer_radio_${question}_${answer}" class="mt-3" disabled>
                    <label for="answer_checkbox_${question}_${answer}" class="form-label label-for-input first-input-checkbox-in-answers"></label>
                <div class="col-12 col-md-12 col-lg-12 col-xl-12"> 
                    <input required type="text" name="answer_text_${question}_${answer}" id="answer_text_${question}_${answer}" class="form-control mt-2" placeholder = "Вариант #${answer}" autocomplete="off" data-numanswer="${answer}">
                </div>
            </div>`);
        } else {
            answerBlock.append(`
            <div class="row">  
                    <input type="checkbox" name="anscheckbox_${question}_${answer}" id="answer_radio_${question}_${answer}" class="mt-3" disabled>
                    <label for="answer_checkbox_${question}_${answer}" class="form-label label-for-input"></label>
                <div class="col-12 col-md-12 col-lg-12 col-xl-12"> 
                    <input required type="text" name="answer_text_${question}_${answer}" id="answer_text_${question}_${answer}" class="form-control mt-2" placeholder = "Вариант #${answer}" autocomplete="off" data-numanswer="${answer}">
                </div>
            </div>`);
        }
    }


});


$('.addQuestion').on('click', function() {
    if (questionNum == 80) {
        return "нельзя создать больше 80 вопросов";
    }
    questionNum++;
    let questionBlock = $('.question-items');
    questionBlock.append(`
        <div class="question_${questionNum} mt-4 question-st" data-question="${questionNum}">
            <label for="question_${questionNum}" class="form-label">Вопрос #${questionNum}</label>

            <div>
                <input type="checkbox" name="ifcheckbox_${questionNum}" id="ifcheckbox_${questionNum}" data-question="${questionNum}" class="checkbox-for-question">
                <label for="ifcheckbox_${questionNum}" class="form-label">Множественный выбор</label>
            </div>

            <input required type="text" name="question_${questionNum}" id="question_${questionNum}" class="form-control" autocomplete="off" placeholder="Вопрос #${questionNum}">
            <div class="answers">
                <div class="answer-items survey-answer-items">
                </div>

                <button type="button" class="btn btn-success border addAnswer" data-question="${questionNum}" data-answer="0" style="display: inline; margin-top: 15px;">+</button>

                <button type="button" class="btn btn-danger border removeAnswer" data-question="${questionNum}" data-click="0" style="display: inline; margin-top: 15px;">X</button>

                <p class="none answer-error" style="color:red" data-question="${questionNum}">Нечего удалять :)</p>
            </div><hr>
            <div class="text-center mt-2">
                <button type="button" class="btn btn-danger border removeQuestion text-center" data-question="${questionNum}">Удалить вопрос</button>
            </div>
        </div>`);
        
        ($(this).data('question', questionNum));
        prevQuestionForDeleteBtn = questionNum-1;
        $(".removeQuestion[data-question=" + prevQuestionForDeleteBtn + "]").remove();






        $("[id^='ifcheckbox_']").change(function () {

            let qstn = ($(this).data('question'));
        
            if ($(`#ifcheckbox_${qstn}`).is(':checked')){ 
        
                let prevCreateAnswers = ($(`[id^=answer_radio_${qstn}]`))
        
                prevCreateAnswers.removeAttr('type');
                prevCreateAnswers.attr('type', 'checkbox');
        
                type = 'checkbox';
                
            } 
            
            else {
                let prevCreateAnswers = ($(`[id^=answer_radio_${qstn}]`))
        
                prevCreateAnswers.removeAttr('type');
                prevCreateAnswers.attr('type', 'radio');
        
                type = 'radio';
            }
        
        });






});

$("body").on('click', '.removeAnswer', function() {

    let issetAnswersCheck = ($('.question_' + $(this).data('question') + ' .answers .answer-items .row input').attr('name'));
    if (issetAnswersCheck != undefined) {
        questionsNumIfDelete = $(this).data('question');
        $('.question_' + questionsNumIfDelete).addClass("wasDelete");
        click++;
        $('.question_' + questionsNumIfDelete + ' .answers .answer-items .row:last').remove();  
        }
    else {
        $('.question_' + $(this).data('question') + ' .answer-error').show();
        $('.question_' + $(this).data('question') + ' .answer-error').fadeOut(150, function() {
            $('.question_' + $(this).data('question') + ' .answer-error').fadeIn(150);
        });
    }
});
$("body").on('click', '.removeQuestion', function() {

    let qnLastQueston = $("[class^='question_']:last").data('question');
    if($(this).data('question') == qnLastQueston) {
        $('.question_' + qnLastQueston).remove();
        questionNum--;
    }

    let qnLastQuestonNow = $("[class^='question_']:last");


    let qnNow = questionNum+1;
    $(".removeQuestion[data-question=" + qnNow + "]").remove();

    if($('*').is("[class^='question_']")) {
        qnLastQuestonNow.append(`
        <div class="text-center">
            <button type="button" class="btn btn-danger border removeQuestion text-center mb-3" data-question="${questionNum}">Удалить вопрос</button>
        </div>
        `);
    }
});


$(document).ready(function () {
    $("#img_link").change(function () {
        $(".create-test-img").removeAttr('src');
        let src = $("#img_link").val();
        if (src == '') {
            src = 'https://avatars.mds.yandex.net/get-zen_doc/1860332/pub_5e5e171223f6716bacbc56cd_5e5e1718618046487a51ff7d/scale_1200';
            $(".create-test-img").attr('src', src);
        }
        $(".create-test-img").attr('src', src);
    });
    $("#survey_name").change(function () {
        $(".create-survey-name").removeAttr('val');
        let survey_name = $("#survey_name").val();
        $(".create-survey-name").html(survey_name);
    });
    $("#survey_description").change(function () {
        $(".create-survey-description").removeAttr('val');
        let survey_description = $("#survey_description").val();
        $(".create-survey-description").html(survey_description);
    });





});



$("[id^='ifcheckbox_']").change(function () {

    let qstn = ($(this).data('question'));

    if ($(`#ifcheckbox_${qstn}`).is(':checked')){ 

        let prevCreateAnswers = ($(`[id^=answer_radio_${qstn}]`))

        prevCreateAnswers.removeAttr('type');
        prevCreateAnswers.attr('type', 'checkbox');

        type = 'checkbox';
        
    } 
    
    else {
        let prevCreateAnswers = ($(`[id^=answer_radio_${qstn}]`))

        prevCreateAnswers.removeAttr('type');
        prevCreateAnswers.attr('type', 'radio');

        type = 'radio';
    }

});



