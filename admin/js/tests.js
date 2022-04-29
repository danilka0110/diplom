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