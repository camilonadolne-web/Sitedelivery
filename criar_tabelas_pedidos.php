<?php
// Arquivo para criar as tabelas de pedidos
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: text/html; charset=utf-8');

$host = 'localhost';
$dbname = 'ouroverde_organicos';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🛠️ Criando Tabelas de Pedidos</h2>";
    
    // SQL para criar tabela pedidos
    $sqlPedidos = "CREATE TABLE IF NOT EXISTS pedidos (
        id INT PRIMARY KEY AUTO_INCREMENT,
        cliente_nome VARCHAR(100) NOT NULL,
        cliente_cpf VARCHAR(14),
        cliente_telefone VARCHAR(20) NOT NULL,
        cliente_cep VARCHAR(9),
        cliente_endereco TEXT NOT NULL,
        cliente_numero VARCHAR(10) NOT NULL,
        cliente_complemento VARCHAR(100),
        total DECIMAL(10,2) NOT NULL,
        observacoes_gerais TEXT,
        status ENUM('pendente', 'confirmado', 'preparando', 'entregue', 'cancelado') DEFAULT 'pendente',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $db->exec($sqlPedidos);
    echo "✅ Tabela 'pedidos' criada/verificada com sucesso!<br>";
    
    // SQL para criar tabela pedido_itens
    $sqlItens = "CREATE TABLE IF NOT EXISTS pedido_itens (
        id INT PRIMARY KEY AUTO_INCREMENT,
        pedido_id INT NOT NULL,
        produto_id INT NOT NULL,
        quantidade DECIMAL(10,2) NOT NULL,
        preco_unitario DECIMAL(10,2) NOT NULL,
        tipo_venda ENUM('kg', 'unidade') NOT NULL,
        observacao TEXT,
        FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
        FOREIGN KEY (produto_id) REFERENCES produtos(id)
    )";
    
    $db->exec($sqlItens);
    echo "✅ Tabela 'pedido_itens' criada/verificada com sucesso!<br>";
    
    echo "<h3>🎉 Estrutura do banco preparada para receber pedidos!</h3>";
    
} catch(PDOException $e) {
    echo "❌ Erro: " . $e->getMessage() . "<br>";
}
?>