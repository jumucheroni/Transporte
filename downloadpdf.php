<?php 

	$html = $_POST['html'];
	$img = $_POST['img'];
	$condutor = $_POST['condutor'];
	$ajudante = $_POST['ajudante'];
	$tudo = $html.$img;
	require_once './vendor/autoload.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	$mpdf = new \Mpdf\Mpdf();
	ini_set("pcre.backtrack_limit", "5000000");
	$mpdf->WriteHTML($tudo);
	$date = strtotime(date("d-m-Y h:m:s"));
	$nome = "roteiro_".$date.".pdf";
	$mpdf->Output($nome);

	$email = new PHPMailer();
	$email->IsSMTP();
	$email->Port = 465;
	$email->Host = 'smtp.gmail.com';
	$email->IsHTML(true); 
	$email->Mailer = 'smtp'; 
	$email->SMTPSecure = 'ssl';
	$email->SMTPAuth = true;
	$email->Username = 'juhmucheroni@gmail.com';
	$email->Password = '******';
	$email->From      = 'juhmucheroni@gmail.com';
	$email->FromName  = 'Seu nome';
	$email->Subject   = 'Roteiro';
	$email->Body      = 'Corpo do email';
	if ($condutor) {
		$email->AddAddress( $condutor ,'Condutor');
	}
	if ($ajudante) {
		$email->AddCC( $ajudante ,"Ajudante");
	}
	$email->AddAttachment( $nome);
	$email->Send();

	echo $nome;

	exit;

?>