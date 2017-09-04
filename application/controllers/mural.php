<?php
class Mural extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if($this->session->userdata('logado')){
            $this->load->model('Mural_model', 'mural', true);
            $mensagens = $this->mural->buscarTodos();
            $this->load->view('mural', array('lancamento' => $mensagens));
        } else {
            $this->load->view('login', array('removido' => ''));
        }
    }

    public function apagar()
    {
        $this->load->model('Mural_model', 'mural', true);
        $this->mural->setId($this->input->post('id'));
        $this->mural->apagar();
    }

    public function enviar()
    { 
        $this->load->model('Mural_model', 'mural', true);
        $this->mural->setIdAutor($this->session->userdata('id_usuario'));
        $this->mural->setNatureza(trim($this->input->post('natureza')));
        $this->mural->setValor(trim($this->input->post('valor')));
        $this->mural->setDescricao(trim($this->input->post('descricao')));
        $this->mural->inserir();
        header('Location: /codeigniter/index.php/mural');
    }
}
?>
