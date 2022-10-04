<?php


$pdo = new PDO('mysql:host=localhost;post=3306;dbname=products_crud','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$id = $_POST['id'] ?? null;

if (!$id) {
	header('Location: Show.php');
	exit;
}
$statement = $pdo->prepare('DELETE FROM products WHERE id = :id');
$statement->bindValue(':id',$id);
$statement->execute();
header("Location: Show.php");
?>