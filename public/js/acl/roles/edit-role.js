$(document).ready(function () {
    $("#checkTodos").click(function () {
        if ( $(this).is(':checked') ){
            $('.permissao').attr("checked", true);
        }else{
            $('.permissao').attr("checked", false);
        }
    });
});

