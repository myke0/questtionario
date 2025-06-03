<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'questionario_satisfacao';
$username = 'root'; // Altere para seu usuário do MySQL
$password = ''; // Altere para sua senha do MySQL

try {
    // Conexão com o banco de dados
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparar os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $data_nascimento = !empty($_POST['data_nascimento']) ? $_POST['data_nascimento'] : null;
    $avaliacao_geral = $_POST['avaliacao_geral'];
    $probabilidade_recomendacao = $_POST['recomendacao'];
    
    // Processar recursos utilizados (array para string)
    $recursos_utilizados = isset($_POST['recursos']) ? implode(', ', $_POST['recursos']) : '';
    
    $comentarios = !empty($_POST['comentarios']) ? $_POST['comentarios'] : null;
    $areas_melhoria = !empty($_POST['melhorias']) ? $_POST['melhorias'] : null;

    // Preparar e executar a query SQL
    $stmt = $conn->prepare("INSERT INTO respostas (
        nome, email, data_nascimento, avaliacao_geral, 
        probabilidade_recomendacao, recursos_utilizados, 
        comentarios, areas_melhoria
    ) VALUES (
        :nome, :email, :data_nascimento, :avaliacao_geral, 
        :probabilidade_recomendacao, :recursos_utilizados, 
        :comentarios, :areas_melhoria
    )");

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':data_nascimento', $data_nascimento);
    $stmt->bindParam(':avaliacao_geral', $avaliacao_geral);
    $stmt->bindParam(':probabilidade_recomendacao', $probabilidade_recomendacao);
    $stmt->bindParam(':recursos_utilizados', $recursos_utilizados);
    $stmt->bindParam(':comentarios', $comentarios);
    $stmt->bindParam(':areas_melhoria', $areas_melhoria);

    $stmt->execute();

    // Redirecionar para página de agradecimento
    header('Location: obrigado.html');
    exit();

} catch(PDOException $e) {
    // Em caso de erro, exibir mensagem (em produção, registrar em log)
    echo "Erro: " . $e->getMessage();
    // Você pode redirecionar para uma página de erro aqui
    // header('Location: erro.html');
}
?>