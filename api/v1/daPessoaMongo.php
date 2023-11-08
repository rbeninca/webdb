<?php


class DaPessoaMongo {
    private $collection;

    public function __construct() {
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $this->collection = $client->nomeDoBancoDeDados->nomeDaColecao;
    }

    public function create($nome, $sobrenome, $email, $idade) {
        $insertOneResult = $this->collection->insertOne([
            'nome' => htmlspecialchars(strip_tags($nome)),
            'sobrenome' => htmlspecialchars(strip_tags($sobrenome)),
            'email' => htmlspecialchars(strip_tags($email)),
            'idade' => htmlspecialchars(strip_tags($idade))
        ]);

        return $insertOneResult->isAcknowledged();
    }

    public function list() {
        $people = $this->collection->find()->toArray();
        return json_encode($people);
    }

    public function delete($id) {
        $deleteResult = $this->collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
        return $deleteResult->isAcknowledged();
    }

    public function update($id, $nome, $sobrenome, $email, $idade) {
        $updateResult = $this->collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            ['$set' => [
                'nome' => htmlspecialchars(strip_tags($nome)),
                'sobrenome' => htmlspecialchars(strip_tags($sobrenome)),
                'email' => htmlspecialchars(strip_tags($email)),
                'idade' => htmlspecialchars(strip_tags($idade))
            ]]
        );
    
        return $updateResult->isAcknowledged();
    }
}


?>
