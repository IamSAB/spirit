<?php

require '../autoload.php';
require '../config.php';

$pdo = new \Pdo('sqlite:spirit.db', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$route = $_GET['route'] ?? '';

$jokes = new \Maphper\Maphper(new \Maphper\DataSource\Database($pdo, 'joke', 'id', ['editmode' => true]));

if ($route == '') {
	$model = new \Model\JokeList($jokes);
	$view = new \View\JokeList();
}
else if ($route == 'edit') {
	$model = new \Model\JokeForm($jokes);
	$controller = new \Controller\Form();

	$model = $controller->edit($model);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$model = $controller->submit($model);
	}

	$view = new \View\JokeForm();
}
else if ($route == 'delete') {
	$model = new \Model\JokeList($jokes);
	$controller = new \Controller\Listing();

	$model = $controller->delete($model);

	$view = new \View\JokeList();
}
else if ($route == 'filterList') {
	$model = new \Model\JokeList($jokes);
	$view = new \View\JokeList();
	$controller = new \Controller\Listing();

	$model = $controller->filterList($model);
}
else {
	http_response_code(404);
	echo 'Page not found (Invalid route)';
}

echo $view->output($model);
