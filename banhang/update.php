<?php


$pdo = new PDO('mysql:host=localhost;post=3306;dbname=products_crud','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;

if (!$id) {
  header('Location: Show.php');
  exit;
}

$statement = $pdo->prepare('SELECT * FROM products Where id = :id'); 
 //truy van
$statement->bindValue(':id',$id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);



$errors = [];
//set variable with empty
$title =$product['title'];
$price =$product['price'];
$description = $product['description'];

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];


 if(!$title){
  $errors[] = 'Product title is required';
}

if(!$price){
  $errors[] = 'Product price is required';
  }

if(!is_dir('images')){
  mkdir('images');
}

if(empty($errors)){
  $image = $_FILES['image'] ?? null;
  $imagePath= $product['image'];


   if ($image && $$image['tmp_name']){
    
      if ($product['image']){
    unlink($product['image']); 
}
     $imagePath = 'images/'.randomString(8).'/'.$image['name'];
    mkdir(dirname($imagePath));
    move_uploaded_file($image['tmp_name'],$imagePath);
     }


$statement = $pdo->prepare("UPDATE products SET title = :title,
  image = :image,
  description = :description
  ,price = :price WHERE id = :id");
 //truy van 
$statement->bindValue(':title',$title);
$statement->bindValue(':image',$imagePath);
$statement->bindValue(':description',$description);
$statement->bindValue(':price',$price);
$statement->bindValue(':id',$id);
$statement->execute();
header('Location: Show.php');
}
}

function randomString($n)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ';
  $str = '';
  for($i = 0; $i <$n;$i++){
    $Show = rand(0,strlen($characters)-1);
    $str .= $characters[$Show];
  }
  return $str;
}



?>


<!DOCTYPE HTML>  
<html>
<head>
  <meta charset="utf-8">
  <meta name ="viewport" content="width=device-width",initial-scale=1,shrink-to-fit>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
 <link rel="stylesheet" href="app.css">
 <title>Product</title>
 <style type="text/css">
   .update-image {
   width: 120px;
   }
 </style>
</head>
<body>
<p>
  <a href="Show.php" class="btn btn-second">Go bach to Product</a>
</p>
<h1>Update new products<b><?php echo $product['title'] ?></b></h1>

<?php if(!empty($errors)): ?>
<div class= "alert alert-danger">
  <?php foreach ($errors as $error): ?>
  <div><?php echo $error ?></div>
<?php endforeach; ?>
</div>
<?php endif; ?>


<form action="" method="post" enctype="multipart/form-data">

<?php if ($product['image']) : ?>
      <img src =" <?php echo $product['image'] ?>" class="update-image">
    <?php endif; ?>

  <div class="form-group">
    <label >Product Image</label>
    <br/>
    <input type="file" name ="image">
  </div>

  <div class="form-group">
    <label>Product Title</label>
    <input type="text" name="title" class="form-control" value="<?php echo $title ?>">
  </div>

  <div class="form-group">
    <label>Product Description</label>
    <textarea class="form-control" name="description" <?php echo $description ?>></textarea>
  </div>

  <div class="form-group">
    <label>Product Price</label>
    <input type="number" step=".01" name="price" class="form-control" value="<?php echo $price ?>">
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>

</form>
</body>
</html>
