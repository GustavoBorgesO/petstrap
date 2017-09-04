<?php
class Login extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->session->set_userdata(array('logado' => false)); // Setando a posição logado da sessão como falso
    }

    public function index()
    {
        $this->load->view('login', array('removido' => ''));
    }

    public function autenticar()
    {
        // Carregando a Model
        $this->load->model('Usuario_model', 'usuario', true); // Parâmetros: Classe da Model, Apelido (opcional), Conectar ao Banco
        $resultado = $this->usuario->buscarTodos(); // Chamando a função da model

        if(!empty($resultado)){
            foreach ($resultado as $linha) {
                // $this->input->post('login'): equivalente ao $_POST['login']
                if($this->input->post('login') === $linha->login){
                    if(md5($this->input->post('senha')) === $linha->senha){
                        $dadosSessao = array(
                            'id_usuario'  => $linha->id,
                            'nome'     => $linha->nome,
                            'tipo' => $linha->tipo,
                            'logado' => TRUE
                        );
                        $this->session->set_userdata($dadosSessao); // Setando os dados do usuário na sessão

                        echo true;
                    } else {
                        echo false;
                    }
                } else {
                    echo false;
                }
            }
        } else {
            echo false;
        }
    }

    public function sair()
    {
        $this->session->sess_destroy(); // Destruindo a sessão
        $this->load->view('login', array('removido' => ''));
    }
}
?>
