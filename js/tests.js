$("body").on('click', '.page_btn', function() {
    console.log($(this).attr('id'));
    $(this).addClass("active");
});