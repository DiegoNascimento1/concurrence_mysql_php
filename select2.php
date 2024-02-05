<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'test';

try {
    // Cria uma instância da classe PDO
    $conexao = new PDO("mysql:host=$host;dbname=$banco", $usuario, $senha);
    $resultados = [];
    // Configura o PDO para lançar exceções em caso de erros
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $conexao->exec("SET TRANSACTION ISOLATION LEVEL READ COMMITTED;");
    $conexao->beginTransaction();

    $sql = "SELECT saldo FROM conta WHERE ID = 1 FOR UPDATE;";
    $consulta = $conexao->prepare($sql);
    $consulta->execute();
    $resultados = $consulta->fetch(PDO::FETCH_ASSOC);
    if ($resultados) {
        echo "AQUI";
        print_r($conexao->exec("UPDATE transacao SET valor = '9.00' WHERE id = 2"));
        // print_r($conexao->exec("INSERT transacao SET valor = '8.00' WHERE id = 2"));
        // print_r($conexao->exec("UPDATE transacao SET valor = '8.00' WHERE id = 2"));
        // $conexao->exec("UPDATE transacao SET valor = '5.00' WHERE id = 2");
    } else {
        echo "ERROR";
    }
    // $conexao->commit();

    print_r($resultados);
} catch (PDOException $e) {
    // $conexao->rollBack();
    echo "Erro de conexão: " . $e->getMessage();
} finally {
    $resultados = [];
    $conexao = null;
}
?>