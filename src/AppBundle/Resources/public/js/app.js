$(function () {
    setupUi();
});
function setupUi() {
    $(':input').addClass('ui-widget-content');
    $('input[type="submit"], .button, #footer a').button();
    $('th').addClass('ui-widget-header');
    $('.tree').menu();
}
function cagetoryModal($url) {
    console.log($url);
    $(function () {
        $("#modal").dialog({
            modal: true,
            buttons: {
                Ok: function () {
                    $(this).dialog("close");
                }
            }
        });
        $('#modal').load($url);
    });
}
