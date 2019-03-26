<?php

require '../autoload.php';
require '../config.php';

$pdo = new \Pdo('sqlite:spirit.db', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$route = $_GET['route'] ?? '';

// $url = ltrim(strtok($_SERVER["REQUEST_URI"],'?'), '/');
// $parts = explode('/', $url);

$jokes = new \Maphper\Maphper(new \Maphper\DataSource\Database($pdo, 'joke', 'id', ['editmode' => true]));

if ($route == '') {
	$model = new \Model\JokeList($jokes);
	$view = new \Transphporm\Builder('../html/layout.html', '../tss/list.tss');
}
else if ($route == 'edit') {
	$model = new \Model\JokeForm($jokes);
	$controller = new \Controller\Form();

	$model = $controller->edit($model);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$model = $controller->submit($model);
	}

	$view = new \Transphporm\Builder('../html/layout.html', '../tss/edit.tss');
}
else if ($route == 'delete') {
	$model = new \Model\JokeList($jokes);
	$controller = new \Controller\Listing();
	$model = $controller->delete($model);
	$view = new \Transphporm\Builder('../html/layout.html', '../tss/list.tss');
}
else if ($route == 'filterList') {
	$model = new \Model\JokeList($jokes);
	$view = new \Transphporm\Builder('../html/layout.html', '../tss/list.tss');
	$controller = new \Controller\Listing();
	$model = $controller->filterList($model);
}
else {
	http_response_code(404);
	echo 'Page not found (Invalid route)';
}

$output = $view->output($model);

foreach ($output->headers as $header) {
	if ($header[0] === 'status') http_response_code($header[1]);
	else header($header[0] . ': ' . $header[1]);
}

echo $output->body;
