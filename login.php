<?php

include("conexaobd.php");

header("Access-Control-Allow-Origin: http://localhost"); // Domínio do frontend
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

if(isset($_POST["login"]) && isset($_POST["senha"])) {
    $email = $conexao->real_escape_string($_POST["login"]);
    $senha = $conexao->real_escape_string($_POST["senha"]);

    $busca_sql = "SELECT id_usuario, email_usuario, senha_usuario, tipo_usuario FROM usuario WHERE email_usuario = '$email' AND senha_usuario = '$senha'";
    $resultado_busca = $conexao->query($busca_sql) or die("BUSCA FALHOU..." . $conexao->error);
    $valida_usuario = $resultado_busca->num_rows; // passa a qtd de linhas se for 1 ele existe

    if($valida_usuario == 1) {
        $usuario = $resultado_busca->fetch_assoc(); 

        if(!isset($_SESSION)) {
            session_start([
                'cookie_lifetime' => 24000, // 1 dia
                'cookie_secure' => false,   // Para HTTPS, use true
                //'cookie_samesite' => 'Lax'  // Para requisições seguras, como de formulário ou fetch no mesmo site
            ]);
        }

        // Define a sessão do usuário logado
        $_SESSION['usuario-logado'] = $usuario['id_usuario'];

        // Definindo o cookie com o ID do usuário
        setcookie("usuario_id", $usuario['id_usuario'], time() + (86400 * 30), "/"); // Cookie válido por 30 dias para todo o site

        // Verificação do tipo de usuário
        if($usuario['tipo_usuario'] == "coordenador") {
            $response = [
                "status" => "success",
                "tipo_usuario" => "home-coordenador.html"
            ];
        } else if($usuario['tipo_usuario'] == "professor") {
            $response = [
                "status" => "success",
                "tipo_usuario" => "home-professor.html"
            ];
        } else if($usuario['tipo_usuario'] == "aluno") {
            $response = [
                "status" => "success",
                "tipo_usuario" => "home-aluno.html"
            ];
        }

        // Retorna a resposta JSON
        echo json_encode($response);

    } else {
        // Retorna erro se login ou senha forem inválidos
        $response = [
            "status" => "error",
            "message" => "login ou senha incorretos!"
        ];

        echo json_encode($response);
    }
} else {
    // Retorna erro se os campos de login ou senha estiverem vazios
    $response = [
        "status" => "error",
        "message" => "login e senha inexistente..."
    ];

    echo json_encode($response);
}

?>
