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
            $('.btn-success').show();
        }

        return false;
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
            var id = $(this).data('id'); 
            res[id] = $('input[name=question-' + id + ']:checked').val(); console.log(res[id]);
            if (res[id] == undefined) {
                error = true;
            }
        }); console.log(res);
        if (error == false) {
            $('.result-error').hide();
            $.ajax({
                url: 'survey', 
                type: 'POST',
                data: res,
                success: function(html) {
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
});
