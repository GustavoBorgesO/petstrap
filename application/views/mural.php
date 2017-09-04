<!DOCTYPE HTML>
<html lang="pt">
<head>
    <meta charset='utf-8'>
    <title>Mural</title>
    <link rel="stylesheet" href="/codeigniter/application/libraries/css/bootstrap.css">
    
    <script src='/codeigniter/application/libraries/js/jquery-1.11.1.min.js'></script>
    <script src='/codeigniter/application/libraries/js/bootstrap.min.js'></script>
</head>
<body>
    
    <div class="jumbotron">
        <div class="row">
            <div class="col-xs-9 col-md-9">
                <h1>Mural Financeiro</h1>
                <h4>Insira suas receitas e despesas! <small></small></h4>
                <?php
                if($this->session->userdata('tipo') == "S"){
                    echo' <a id="novaMensagem" data-toggle="modal" data-target="#modalMsg"><span class="glyphicon glyphicon-plus"></span> Novo Registro</a>';
                }
                ?>
            </div>
            <div class="col-xs-3 col-md-3">

                <a id="alterarDados" href="/codeigniter/index.php/usuario/alterar"><span class="glyphicon glyphicon-edit"></span> Alterar</a>
                <a href="/codeigniter/index.php/login/sair"><span class="glyphicon glyphicon-log-out"></span> Sair</a>
            </div>
        </div>
    </div>
    <hr />
    <div id="mensagens">
        <?php
        if (count($lancamento) >0){
            echo '<table class="table">';
            echo " <thead>";
            echo "<tr>";
            echo "<th>Autor</th>";
            echo "<th>Natureza</th>";
            echo "<th>Descricao</th>";
            echo "<th>Valor(r$)</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($lancamento as $index => $coluna) {
                if ($index !== 'total') {
                 echo "<tr>";
                 echo "<td>".$coluna->autor."</td>";
                 echo "<td>".$coluna->natureza."</td>";
                 echo "<td>".$coluna->descricao."</td>";
                 echo "<td>".$coluna->valor."</td>";
                 echo "</tr>";

             }
         }
         echo "</tbody>";
         echo"<tfoot>";
         echo"<tr>";
         echo"<td colspan='3'>Total</td>";
         echo"<td>".$lancamento["total"]."</td>";
         echo"</tr>";

         echo"</tfoot>";
         echo '</table>';
     } else {
        echo '<div class="naoHaMensagem"><h4>Não há registros</h4></div>';
    }
    ?>

    <!----------------------------------------------------------- MODAL -------------------------------------------------------------->
    <div class="modal fade" id="modalMsg" tabindex="-1" role="dialog" aria-labelledby="modalMsgLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Novo Registro</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" id="formMensagem" action="/codeigniter/index.php/mural/enviar">
                        <div class="form-group">
                            <label>Autor</label>
                            <input type="text" class="form-control" disabled="disable" value="<?php echo $this->session->userdata('nome'); ?>">
                        </div>
                        <div class="form-group">
                            <label>Natureza do Registro</label><br>

                            <input type="radio" name="natureza" value="R" checked> Receita
                            
                            <input type="radio" name="natureza" value="D"> Despesa
                            
                        </div>
                        <div class="form-group">
                            <label>Valor</label><br>
                            <input type="text" name="valor" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Descricao</label><br>
                            <input type="text" name="descricao" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" id="btnEnviarMsg" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function() {

        $('#btnEnviarMsg').click(function() {
            $('#formMensagem').submit();
        })

    });
</script>

<style type="text/css">
    img{margin-left:10px;}
    a:hover{text-decoration: none;}


    .imagemMaior{max-width: 210px; max-height: 210px;display: block;}
    .imagemMenor{max-width: 95px; max-height: 95px;}
    .naoHaMensagem{padding-left: 10px;}
    .apagarMensagem{cursor: pointer;}

    #alterarDados{display:inline;margin-left: 13%;margin-right: 10%;}

    #mensagens{padding-top: 10px;max-height: 330px;overflow: auto;}
    #mensagens h4 > small{font-size: 63%}
    #mensagens::-webkit-scrollbar {width: 12px;}
    #mensagens::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 10px;
    }
    #mensagens::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 10px rgba(0,0,0,0.2);
    }

    .jumbotron{background-color: white; padding-top: 30px;padding-bottom: 30px;margin-bottom: 0;}
    .jumbotron h1, h4, #novaMensagem{margin-left: 100px;}
    #novaMensagem:hover{cursor: pointer;}

    #modalMsg .form-control:hover[disabled]{cursor: default;}
    #modalMsg textarea{resize:none;height: 80px;}
    #modalMsg .modal-footer{margin-top: 0;}
</style>

