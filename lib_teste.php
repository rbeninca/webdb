<?php
function getMySQLDataInfo($pdo) {
    $info = [];
    
    // Obter a lista de bancos de dados, excluindo os bancos de dados do sistema
    $databases = $pdo->query("SHOW DATABASES WHERE `Database` NOT IN ('information_schema', 'mysql', 'performance_schema', 'sys')")->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($databases as $db) {
        $info[$db] = [];
        
        // Obter as tabelas para cada banco de dados
        $tables = $pdo->query("SHOW TABLES FROM `$db`")->fetchAll(PDO::FETCH_COLUMN);
        foreach ($tables as $table) {
            // Obter os dados para cada tabela
            $info[$db][$table] = [];
            $rows = $pdo->query("SELECT * FROM `$db`.`$table`")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $info[$db][$table][] = $row;
            }
        }
    }
    
    return $info;
}


function getMongoDBDataInfo($manager) {
    $info = [];
    $info = [];

    // Listando todos os bancos de dados
    $command = new MongoDB\Driver\Command(['listDatabases' => 1]);
    $cursor = $manager->executeCommand('admin', $command); // Executando no banco de dados admin
    $databases = $cursor->toArray()[0]->databases;

    foreach ($databases as $database) {
        $dbName = $database->name;
        $info[$dbName] = [];

        // Listando coleções para cada banco de dados
        $command = new MongoDB\Driver\Command(['listCollections' => 1]);
        try {
            $cursor = $manager->executeCommand($dbName, $command);
            $collections = $cursor->toArray();

            foreach ($collections as $collection) {
                $collectionName = $collection->name;
                $info[$dbName][] = $collectionName;
            }
        } catch (Exception $e) {
            // Caso o usuário não tenha permissão para listar coleções deste banco de dados
            $info[$dbName]['error'] = "Erro ao listar coleções: " . $e->getMessage();
        }
    }

    return $info;
}

function addPerson($manager, $dbName, $collectionName, $personData) {
    try {
        $bulk = new MongoDB\Driver\BulkWrite; // Cria um novo BulkWrite object

        $bulk->insert($personData); // Prepara a inserção dos dados da pessoa

        // Executa a operação de inserção
        $result = $manager->executeBulkWrite("$dbName.$collectionName", $bulk);

        // Retorna o ID do documento inserido
        return $result->getInsertedCount() == 1 ? "Inserção bem-sucedida" : "Erro ao inserir";
    } catch (MongoDB\Driver\Exception\Exception $e) {
        // Em caso de erro, retorna a mensagem
        return 'Erro ao inserir pessoa: ' . $e->getMessage();
    }
}


?>