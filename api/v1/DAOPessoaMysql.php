<?php
include_once 'Database.php';
class DAOPessoaMysql {
    private $db;
    private $connection;
    
    public function __construct() {
        $this->db = new Database();
        $this->connection = $this->db->getConnection();
    }

    public function inserir(Pessoa $pessoa) {
        // Preparar o statement para inserção de dados no banco
        $query = "INSERT INTO pessoas (nome, sobrenome, email, idade) VALUES (:nome, :sobrenome, :email, :idade)";
        $stmt = $this->connection->prepare($query);

        //bind data
        $stmt->bindParam(":nome", $pessoa->getNome());
        $stmt->bindParam(":sobrenome", $pessoa->getSobrenome());
        $stmt->bindParam(":email", $pessoa->getEmail());
        $stmt->bindParam(":idade", $pessoa->getIdade());
        //Return id of inserted row
        if ($stmt->execute()) {
           //  convert string to int 
              return (int)$this->connection->lastInsertId(); 
        }
        return false;
        
    }


    public function listarTodos(){
        $query = "SELECT * FROM pessoas";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        //Retorna lista de objetos Pessoa
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pessoa');
        $result = $stmt->fetchAll();
        return  $result;
    }
    //metodo para deletar uma pessoa que recebe id como parametro 
    public function delete($id){
        $query = "DELETE FROM pessoas WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    //metodo para para atualizar dados de umas pessoa
    public function update($pessoa){
        $query = "UPDATE pessoas SET nome = :nome, sobrenome = :sobrenome, email = :email, idade = :idade WHERE id = :id";
        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(":id", $pessoa->getId());
        $stmt->bindParam(":nome", $pessoa->getNome());
        $stmt->bindParam(":sobrenome", $pessoa->getSobrenome());
        $stmt->bindParam(":email", $pessoa->getEmail());
        $stmt->bindParam(":idade", $pessoa->getIdade());
        if ($stmt->execute()) {
            return true;
        }
        return false;
        
    }
}

?>