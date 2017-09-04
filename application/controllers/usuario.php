<?php
class Usuario extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
    }
    //serve para verificar se o usuario esta loga, caso esteja ele encaminha para o mural e caso nao esteja ele manda pra tela de login
    public function index()
    {
        if($this->session->userdata('logado')){
            $this->load->view('mural');
        } else {
            $this->load->view('login');
        }
    }

    public function alterar()
    {
        if($this->session->userdata('logado')){
            // Carregando a Model
            $this->load->model('Usuario_model', 'usuario', true); 
            $this->usuario->setId($this->session->userdata('id_usuario')); // Parâmetro: equivalente ao $_SESSION['id_usuario']
            $resultado = $this->usuario->buscarPorId();

            $this->load->view('usuario', $resultado);
        } else {
            $this->load->view('login');
        }
    }

    public function cadastro()
    {
        $dados = array('nome' => '', 'login' => '', 'tipo' => '');
        $this->load->view('usuario', $dados);
    }

    public function salvar()
    {
        $this->load->model('Usuario_model', 'usuario', true); // Parâmetros: Classe da Model, Apelido (opcional), Conectar ao Banco
        $this->usuario->setId($this->session->userdata('id_usuario'));
        $this->usuario->setNome($this->input->post('nome'));
        $this->usuario->setLogin($this->input->post('login'));
        $this->usuario->setSenha(md5($this->input->post('senha'))); // Convertendo a senha em MD5
        $this->usuario->setTipo($this->input->post('tipo'));

        //verifica se existe sessao aberta para saber se vai atualizar ou cadastras um
        if($this->session->userdata('logado')){
            $dadosAtualizados = $this->usuario->atualizar();
            $dadosSessao = array(
                'id_usuario'  => $dadosAtualizados->id,
                'nome'     => $dadosAtualizados->nome,
                'tipo' => $dadosAtualizados->tipo,
                'logado' => TRUE
            );
            $this->session->set_userdata($dadosSessao);
            echo 'atualizar';
        } else {
            //garante que nao vai haver o cadastro de dados duplicados 
            if($this->usuario->buscarPorLogin()){
                $dadosInseridos = $this->usuario->inserir();

                $dadosSessao = array(
                    'id_usuario'  => $dadosInseridos->id,
                    'nome'     => $dadosInseridos->nome,
                    'tipo' => $dadosInseridos->tipo,
                    'logado' => TRUE
                );
                $this->session->set_userdata($dadosSessao);
                echo 'inserir';
            } else {
                echo 'falhou';
            }
        }
    }

    public function cancelar()
    {
        $this->load->model('Mural_model', 'mural', true);
        $this->mural->setIdAutor($this->session->userdata('id_usuario'));
        $this->mural->apagarMensagensAutor();
        unset($this->mural);

        $this->load->model('Usuario_model', 'usuario', true);
        $this->usuario->setId($this->session->userdata('id_usuario'));
        $this->usuario->apagar();
        $this->session->sess_destroy();
        $this->load->view('login', array('removido' => 'removido'));
    }
}
?>
