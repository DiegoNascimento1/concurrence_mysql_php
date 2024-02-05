<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'test';

try {
    echo("<pre>");
    // Cria uma instância da classe PDO
    $conexao = new PDO("mysql:host=$host;dbname=$banco", $usuario, $senha);
    $resultados = [];
    // Configura o PDO para lançar exceções em caso de erros
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("RESET QUERY CACHE");
    
    // $conexao->exec("SET TRANSACTION ISOLATION LEVEL READ COMMITTED;");
    $conexao->beginTransaction();

    $consulta = $conexao->prepare("SELECT saldo FROM conta WHERE ID = 1 FOR UPDATE");
    $consulta->execute();
    $resultados = $consulta->fetch(PDO::FETCH_ASSOC);
    print_r($resultados);
    if ($resultados) {
        $saldo_anterior = $resultados['saldo'];
        $valor = 1.00+ rand(1,200);
        $saldo_atual = $resultados['saldo']+$valor;
        print_r($conexao->exec("INSERT INTO transacao (DESCRICAO, VALOR) VALUES ('TESTE$valor', '$valor')"));
        print_r($conexao->exec("UPDATE conta SET saldo = '$saldo_atual' WHERE id = 1"));
        print_r($insert2 = $conexao->prepare("INSERT INTO saldo (VALOR, SALDO_ATUAL, SALDO_ANTERIOR) VALUES ($valor,$saldo_atual,$saldo_anterior)"));
        print_r($insert2->execute());
        print_r($conexao->lastInsertId());
        // print_r($conexao->exec("UPDATE transacao SET valor = '8.00' WHERE id = 2"));
        // $conexao->exec("UPDATE transacao SET valor = '5.00' WHERE id = 2");
    } else {
        echo "ERROR";
    }
    // $conexao->commit();
    $conexao2 = new PDO("mysql:host=$host;dbname=$banco", $usuario, $senha);
    $conexao2->beginTransaction();
    $consulta = $conexao2->prepare("SELECT saldo FROM conta WHERE ID = 1 FOR UPDATE");
    $consulta->execute();
    $valida = $consulta->fetch(PDO::FETCH_ASSOC);
print_r($valida);
    if ($valida['saldo'] == $saldo_atual) {
        echo "Salvou";
    } else {
        echo "Não salvou";
    }
    $conexao2->commit();
    


} catch (PDOException $e) {
    // $conexao->rollBack();
    echo "Erro de conexão: " . $e->getMessage();
} finally {
    $resultados = [];
    $conexao = null;
}
?>