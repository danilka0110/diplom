$(function() {

    $('.test-data').find('div:first').show();

// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //
// ---------------------------- ПАГИНАЦИЯ ----------------------------- //
// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //

if ($('.question').length != 1) {
    $('.btn-success').hide();
} else {
    $('.btn-next').hide();
    $('.btn-success').show();
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


          $('input:radio[id^="answer-"]').change(function() {
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
    
            $('input:radio[id^="answer-"]').change(function() {
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
        var test = +$('#test-id').text();
        var res = {'test':test};
        error = false;
        $('.question').each(function() {
            var id = $(this).data('id');
            res[id] = $('input[name=question-' + id + ']:checked').val();
            if (res[id] == undefined) {
                error = true;
            }
        });
        if (error == false) {
            $('.result-error').hide();
            $('.spinner-border').removeClass('none');
            $.ajax({
                url: 'test',
                type: 'POST',
                data: res,
                success: function(html) {
                    $('.btn-finish').hide();
                    $('.test-show').removeClass('test-decoration');
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

    $("body").on('click', '#btn-show-results', function() {
        if ($(this).html() == 'Показать результат') {
            $('#btn-show-stats').html("Показать статистику");
            $('.stats').hide();
            $('.test-q-and-a').show();
            $(this).html("Скрыть результат");
        } else {
            $('.test-q-and-a').hide();
            $(this).html("Показать результат");
        }
    });


    $("body").on('click', '#btn-show-stats', function() {
        if ($(this).html() == 'Показать статистику') {
            $('#btn-show-results').html("Показать результат");
            $('.test-q-and-a').hide();
            $('.stats').show();
            $(this).html("Скрыть статистику");
        } else {
            $('.stats').hide();
            $(this).html("Показать статистику");
        }
    });




    $("body").on('click', '#btn-show-answers', function() {
        if ($(this).html() == 'Показать мои ответы') {
            $('#btn-show-stats-psychology').html("Показать статистику");
            $('.stats').hide();
            $('.test-q-and-a').show();
            $(this).html("Скрыть мои ответы");
        } else {
            $('.test-q-and-a').hide();
            $(this).html("Показать мои ответы");
        }
    });


    $("body").on('click', '#btn-show-stats-psychology', function() {
        if ($(this).html() == 'Показать статистику') {
            $('#btn-show-answers').html("Показать мои ответы");
            $('.test-q-and-a').hide();
            $('.stats').show();
            $(this).html("Скрыть статистику");
        } else {
            $('.stats').hide();
            $(this).html("Показать статистику");
        }
    });

});