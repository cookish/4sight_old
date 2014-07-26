$(document).ready(function () {
    $('.table tr:not(:first)').click(function (event) {
        // alert($(this).attr('id')); //trying to alert id of the clicked row
        window.location = URL + '/people/' +  $(this).attr("id");
    });
});