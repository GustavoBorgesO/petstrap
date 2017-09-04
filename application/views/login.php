<!DOCTYPE HTML>
<html lang="pt">
    <head>
        <meta charset='utf-8'>
        <title>Entrar</title>
        <link rel="stylesheet" href="/codeigniter/application/libraries/css/bootstrap.css">
        
        <script src='/codeigniter/application/libraries/js/jquery-1.11.1.min.js'></script>
        <script src='/codeigniter/application/libraries/js/bootstrap.min.js'></script>
    </head>
    <body>
        <div class="bs-example">
            <div id="mensagem"><p class="text-success">Usuário <strong>cancelado</strong> com sucesso!</p></div>
            <form role="form" method="post" id="formLogin">
                <div class="form-group">
                    <label>Usuário</label>
                    <input type="text" class="form-control" name="login" id="login">
                </div>
                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" class="form-control" name="senha" id="senha">
                </div>
                <a href="/codeigniter/index.php/usuario/cadastro">É novo por aqui? Cadastre-se!</a>
                <button type="button" class="btn btn-default" id="btnEntrar">Entrar</button>
            </form>
        </div>
    </body>
</html>
<script type='text/javascript'>
$(document).ready(function(){
    $('#mensagem').hide();

    if('<?php echo $removido; ?>' === 'removido'){
        $('#mensagem').fadeIn(600);
    }

    $(document).keypress(function(e) {
        if(e.which == 13) {
            autenticar();
        }
    });

    $('#btnEntrar').click(function(){
        if(validaFormulario()){
            autenticar();
        }
    });
});

function validaFormulario(){
    for (var i = 0; i < $('.form-group input').length; i++) {
        if($.trim($('.form-group input')[i].value) === ""){
            $('.form-group').removeClass('has-error');
            $('.form-group input').removeAttr('data-toggle');
            $('.form-group input').removeAttr('data-placement');
            $('.form-group input').removeAttr('title');
            $('.form-group input').tooltip('destroy');

            $($('.form-group')[i]).addClass('has-error');
            $('#' + $('.form-group input')[i].id).attr({
                'data-toggle': 'tooltip',
                'data-placement': 'bottom',
                'title': 'Preenchimento obrigatório'
            });
            $('#' + $('.form-group input')[i].id).tooltip('show');
            $('#' + $('.form-group input')[i].id).focus();
            return false;
        }
    }

    return true;
}

function autenticar(){
    $.post('/codeigniter/index.php/login/autenticar', $('#formLogin').serialize())
    .done(function(retorno){
        if(retorno){
            $(location).attr('href', '/codeigniter/index.php/mural');
        } else {
            $('.form-group input').tooltip('destroy');
            $('#login').attr({
                'data-toggle': 'tooltip',
                'data-placement': 'bottom',
                'title': 'Usuário ou senha incorretos'
            });
            $('form .form-group:first-child').addClass('has-error');
            $('#login').tooltip({container: 'body'});
            $('#login').focus();
            $('#login').tooltip('show');
        }
    });
}
</script>
<style type="text/css">
a{font-size: 12px;}
#mensagem{text-align: center;}
.btn-default{float: right;}
</style>
