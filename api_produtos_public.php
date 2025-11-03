<?php
// API SIMPLES - SEM ERROS
header('Content-Type: application/json');

$produtos = array(
    array(
        'id' => 1,
        'nome' => 'Tomate Cereja Orgânico',
        'categoria' => 'hortalicas',
        'preco' => 18.90,
        'formas_venda' => array('kg' => true, 'unidade' => false),
        'precos' => array('kg' => 18.90, 'unidade' => 0),
        'estoque' => 15.5,
        'origem' => 'Fazenda Verde - ORGÂNICO',
        'permite_observacoes' => true
    ),
    array(
        'id' => 2,
        'nome' => 'Alface Crespa Orgânica',
        'categoria' => 'hortalicas',
        'preco' => 3.50,
        'formas_venda' => array('kg' => false, 'unidade' => true),
        'precos' => array('kg' => 0, 'unidade' => 3.50),
        'estoque' => 42,
        'origem' => 'Sítio Harmonia - ORGÂNICO',
        'permite_observacoes' => true
    ),
    array(
        'id' => 3,
        'nome' => 'Maçã Fuji Orgânica',
        'categoria' => 'frutas',
        'preco' => 12.90,
        'formas_venda' => array('kg' => true, 'unidade' => false),
        'precos' => array('kg' => 12.90, 'unidade' => 0),
        'estoque' => 8.2,
        'origem' => 'Pomar Natural - ORGÂNICO',
        'permite_observacoes' => true
    )
);

echo json_encode(array(
    'success' => true,
    'data' => $produtos,
    'total' => count($produtos)
));
?>