let questionNum = 1;
let click = 0;
let questionsNumIfDelete = 0;
let prevQuestionForDeleteBtn;
$(document).on('click', '.addAnswer', function() {
    $('.question_' + $(this).data('question') + ' .answer-error').hide();
    let question = $(this).data('question');
    let answer = $(this).data('answer');
    let answerBlock = $(this).parents('.answers').find('.answer-items');

    if (answer == 10) {
        return "нельзя создать больше 10 вариантов ответа";
    }
    if ($('.question_' + question).hasClass('wasDelete')) {

        let takeLastAnswerData = ($('.question_' + $(this).data('question') + ' .answers .answer-items .row input:last').attr('data-numanswer'));
        if (takeLastAnswerData == undefined) {
            answer = 0;
        } else {
            answer = takeLastAnswerData;
        $('.question_' + question).removeClass('wasDelete');
        }

    }
    answer++;

    $(this).data('answer', answer);
    if (answer == 1) {
        answerBlock.append(`
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                <label for="answer_text_1_1" class="form-label">Ответ</label>
                <input required type="text" name="answer_text_${question}_${answer}" id="answer_text_${question}_${answer}" class="form-control" placeholder = "Вариант #${answer}" autocomplete="off" data-numanswer="${answer}">
            </div>
        </div>`);
    } else {
        answerBlock.append(`
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                <label for="answer_text_1_1" class="form-label"></label>
                <input required type="text" name="answer_text_${question}_${answer}" id="answer_text_${question}_${answer}" class="form-control" placeholder = "Вариант #${answer}" autocomplete="off" data-numanswer="${answer}">
            </div>
        </div>`);
    }

});
$('.addQuestion').on('click', function() {
    if (questionNum == 80) {
        return "нельзя создать больше 80 вопросов";
    }
    questionNum++;
    let questionBlock = $('.question-items');
    questionBlock.append(`
        <div class="question_${questionNum} mt-4" data-question="${questionNum}">
            <label for="question_${questionNum}" class="form-label">Вопрос #${questionNum}</label>

            <div>
                <input type="checkbox" name="ifcheckbox_${questionNum}" id="ifcheckbox_${questionNum}">
                <label for="ifcheckbox_${questionNum}" class="form-label">Множественный выбор</label>
            </div>

            <input required type="text" name="question_${questionNum}" id="question_${questionNum}" class="form-control" autocomplete="off" placeholder="Вопрос #${questionNum}">
            <div class="answers">
                <div class="answer-items">
                </div>

                <button type="button" class="btn btn-primary border addAnswer" data-question="${questionNum}" data-answer="0" style="display: inline; margin-top: 15px;">+</button>

                <button type="button" class="btn btn-danger border removeAnswer" data-question="${questionNum}" data-click="0" style="display: inline; margin-top: 15px;">X</button>

                <p class="none answer-error" style="color:red" data-question="${questionNum}">Нечего удалять :)</p>
            </div>
            <div class="text-center mt-4">
                <button type="button" class="btn btn-danger border removeQuestion text-center" data-question="${questionNum}">Удалить вопрос</button>
            </div><hr>
        </div>`);
        
        ($(this).data('question', questionNum));
        prevQuestionForDeleteBtn = questionNum-1;
        $(".removeQuestion[data-question=" + prevQuestionForDeleteBtn + "]").remove();
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
    } else {

    }

    let questionBlock = $('.question-items');
    let qnNow = questionNum+1;
    $(".removeQuestion[data-question=" + qnNow + "]").remove();

    if($('*').is("[class^='question_']")) {
        questionBlock.append(`
        <div class="text-center mt-4">
            <button type="button" class="btn btn-danger border removeQuestion text-center" data-question="${questionNum}">Удалить вопрос</button>
        </div>
        `);
    }
});
$(document).ready(function () {
    $("#img_link").change(function () {
        $(".create-test-img").removeAttr('src');
        let src = $("#img_link").val();
        if (src == '') {
            src = 'http://tic-tomsk.ru/wp-content/uploads/2020/11/scale_1200.jpg';
            $(".create-test-img").attr('src', src);
        }
        $(".create-test-img").attr('src', src);
    });
    $("#test_name").change(function () {
        $(".create-test-name").removeAttr('val');
        let test_name = $("#test_name").val();
        $(".create-test-name").html(test_name);
    });
    $("#test_description").change(function () {
        $(".create-test-description").removeAttr('val');
        let test_description = $("#test_description").val();
        $(".create-test-description").html(test_description);
    });
});