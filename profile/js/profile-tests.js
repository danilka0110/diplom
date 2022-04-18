$(function() {   

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


    const searchInputSidenav = document.getElementById('search-input-sidenav');
    const sidenavOptions = document.querySelectorAll('#sidenav-3 div .sidenav-link');

    searchInputSidenav.addEventListener('input', () => {
        const filter = searchInputSidenav.value.toLowerCase();
        showSidenavOptions();
        const valueExist = !!filter.length;

        if (valueExist) {
            sidenavOptions.forEach((el) => {
                const elText = el.textContent.trim().toLowerCase();
                const isIncluded = elText.includes(filter);
                if (!isIncluded) {
                    el.style.display = 'none';
                }
            });
        }
    });

    const showSidenavOptions = () => {
        sidenavOptions.forEach((el) => {
            el.style.display = 'table-row';
        });
    };
        
	$(document).ready(function () {
        $('#dtBasicExample').DataTable();
        $('.dataTables_length').addClass('bs-select');
      });
    


      $("body").on('click', '.btn-show-my-tests-in-profile', function() {
        $('.breadcrumb-item.active').html('Мои тесты');
        $('.btn-show-profile-tests').removeClass('active');
        $(this).addClass('active');
        $('.my-passes-tests').hide();
        $('.my-tests').show();
    });

    $("body").on('click', '.btn-show-my-passes-tests-in-profile', function() {
        $('.breadcrumb-item.active').html('Пройденные тесты');
        $('.btn-show-profile-tests').removeClass('active');
        $(this).addClass('active');
        $('.my-tests').hide();
        $('.my-passes-tests').show();
    });

    $("body").on('click', '.btn-test-create', function() {
        $('.btn-show-profile-tests').removeClass('active');
    });



   

    document.querySelector('#search_test').oninput = function() {
        let val = this.value.trim();
        let elasticItems = document.querySelectorAll('.elastic');
        if (val != '') {
            elasticItems.forEach(function(elem) {
                if (elem.innerText.toLowerCase().search(val.toLowerCase()) == -1) {
                    elem.classList.add('none');
                }
                else {
                    elem.classList.remove('none');
                }
            });
        }
        else {
            elasticItems.forEach(function(elem) {
                elem.classList.remove('none');
            });
        }
    }




});