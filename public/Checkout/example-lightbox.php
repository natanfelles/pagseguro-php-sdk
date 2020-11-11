<?php
require __DIR__ . '/../../vendor/autoload.php';

\PagSeguro\Library::initialize();
\PagSeguro\Configuration\Configure::setAccountCredentials(
	'natanfelles@gmail.com',
	'C30774339ADE4141A38A41C3EBF5AA5F'
);
\PagSeguro\Configuration\Configure::setEnvironment('sandbox');

?>
	<!DOCTYPE html>
	<html>
	<head>

		<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>

	</head>
	</html>
<?php
$payment = new \PagSeguro\Domains\Requests\Payment();

// Moeda
$payment->setCurrency('BRL');

// Produtos
$payment->addItems()->withParameters(
	'0001',
	'Notebook prata',
	2,
	130.00
);

$payment->addItems()->withParameters(
	'0002',
	'Notebook preto',
	2,
	430.00
);

try {
	$onlyCheckoutCode = true;

	$result = $payment->register(
		\PagSeguro\Configuration\Configure::getAccountCredentials(),
		$onlyCheckoutCode
	);

	echo '<h2>Criando requisi&ccedil;&atilde;o de pagamento. Aguarde...</h2>'
		. '<p>C&oacute;digo da transa&ccedil;&atilde;o: <strong>' . $result->getCode() . '</strong></p>'
		. '<script>PagSeguroLightbox("' . $result->getCode() . '");</script>';
} catch (Exception $e) {
	var_dump($e->getMessage());
}
