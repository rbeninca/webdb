<?php
    // Definição da classe de entidade pessoa 
    class Pessoa {
        // Atributos da classe
        public $id;
        public $nome;
        public $sobrenome;
        public $email;
        public $idade;
        
        public function setAllData($id =null, $nome, $sobrenome, $email, $idade) {
            $this->id = $id;
            $this->nome = $nome;
            $this->sobrenome = $sobrenome;
            $this->email = $email;
            $this->idade = $idade;
        }
        
        
        // Métodos de acesso aos atributos
        public function getId() {
            return $this->id;
        }
        public function getNome() {
            return $this->nome;
        }
        public function getSobrenome() {
            return $this->sobrenome;
        }
        public function getEmail() {
            return $this->email;
        }
        public function getIdade() {
            return $this->idade;
        }
    }
?>