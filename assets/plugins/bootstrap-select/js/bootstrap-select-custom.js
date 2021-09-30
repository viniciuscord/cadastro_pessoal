/*referencie os elementos com a classe .bootstrap-select-form*/

$('.dropdown-menu').css('box-shadow', '0px 0px 25px rgba(0, 0, 0, 0.3)');

$('.actions-btn').removeClass('btn-default');

$(".bootstrap-select-form .btn-group button:nth-child(1)").addClass('btn-primary');
$(".bootstrap-select-form .btn-group button:nth-child(2)").addClass('btn-warning');

$('.bootstrap-select-form .btn-group > .btn-close').remove();

$('.bootstrap-select-form .btn-group').append('<button class="actions-btn btn btn-success btn-close" type="button">OK</button>');

$('.btn-close').click(function (e) {
    var btn = $(this),
        selectpicker = btn.parents('.dropdown-menu').siblings('.bootstrap-select-form').selectpicker('toggle');
    return false;
});