<?php
require __DIR__ . '/../../vendor/autoload.php';

\PagSeguro\Library::initialize();
\PagSeguro\Configuration\Configure::setAccountCredentials(
	'natanfelles@gmail.com',
	'C30774339ADE4141A38A41C3EBF5AA5F'
);
\PagSeguro\Configuration\Configure::setEnvironment('sandbox');
\PagSeguro\Configuration\Configure::setCharset('UTF-8');

$payment = new \PagSeguro\Domains\Requests\Payment();

// URL's
$payment->setRedirectUrl('http://localhost:8080/orders');
$payment->setNotificationUrl('http://localhost:8080/notification');

// Moeda
$payment->setCurrency('BRL');

// Frete
$payment->setShipping()->setCost()->withParameters(20.00);
$payment->setShipping()->setType()->withParameters(\PagSeguro\Enum\Shipping\Type::SEDEX);
/*$payment->setShipping()->setAddress()->withParameters(
	'Av. Brig. Faria Lima',
	'1384',
	'Jardim Paulistano',
	'01452002',
	'São Paulo',
	'SP',
	'BRA',
	'apto. 114'
);*/

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
	$result = $payment->register(
		\PagSeguro\Configuration\Configure::getAccountCredentials()
	);

	echo '<h2>Criando requisi&ccedil;&atilde;o de pagamento</h2>'
		. '<p>URL do pagamento: <strong>' . $result . '</strong></p>'
		. '<p><a title="URL do pagamento" href="' . $result . '" target="_blank">Ir para URL do pagamento.</a></p>';
} catch (Exception $e) {
	// echo($e->getMessage());
	var_dump($e);
}