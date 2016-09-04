<?php

$subject  = '[ARS] '.__('Convite para Avaliação');
$template = 'conviteAvaliacao.html';
$from     = array('user@email.com' => 'Jefferson Seide Molléri');

$server   = 'smtp.email.com';
$port     = 587;
$username = 'user@email.com';
$password = 'password';

$recipients = 'listateste.csv';


require_once 'libs/Swift-5.0.0/lib/swift_required.php';

// Create the Transport
$transport = Swift_SmtpTransport::newInstance($server, $port)
  ->setUsername($username)
  ->setPassword($password)
  ;

// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

if (($handle = fopen($recipients, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        echo "Enviando para {$data[0]} ...", iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $data[1]), PHP_EOL;

	$to = array($data[0]);
	

	$body = file_get_contents($template);
	$body = str_replace(array('{NOME}', '{EMAIL}'), array($data[1], $data[0]), $body);

	// Create a message
	$message = Swift_Message::newInstance($subject)
	  ->setFrom($from)
	  ->setTo($to)
	  ->setBody($body, 'text/html')
	  ;

	// Send the message
	$result = $mailer->send($message);
	echo ($result ? ' ok ' : ' fail '), PHP_EOL;
    }
    fclose($handle);
}


