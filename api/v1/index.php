<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers");
// Inclua as classes necessárias
require_once 'Database.php';
require_once 'PessoaController.php';

// Obter o método de requisição
$method = $_SERVER['REQUEST_METHOD'];

// Instanciar o controller
$controller = new PessoaController();

// Tratamento básico de rotas com base no método utilizado pelo usuário

switch($method) {
    case 'GET':
        // Aqui você pode adicionar a lógica para listar pessoas ou buscar por uma pessoa específica
        $result = $controller->list();
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
            $result = $controller->create($data->nome, $data->sobrenome, $data->email, $data->idade);
            if($result) {
                // Responder com sucesso
                http_response_code(201);
                echo json_encode(array("message" => "Pessoa criada com sucesso."));
            } else {
                // Responder com erro
                http_response_code(503); // Serviço indisponível
                echo json_encode(array("message" => "Não foi possível criar a pessoa."));
            }
        } else {
            // Responder que os dados estão incompletos
            http_response_code(400); // Requisição inválida
            echo json_encode(array("message" => "Não foi possível criar a pessoa. Dados incompletos."));
        }
        break;
    case 'PUT':
        // Decodifica o corpo da requisição que contém os dados da pessoa
        $data = json_decode(file_get_contents("php://input"), true);

        

        // Supondo que você tenha uma função para atualizar pessoas e está passando um ID e os dados
        $id = $data['id']; // ou obter de alguma outra forma, como por exemplo do URL
        $nome = $data['nome'];
        $sobrenome = $data['sobrenome'];
        $email = $data['email'];
        $idade = $data['idade'];

        // Chama a função de atualização com os dados recebidos
        $resultado = $controller->update($id, $nome, $sobrenome, $email, $idade);

        // Retorna a resposta apropriada
        if ($resultado) {
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
        echo json_encode(array("message" => "Método não suportado."));
        break;
}

?>