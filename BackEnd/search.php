<?php
// Conecte-se ao seu banco de dados ou realize a lógica de pesquisa necessária
include_once "sessao.php";
$db = getDb();
// Substitua este bloco de código com a lógica apropriada para obter os resultados da pesquisa

// Receba os parâmetros da consulta
$query = isset($_GET['query']) ? $_GET['query'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
// Execute a lógica de pesquisa e retorne os resultados
$searchName = '%' . $query . '%';
$sql = "SELECT prod_name FROM products WHERE prod_name LIKE :prod_name AND (:prod_category = '' OR prod_category = :prod_category)";
$parametros = [
    ':prod_name' => $searchName,
    ':prod_category' =>  $category,
];
$result = $db->executar($sql, $parametros, true);
if ($result->rowCount() > 0) {
    // Processar os resultados
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Saída dos resultados como sugestões
        echo '<div>' . $row['prod_name'] . '</div>';
    }
} else {
    echo '<div>Nenhum resultado encontrado</div>';
}
