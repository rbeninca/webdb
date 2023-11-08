<?php
// Definir cabeçalhos da requisição que o formato de resposta será JSON
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers");


// Inclua as classes necessárias
require_once 'PessoaController.php';
include_once 'Pessoa.php';

// Obter o método de requisição
$method = $_SERVER['REQUEST_METHOD'];

// Instanciar o controller
$controller = new PessoaController();

// Tratamento básico de rotas com base no método utilizado pelo usuário

switch($method) {
    case 'GET':
        // Aqui você pode adicionar a lógica para listar pessoas ou buscar por uma pessoa específica
        $result = $controller->recuperaListaPessoas();
        if(count($result) > 0) {
            // Responder com sucesso
            http_response_code(200);
            echo json_encode($result);
        } else {
            // Responder que não há pessoas cadastradas
            http_response_code(404); // Não encontrado
            //caso vazio o json deve retornar um json vazio
            echo json_encode(array());
        }
        break;
    case 'POST':
        // Decodificar o corpo da requisição JSON
        $data = json_decode(file_get_contents("php://input"));
        // Verificar se os dados necessários foram enviados
        if(!empty($data->nome) && !empty($data->sobrenome) && !empty($data->email) && !empty($data->idade)) {
            // Chamar o método para criar uma pessoa
            $controller = new PessoaController();
            
            $pessoa=new Pessoa();
            $pessoa->nome=$data->nome;
            $pessoa->sobrenome=$data->sobrenome;
            $pessoa->email=$data->email;
            $pessoa->idade=$data->idade;
            

            $result=$controller->cadastrarNovaPessoa($pessoa);
            if($result>0) {
                // Responder com sucesso
                http_response_code(201);
                echo json_encode(array("mensagem" => "Pessoa cadastrada com sucesso."));
            } else {
                // Responder com erro
                http_response_code(503); // Serviço indisponível
                echo json_encode(array("mensagem" => "Não foi possível criar a pessoa."));
            }
        } else {
            // Responder que os dados estão incompletos
            http_response_code(400); // Requisição inválida
            echo json_encode(array("mensagem" => "Não foi possível criar a pessoa. Dados incompletos."));
        }
        break;
    case 'PUT':
        // Decodifica o corpo da requisição que contém os dados da pessoa
        $data = json_decode(file_get_contents("php://input"), true);
        // Supondo que você tenha uma função para atualizar pessoas e está passando um ID e os dados
        $pessoa=new Pessoa();
        $pessoa->id=$data['id'];
        $pessoa->nome=$data['nome'];
        $pessoa->sobrenome=$data['sobrenome'];
        $pessoa->email=$data['email'];
        $pessoa->idade=$data['idade'];
        $result=$controller->update($pessoa);
        if ($result) {
            echo json_encode(['mensagem' => 'Pessoa atualizada com sucesso']);
        } else {
            // Tratamento de erro, por exemplo, se a pessoa com o ID fornecido não existe
            http_response_code(404);
            echo json_encode(['mensagem' => 'Pessoa não encontrada']);
        }
        break;

    case 'DELETE':
        // Suponha que você obtém o ID da pessoa a ser deletada do URL ou do corpo da requisição
        $id = $_GET['id']; // ou qualquer outra lógica para obter o ID

        // Chama a função de exclusão passando o ID da pessoa
        $resultado = $controller->delete($id);

        // Retorna a resposta apropriada
        if ($resultado) {
            echo json_encode(['mensagem' => 'Pessoa deletada com sucesso']);
        } else {
            // Tratamento de erro, por exemplo, se a pessoa com o ID fornecido não existe
            http_response_code(404);
            echo json_encode(['mensagem' => 'Pessoa não encontrada']);
        }
        
        break;
    default:
        // Método não suportado
        http_response_code(405); // Método não permitido
        echo json_encode(array("mensagem" => "Método não suportado."));
        break;
}

?>