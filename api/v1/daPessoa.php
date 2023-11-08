<?php
    include_once 'daPessoaMysql.php';
    include_once  'daPessoaMongo.php';
    class daPessoa{
        private $daPessoaMysql;
        private $daPessoaMongo;

        public function __construct() {
            $this->$daPessoaMysql=new DaPessoaMysql();

        }
        /* classe que implementa  inserir, remover, update e delete suporte aos dois banco deados mysql e mongo, intanciando e usando os metodos de DAPessoaMongo DAPessoaMysql */
        public function inserir($nome, $sobrenome, $email, $idade){
            $this->daPessoaMysql->inserir($nome, $sobrenome, $email, $idade);
            $this->daPessoaMongo->inserir($nome, $sobrenome, $email, $idade);
    
        }
        public function remover($id){
            $this->daPessoaMysql->remover($id);
            $this->daPessoaMongo->remover($id);
    
        }
        public function update($id, $nome, $sobrenome, $email, $idade){
            $this->daPessoaMysql->update($id, $nome, $sobrenome, $email, $idade);
            $this->daPessoaMongo->update($id, $nome, $sobrenome, $email, $idade);
    
        }
        public function delete($id){
            $this->daPessoaMysql->delete($id);
            $this->daPessoaMongo->delete($id);
    
        }
        public function listar(){       
            return $this->daPessoaMysql->listar();
            $this->daPessoaMongo->listar();
            
    
        }
        

    }
     
?>