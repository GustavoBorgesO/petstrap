<!DOCTYPE HTML>
<html lang="pt">
<head>
    <meta charset='utf-8'>
    <title>Profile</title>
    <link rel="stylesheet" href="/codeigniter/application/libraries/css/bootstrap.css">
    <script src='/codeigniter/application/libraries/js/jquery-1.11.1.min.js'></script>
    <script src='/codeigniter/application/libraries/js/bootstrap.min.js'></script>

</head>
<body>
    <div class="bs-example">
        <div id="mensagem"><p class="text-success">Usuário <strong>atualizado</strong> com sucesso!</p></div>
        <form role="form" method="post" id="formUsuario">
            <div class="form-group">
                <label>Nome</label>
                <input type="text" class="form-control" name="nome" id="nome" value="<?php echo $nome; ?>">
            
            </div>

            <?php
            if(($this->session->userdata('logado') == true && $this->session->userdata('tipo') == "S") || $this->session->userdata('logado')== null ){
                $masculino = 'checked';
                if ($tipo === 'S') {
                    $sindico = 'checked';
                    $morador = '';
                } else {
                   $sindico = '';
                   $morador = 'checked';
               }
               echo'<div class="form-group">';
               echo'<label>tipo</label>';
               echo'<div>';
               echo'<label class="radio-inline">';
               echo'<input type="radio" name="tipo" value="M"  '.$morador.'> Morador';
               echo'</label>';
               echo'<label class="radio-inline">';
               echo'<input type="radio" name="tipo" value="S" '.$sindico.'> Sindico';
               echo'</label>';
               echo'</div>';
               echo'</div>';
           }
           ?>
           <div class="form-group">
            <label>Usuário</label>
            <input type="text" class="form-control" name="login" id="login" value="<?php echo $login; ?>">
        </div>
        <div class="form-group">
            <label>Senha</label>
            <input type="password" class="form-control" name="senha" id="senha">
        </div>
        <button type="button" class="btn btn-success flutuar-direita" id="btnSalvar">Concluir</button>
        <?php if($this->session->userdata('logado')): ?>
            <button type="button" class="btn btn-warning margem flutuar-direita" id="btnCancelar">Cancelar Conta</button>
        <?php endif; ?>
        <button type="button" class="btn btn-default margem flutuar-direita" id="btnVoltar">Voltar</button>
    </form>
</div>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        $('#mensagem').hide();
        $('#btnSalvar').click(function(){
            if(validaFormularioVazio() && validaUsuario() && validaSenha()){
                $('#btnSalvar').html('Aguarde...');
                $('#btnSalvar, #btnVoltar').addClass('disabled');
            // .serialize(): Serialize pega todos os campos do formulário e joga dentro do array
            $.post('/codeigniter/index.php/usuario/salvar', $('#formUsuario').serialize())
            .done(function(retorno){
                if(retorno === 'atualizar'){
                    $('#btnSalvar').html('Concluir');
                    $('#btnSalvar, #btnVoltar').removeClass('disabled');
                    $('#mensagem').fadeIn(600);
                } else if (retorno === 'inserir') {
                    $(location).attr('href', '/codeigniter/index.php/mural');
                } else {
                    $('#btnSalvar').html('Concluir');
                    $('#btnSalvar, #btnVoltar').removeClass('disabled');

                    $('#login').removeAttr('data-toggle');
                    $('#login').removeAttr('data-placement');
                    $('#login').removeAttr('data-original-title');
                    $('#login').tooltip('destroy');

                    $('#login').tooltip({
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'title': 'Usuário informado já está sendo usado!'
                    });

                    $('#login').tooltip('show');
                    $('.form-group:nth-child(3)').addClass('has-error');
                    $('#login').focus();
                }
            })
.always(function(){
    $('#senha').val('');
});
}
});

$('body').on('click', '#btnCancelar', function() {
    var content = '<button type="button" class="btn btn-default btn-sm cancelar">Cancelar</button>&nbsp';
    content += '<button type="button" id="cancelarConta" class="btn btn-danger btn-sm">Confirmar</button>';

    $('#btnCancelar').popover('destroy');
    $(this).popover({
        animation: true,
        html: true,
        placement: 'bottom',
        title: 'Deseja cancelar permanentemente sua conta?',
        content: content
    });
    $(this).popover('show');
    $('.popover-content').addClass('text-right');
});

$('body').on('click', '#cancelarConta', function() {
    $(location).attr('href', '/codeigniter/index.php/usuario/cancelar');
});

$('body').on('click', '.cancelar', function() {
    $('#btnCancelar').popover('hide');
});

$('#btnVoltar').click(function(){
    $(location).attr('href', '/codeigniter/index.php/mural');
});
});

function validaFormularioVazio(){
    for (var i = 0; i < $('.form-group input').length; i++) {
        if($.trim($('.form-group input')[i].value) === ""){
            removerTooltip();

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

function validaSenha(){
    removerTooltip();
    if($('#senha').val().length < 4){
        $('#senha').attr({
            'data-toggle': 'tooltip',
            'data-placement': 'bottom',
            'title': 'A senha deverá ter no mínimo 4 caracteres'
        });
        $('#senha').tooltip('show');
        $('#senha').focus();
        return false;
    }

    return true;
}

function validaUsuario(){
    removerTooltip();
    if($('#login').val().length < 4){
        $('#login').attr({
            'data-toggle': 'tooltip',
            'data-placement': 'bottom',
            'title': 'O usuário deverá ter no mínimo 4 caracteres'
        });
        $('#login').tooltip('show');
        $('#login').focus();
        return false;
    }

    return true;
}

function removerTooltip()
{
    $('.form-group input').removeAttr('data-toggle');
    $('.form-group input').removeAttr('data-placement');
    $('.form-group input').removeAttr('title');
    $('.form-group input').tooltip('destroy');
}
</script>
<style type="text/css">
    #mensagem{text-align: center;}
    .flutuar-direita{float: right;}
    .margem{margin-right: 5px;}
</style>
