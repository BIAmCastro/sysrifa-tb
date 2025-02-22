<?php

//obter a conexão com o banco
include('../../conexao/conn.php');

//obter os dados enviados do formulario
$requestData = $_REQUEST;

//vrificação de campos obrigatorios
if(empty($requestData['NOME'])){
    //variavel vazia retornar erro
    $dados  = array(
        "tipo" => 'error',
        "mensagem" => 'Campos obrigatórios não preenchidos.'

    );


} else {
    //se estiver preenchidos
    $ID = isset($requestData['ID']) ? $requestData['ID'] : '';
    $operacao = isset($requestData['operacao']) ? $requestData['operacao'] : '';

    //verificação cadastro
    if($operacao == 'insert'){
        //insert banco
        try{
            $stmt = $pdo->prepare('INSERT INTO TIPO (NOME) VALUES (:a)');
            $stmt->execute(array(
    ':a' => utf8_decode($requestData['NOME'])
));
$dados  = array(
    "tipo" => 'success',
    "mensagem" => 'registro concluido com sucesso'

);


        }catch(PDOException $e){
            $dados  = array(
                "tipo" => 'erro',
                "mensagem" => 'não foi possivel concluir o registro: '.$e

        
            );
        }
    } else{
        //se a operação vir vazia fazer update
        try{
            $stmt = $pdo->prepare('UPDATE TIPO SET NOME = :a WHERE ID = :id');
            $stmt->execute(array(
                ':id' => $ID, 
    ':a' => utf8_decode($requestData['NOME'])
));
$dados  = array(
    "tipo" => 'success',
    "mensagem" => 'registro atualizado com sucesso.'

);


        }catch(PDOException $e){
            $dados  = array(
                "tipo" => 'error',
                "mensagem" => 'Não foi possivel concluir o registro: '.$e

        
            );
        }
    }
}
//converter o nossa array para json
echo json_encode($dados);