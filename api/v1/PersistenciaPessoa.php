<?php
    include_once 'DAOPessoaMysql.php';
    
    class PersistenciaPessoa{
        private $daoPessoaMysql;
        

        public function __construct() {
            $this->daoPessoaMysql=new DAOPessoaMysql();
            
        }
        /* classe que implementa  inserir, remover, update e delete suporte aos dois banco deados mysql e mongo, intanciando e usando os metodos de DAPessoaMongo DAPessoaMysql */
        public function inserir($pessoa){
            $idUsuario=$this->daoPessoaMysql->inserir($pessoa);
            return $idUsuario;
        }
        public function remover($id){
            $pessoa=new Pessoa($id);
            $this->daoPessoaMysql->remover($pessoa);
    
        }
        public function update($pessoa){
            return $this->daoPessoaMysql->update($pessoa);

        }
        public function delete($id){
            return $this->daoPessoaMysql->delete($id);

            
        }
        public function listarTodos(){  
            //retorna array de objeto Pessoa
                $result= $this->daoPessoaMysql->listarTodos();
                return $result;
               
            
         
            
    
        }
        

    }
     
?>