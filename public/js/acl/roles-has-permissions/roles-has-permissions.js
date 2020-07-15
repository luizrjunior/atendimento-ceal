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

    $("#checkTodos").click(function () {
        if ( $(this).is(':checked') ){
            $('.permissao').attr("checked", true);
        }else{
            $('.permissao').attr("checked", false);
        }
    });
});

