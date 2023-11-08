<?php
include_once 'PersistenciaPessoa.php';
include_once 'Pessoa.php';

class PessoaController {
    private $PersistenciaPessoa;
    public function __construct() {
        $this->PersistenciaPessoa = new PersistenciaPessoa();
    }
    

    public function cadastrarNovaPessoa(Pessoa $pessoa) {
        //Sanetizaação dos dados
        $pessoa->nome=filter_var($pessoa->getNome(), FILTER_SANITIZE_STRING);
        $pessoa->sobrenome=filter_var($pessoa->getSobrenome(), FILTER_SANITIZE_STRING);
        $pessoa->email=filter_var($pessoa->getEmail(), FILTER_SANITIZE_EMAIL);
        $pessoa->idade=filter_var($pessoa->getIdade(), FILTER_SANITIZE_NUMBER_INT);
    
        //Chama o metodo inserir da classe PersistenciaPessoa
        return $this->PersistenciaPessoa->inserir($pessoa);    
        
    }


    public function recuperaListaPessoas(){
        $result=$this->PersistenciaPessoa->listarTodos();
        //transforma o array de objetos em um array de arrays
        $result = json_decode(json_encode($result), true);
        return  $result;
    }
    //metodo para deletar uma pessoa que recebe id como parametro 
    public function delete($id){
        return $this->PersistenciaPessoa->delete($id);
    }
    //metodo para para atualizar dados de umas pessoa
    public function update($pessoa){
         return $this->PersistenciaPessoa->update($pessoa);
    }


    // ... outros métodos para ler, atualizar e deletar
}
?>
