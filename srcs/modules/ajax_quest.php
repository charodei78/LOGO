<?php
header("Content-type: text/plain; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
$query = htmlspecialchars( $_GET["query"]);
if (!$query)
{
	echo 0;
	exit(0);
}
$options = array(
					PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
);
try
{
	$connection = new PDO('mysql:host=localhost;dbname=films_index;charset=utf8', 'root', 'root', $options);
}
catch (Exception $e)
{
	exit (0);
}
$stmt = $connection->prepare("SELECT film.id, `title`, country.name as country, `release`, `rate`, `price` FROM film LEFT JOIN country ON country.id = country_id WHERE title LIKE :query");
$stmt->execute([':query' => $query.'%']);
$result = $stmt->fetchAll();
if ($result == array())
	echo 0;
else
	echo json_encode($result);
?>