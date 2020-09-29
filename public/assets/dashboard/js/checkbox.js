$("#select-all").on('click', function () {
    $('input[type="checkbox"]').prop('checked', true);

    return false;
});

$("#deselect-all").on('click', function () {
    $('input[type="checkbox"]').prop('checked', false);

    return false;
});
