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
        $('#dtBasicExample2').DataTable();
        $('.dataTables_length').addClass('bs-select');
      });
      








      const searchInputSidenav2 = document.getElementById('search-input-sidenav2');
      const sidenavOptions2 = document.querySelectorAll('#sidenav-3 div .sidenav-link');
      console.log(searchInputSidenav2);
      searchInputSidenav2.addEventListener('input', () => {
          const filter = searchInputSidenav2.value.toLowerCase();
          showSidenavOptions2();
          const valueExist = !!filter.length;
  
          if (valueExist) {
              sidenavOptions2.forEach((el) => {
                  const elText = el.textContent.trim().toLowerCase();
                  const isIncluded = elText.includes(filter);
                  if (!isIncluded) {
                      el.style.display = 'none';
                  }
              });
          }
      });
  
      const showSidenavOptions2 = () => {
          sidenavOptions2.forEach((el) => {
              el.style.display = 'table-row';
          });
      };
          
      $(document).ready(function () {
          $('#dtBasicExample').DataTable();
          $('.dataTables_length').addClass('bs-select');
        });





      


});