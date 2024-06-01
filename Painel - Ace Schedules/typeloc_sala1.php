<?php
session_start();
include("tconect.php");

$dataAgendamento = mysqli_real_escape_string($conexao, trim($_POST['dataAgendamento']));
$periodo = mysqli_real_escape_string($conexao, trim($_POST['periodo']));
$id = $_SESSION['id'];

$idSala1 = 'Sala106';


$sql = "select count(*) as total from sala1 where dataAgendamento = '$dataAgendamento'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if($row['total'] == 1) {
	$_SESSION['data-exixte'] = true;
    $_SESSION['idSala'] = false;
	echo"<head>
	        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js'></script>
	        <link href='https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css' rel='stylesheet'>
        </head>
    <body>
	    <script>
		    Swal.fire({
			    icon: 'error',
			    title: 'Oops...',
			    text: 'Data indisponível',
		    }).then(function() {
			    window.location = 'painel.php';
		    });
	    </script> 
    </body>
    ";
    exit;
	  
} else{
	$_SESSION['data-exixte'] = false;
	
	$sql = "INSERT INTO sala1 (id, dataAgendamento, periodo, idSala) VALUES ('$id', '$dataAgendamento', '$periodo', '$idSala1')";

	$_SESSION['idSala'] = true;

    if($conexao->query($sql) === TRUE) {
	    $_SESSION['status_data'] = true;
    }

    $conexao->close();
	echo"<head>
	        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js'></script>
	        <link href='https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css' rel='stylesheet'>
        </head>
    <body>
	    <script>
		    Swal.fire({
			    icon: 'success',
			    title: 'Pronto!',
			    text: 'Pedido de agendamento realizado com sucesso',
		    }).then(function() {
			    window.location = 'painel.php';
		    });
	    </script> 
    </body>
    ";
    exit;
}

?>
