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
        // $('.next-error').hide();
        // $('.btn-next').show();

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

        // if (link == last_question) {
        //     $('.btn-next').hide();
        // } else {
        //     $('.btn-next').show();
        // }


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



//     $('.btn-next').on('click', function() {
        
//         $('.next-error').hide();
//         // let question_arr = [];
//         // let last_question = $(".pag > a:last").attr('href');


//         // var link = $('.pagination-block > .pag a.nav-active-page').attr('href') // сейчас - 1
//         // var prevActive = $('.pagination-block > .pag > a.nav-active-page').prev().attr('href'); // предыдущий - undefined
//         // var next = $('.pagination-block > .pag > a.nav-active-page').next().attr('href'); // следующий - 2

//         // $('.pagination-block > .pag a.nav-active-page').attr('href')



//         console.log(next);

//         if (next) {
//             $(link).fadeOut(0, function() {
//                 +$(next).fadeIn(0);
//             $('.pag a.nav-active-page').removeClass('next-question');
//             $('.pag a.nav-active-page').next().addClass('next-question');
//             $('.pag a.nav-active-page').removeClass('nav-active-page');
//             $('.pag a.next-question').addClass('nav-active-page');
    
//             $('input:radio[id^="answer-"]').change(function() {
//                 $('.pag > a.nav-active-page').addClass('nav-prev-page');
//             });
            
    
//             if (next == last_question) {
//                 $('.btn-next').hide();
//             } else {
//                 $('.btn-next').show();
//             }
//         });
//         } else {
//             $('.next-error').fadeOut(150, function() {
//                 $('.next-error').fadeIn(150);
//             });
//         }

// });



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
// -------------------------- ПОКАЗ ОШИБКИ ---------------------------- //
// -------------------------------------------------------------------- //
// -------------------------------------------------------------------- //

// $('.result-error').show();
// $('.result-error').fadeOut(150, function() {
//     $('.result-error').fadeIn(150);
// });

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
            $.ajax({
                url: 'test',
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
