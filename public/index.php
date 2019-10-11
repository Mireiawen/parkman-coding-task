<?php
declare(strict_types = 1);

use Mireiawen\ParkMan\Application;

require_once('../vendor/autoload.php');

\header('Content-Type: application/json');

if
(
	!isset($_ENV['DATABASE_HOSTNAME'])
	|| !isset($_ENV['DATABASE_USERNAME'])
	|| !isset($_ENV['DATABASE_PASSWORD'])
	|| !isset($_ENV['DATABASE_DATABASE'])
)
{
	http_response_code(500);
	echo json_encode(['result' => FALSE, 'error' => 'Missing database configuration']);
	exit(0);
}

$hostname = $_ENV['DATABASE_HOSTNAME'];
$username = $_ENV['DATABASE_USERNAME'];
$password = $_ENV['DATABASE_PASSWORD'];
$database = $_ENV['DATABASE_DATABASE'];

$database = new mysqli($hostname, $username, $password, $database);
$database->set_charset('utf8mb4');

$application = new Application($database);
$application->Run();
