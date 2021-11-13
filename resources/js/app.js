require('./bootstrap');

Array.from(document.getElementsByClassName('dropdown')).forEach(function(elA) {
    elA.addEventListener('click', function(e) {
        var dropdownIcon = e.currentTarget.getElementsByClassName('mdi')[0];

            e.currentTarget.parentNode.classList.toggle('active');
            dropdownIcon.classList.toggle('mdi-plus');
            dropdownIcon.classList.toggle('mdi-minus');
    });
});
