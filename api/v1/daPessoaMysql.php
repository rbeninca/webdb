<?php
class DaPessoaMysql {
    private $db;
    private $connection;
    
    public function __construct() {
        $this->db = new Database();
        $this->connection = $this->db->getConnection();
    }

    public function inserir($nome, $sobrenome, $email, $idade) {
        // Preparar o statement para inserção de dados no banco
        $query = "INSERT INTO pessoas (nome, sobrenome, email, idade) VALUES (:nome, :sobrenome, :email, :idade)";
        $stmt = $this->connection->prepare($query);


        //Sanetização dados 
        $nome = htmlspecialchars(strip_tags($nome));
        $sobrenome = htmlspecialchars(strip_tags($sobrenome));
        $email = htmlspecialchars(strip_tags($email));
        $idade = htmlspecialchars(strip_tags($idade));
        //bind data
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":sobrenome", $sobrenome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":idade", $idade);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    public function listar(){
        $query = "SELECT * FROM pessoas";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //retorna um array de pessoas em formato json


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
    public function update($id, $nome, $sobrenome, $email, $idade){
        $query = "UPDATE pessoas SET nome = :nome, sobrenome = :sobrenome, email = :email, idade = :idade WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":sobrenome", $sobrenome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":idade", $idade);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

?>