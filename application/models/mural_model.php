<?php
class Mural_model extends CI_Model {
    private $id;
    private $idAutor;
    private $mensagem;

    function __construct()
    {
        parent::__construct();
    }

    public function buscarTodos()
    {
        /* A query que será montada será essa:
            SELECT `mural`.id, `mural`.mensagem, `mural`.id_autor, `usuarios`.nome AS autor
            FROM `mural`
            INNER JOIN `usuarios` ON `mural`.id_autor = `usuarios`.id
        */
        // $this->db->select('mural.id, mural.mensagem, mural.id_autor, usuarios.nome AS autor, usuarios.tipo AS tipo_autor, mural.data_publicacao');
        // $this->db->from('mural');
        // $this->db->join('usuarios', 'mural.id_autor = usuarios.id', 'inner');
        // $this->db->order_by('data_publicacao', 'desc');
        // $resultado = $this->db->get();
             $this->db->select('lancamentos.*, usuarios.nome AS autor');
        $this->db->from('lancamentos');
        $this->db->join('usuarios', 'lancamentos.idUsuario = usuarios.id', 'inner');
        $this->db->order_by('autor');
        
        $resultado = $this->db->get();

        // Foi necessário fazer isto pra que a data viesse formatada na hora de montar lista em php e em javascript
        $retornoFormatado = array();
        
        $totalCaixa = 0;
        $totalDespesa = 0;
        
        foreach($resultado->result() as $row){
            if ($row->natureza == "R" ) {
                $row->natureza = "Receita";
                $totalCaixa += $row->valor;
            } else {
                $row->natureza = "Despesa";
                $totalDespesa += $row->valor;
            }

            $row->valor = number_format($row->valor,2,"," , ".");
            $retornoFormatado[] = $row;

        }
        $retornoFormatado["total"] = number_format(($totalCaixa - $totalDespesa),2,"," , ".");

        return $retornoFormatado;
    }


    public function inserir()
    {
        $this->db->set('idUsuario', $this->idAutor);
        $this->db->set('natureza', $this->natureza);
        $this->db->set('valor', $this->valor);
        $this->db->set('descricao', $this->descricao);
        $this->db->insert('lancamentos');
    }

    public function apagarMensagensAutor()
    {
        $this->db->where('idUsuario', $this->idAutor);
        $this->db->delete('lancamentos');
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setIdAutor($idAutor)
    {
        $this->idAutor = $idAutor;
        return $this;
    }

    public function setNatureza($natureza)
    {
        $this->natureza = $natureza;
        return $this;
        
    }

    public function setValor($valor)
    {
        $this->valor = str_replace(",", ".", str_replace(".","", $valor));
        
        return $this;

    }
     public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
        
    }


}

    