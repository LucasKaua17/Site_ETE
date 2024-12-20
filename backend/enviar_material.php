<?php
// processa_formulario.php
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
require 'conexaobd.php'; // Inclua seu arquivo de conexão

// Recebe os dados do formulário
$nome_material = isset($_POST['nome_material']) ? $_POST['nome_material'] : '';
$descricao_material = isset($_POST['descricao']) ? $_POST['descricao'] : '';
$disciplinas_id = isset($_POST['disciplinas']) ? intval($_POST['disciplinas']) : 0;
$turmas = isset($_POST['turmas']) ? $_POST['turmas'] : [];

// Obtém o ID do professor da sessão
session_start();
//$id_professor_fk = isset($_SESSION['id_professor']) ? intval($_SESSION['id_professor']) : 0;
$id_professor_fk = 1;

// Validações básicas
if (empty($nome_material) || empty($descricao_material) || $disciplinas_id === 0 || $id_professor_fk === 0 || count($turmas) === 0) {
    die("Preencha todos os campos obrigatórios.");
}

// Recebe a data no formato dd/mm/yyyy
$data_material = date('d/m/Y');

// Verifica se a data foi fornecida
if (empty($data_material)) {
    die("Data inválida.");
}

// Inserir os dados do material no banco de dados
$sql = "INSERT INTO material (id_professor_fk, id_disciplina_fk, nome_material, descricao_material, data_material) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("iisss", $id_professor_fk, $disciplinas_id, $nome_material, $descricao_material, $data_material);

if ($stmt->execute()) {
    $material_id = $stmt->insert_id;

    // Relaciona o material às turmas selecionadas
    foreach ($turmas as $turma_id) {
        $sqlTurma = "INSERT INTO turma_estuda_material (id_material_fk, id_turma_fk) VALUES (?, ?)";
        $stmtTurma = $conexao->prepare($sqlTurma);
        $stmtTurma->bind_param("ii", $material_id, $turma_id);
        $stmtTurma->execute();
        $stmtTurma->close();
    }

    // Upload dos arquivos, se houver
    if (!empty($_FILES['arquivo']['name'][0])) {
        for ($i = 0; $i < count($_FILES['arquivo']['name']); $i++) {
            $fileName = basename($_FILES['arquivo']['name'][$i]); // Nome do arquivo
            $filePath = "arqmaterial/" . $fileName; // Caminho para o arquivo

            // Verifica se o upload foi bem-sucedido
            if (move_uploaded_file($_FILES['arquivo']['tmp_name'][$i], $filePath)) {
                // Inserir o nome do arquivo, o caminho e a chave estrangeira na tabela arquivo_material
                $sqlArquivo = "INSERT INTO arquivo_material (id_material_fk, url_arquivo, nome_arquivo) VALUES (?, ?, ?)";
                $stmtArquivo = $conexao->prepare($sqlArquivo);
                $stmtArquivo->bind_param("iss", $material_id, $filePath, $fileName); // Associando material_id com url e nome do arquivo
                $stmtArquivo->execute();
                $stmtArquivo->close();
            } else {
                echo "Erro ao enviar o arquivo: " . $_FILES['arquivo']['name'][$i];
            }
        }
    }


    echo "Material inserido com sucesso!";
} else {
    echo "Erro ao inserir material: " . $stmt->error;
}

// Fechar conexão
$stmt->close();
$conexao->close();
?>
