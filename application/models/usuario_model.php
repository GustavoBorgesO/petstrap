<?php
class Usuario_model extends CI_Model {
    private $id;
    private $nome;
    private $login;
    private $senha;
    private $tipo;

    public function __construct()
    {
        parent::__construct();
    }

    public function buscarTodos()
    {
        $resultado = $this->db->get('usuarios');
        return $resultado->result();
    }

    public function buscarPorLogin()
    {
        $resultado = $this->db->get_where('usuarios', array('login' => $this->login));
        $dados = $resultado->result();
        if(!empty($dados)){
            return false;
        } else {
            return true;
        }
    }

    public function buscarPorId()
    {
        $resultado = $this->db->get_where('usuarios', array('id' => $this->id));
        foreach ($resultado->result() as $row)
        {
            $retorno = $row;
        }

        return $retorno;
    }

    public function atualizar()
    {
        $data = array('nome' => $this->nome, 'login' => $this->login, 'senha' => $this->senha, 'tipo' => $this->tipo);
        $this->db->where('id', $this->id);
        $this->db->update('usuarios', $data);
        return $this->buscarPorId();
        // Pode ser usado dessa forma também:
        //$this->db->update('usuarios', $data, "id = {$this->id}"); // Parâmetros: Tabela, dados a serem modificados, clausula where
    }

    public function inserir()
    {
        $data = array('nome' => $this->nome, 'login' => $this->login, 'senha' => $this->senha, 'tipo' => $this->tipo);
        $this->db->insert('usuarios', $data);
        $this->setId($this->db->insert_id());
        return $this->buscarPorId();
    }

    public function apagar()
    {
        $this->db->where('id', $this->id);
        $this->db->delete('usuarios');
    }

    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
        return $this;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }
}

