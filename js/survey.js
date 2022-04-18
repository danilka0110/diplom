$(function() {

    $('.test-data').find('div:first').show();

// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //
// ---------------------------- ПАГИНАЦИЯ ----------------------------- //
// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //

if ($('.question').length != 1) {
    $('.btn-success').hide();
}

    $('.pag a').on('click', function() {
        $('.btn-success').hide();
        $('.pag > a.first-question').removeClass('first-question');

        $('.next-error').hide();
        $('.btn-next').show();

        $('.pag').removeClass('next');

        ($(this).closest('.pag').next().addClass('next'))


        $('.pag a.nav-active-page').removeClass('next-question');
        $('.pag a.next-question').addClass('nav-active-page');
        let last_question = $(".pag > a:last").attr('href');
        $('.btn-finish').click(function() {
            $('.result-error').hide();
        })
        $('.result-error').hide();
        if ($(this).attr('class') == 'nav-active') return false;

        var link = $(this).attr('href');
        var prevActive = $('.pag > a.nav-active-page').attr('href');




            $('[id^="question-"]').find('[id^="answer-"]').change(function() {
              $('.pag > a.nav-active-page').addClass('nav-prev-page');
            });




        $('.pag > a.nav-active-page').removeClass('nav-active-page');

        $(this).addClass('nav-active-page');

        $(prevActive).fadeOut(0, function() {
            +$(link).fadeIn(0);
        });

        if ($(this).attr('href') == last_question) {
            $('.btn-next').hide();
            $('.btn-success').show();
        }

        return false;
    });









    $('.btn-next').on('click', function() {
        
        $('.next-error').hide();
        let last_question = $(".pag > a:last").attr('href');

        var link = $('.pag > a.nav-active-page').attr('href'); // сейчас - 1
        var next = $('.pag.next > a').attr('href') // следующий - 2

        if (next) {
            $(link).fadeOut(0, function() {
                +$(next).fadeIn(0);


            $('.pag.next').next().addClass('temp');
            $('.pag > a.nav-active-page').removeClass('nav-active-page');
            $('.pag.next > a').addClass('nav-active-page');
            $('.pag.next').removeClass('next');
            $('.pag.temp').addClass('next');
            $('.pag.next').removeClass('temp');
    
            $('[id^="question-"]').find('[id^="answer-"]').change(function() {
                $('.pag > a.nav-active-page').addClass('nav-prev-page');
            });
            
    
            if (next == last_question) {
                $('.btn-next').hide();
                $('.btn-finish').show();
            } else {
                $('.btn-next').show();
            }
        });
        } else {
            $('.next-error').fadeOut(150, function() {
                $('.next-error').fadeIn(150);
            });
        }

});










// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //
// ------------------------- ЕСЛИ 1 ВОПРОС ---------------------------- //
// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //

    $('[id^="question-"]:first').find('[id^="answer-"]').change(function() {
        $('.pag > a.first-question').addClass('nav-prev-page');
    });


// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //
// -------------------------- СТАРТ ТЕСТА ----------------------------- //
// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //


    $('#test-start').click(function() {
        $('.test-head').remove();
        $('.test-show').show();
    });

// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //
// --------------------------- POST ЗАПРОС ---------------------------- //
// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //


    $('#btn').click(function() {
        var survey = +$('#survey-id').text();
        var res = {'survey':survey};
        error = false;
        
        $('.question').each(function() {
            var checkboxesChecked = [];
            findClass = $(this).find(".q").attr("class");

            
            if (findClass == 'q checkbox question-show') {

                findCountCheckboxesInQuestion = $(this).find(".checkbox-answers");



                var id = $(this).data('id');


                for (let i = 0; i < findCountCheckboxesInQuestion.length; i++) {

                    if (findCountCheckboxesInQuestion[i].checked) {
                        checkboxesChecked.push(findCountCheckboxesInQuestion[i].value); // положим в массив выбранный
                     }

                    // res[id] = [$('input[name=question-' + id + ']:checked').val()]; console.log(res[id]);
                    
                }
                res[id] = checkboxesChecked;
                
                
                // console.log($('input[name=question-' + id + ']:checked').length);
            } 

            else if (findClass == 'q radio question-show') {



                var id = $(this).data('id'); 
                res[id] = $('input[name=question-' + id + ']:checked').val();
            }

            if (res[id] == undefined || res[id] == 0) {
                error = true;
            }

        });
        if (error == false) {
            $('.result-error').hide();
            $('.spinner-border').removeClass('none');
            $.ajax({
                url: 'survey', 
                type: 'POST',
                data: res,
                success: function(html) {
                    $('.btn-finish').hide();
                    $('.test-show').removeClass('survey-decoration');
                    $('.test-show').html(html);
                },
                error:function() {
                    alert('Error!');
                }
            });
        } else {
            $('.result-error').show();
            $('.result-error').fadeOut(150, function() {
                $('.result-error').fadeIn(150);
            });
        }
    });



// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //
// ---------------------- SHOW STATS AND RESULT ----------------------- //
// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //


    $("body").on('click', '#stats', function() {
        let data = ($(this).data('stats'));
        if ($(this).html() == 'Показать полную статистику') {
            $('.stats_block_' + data).show();
            $(this).html("Скрыть полную статистику");
        } else {
            $('.stats_block_' + data).hide();
            $(this).html("Показать полную статистику");
        }
    });


    
});
