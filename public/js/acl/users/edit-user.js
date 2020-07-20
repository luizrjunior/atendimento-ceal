function abrirCard(card) {
    $('#divCardAddRoleUser').hide();
    $('#divCardListRolesUser').show();
    if (card == 2) {
        $('#divCardListRolesUser').hide();
        $('#divCardAddRoleUser').show();
    }
}

function loadPermissionsRoleJson() {
    var formURL = top.routeLoadPermissionsRoleJson;
    $.ajax({
        type: 'POST',
        url: formURL,
        data: { 
            _token: $("input[name='_token']").val(),
            role_id: $("#role_id").val() 
        },
        dataType: "json",
        success: function (data) {
            var valores = "";
            $('#permissoes').val('');
            $.each(data, function (i, d) {
                valores = valores + d.name + '; ';
            });
            $('#permissoes').val(valores);
        }
    });
}

$(document).ready(function () {
    $("#role_id").change(function () {
        loadPermissionsRoleJson();
    });
    abrirCard(1);
});

