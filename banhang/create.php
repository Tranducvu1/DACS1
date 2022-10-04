<?php
$pdo = new PDO('mysql:host=localhost;post=3306;dbname=products_crud','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




$errors = [];
//set variable with empty
$title ='';
$price ='';
$description = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$date = date('Y-m-d H:i:s');

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
  $imagePath= '';
  if ($image){
     $imagePath = 'images/'.randomString(8).'/'.$image['name'];
    mkdir(dirname($imagePath));
    move_uploaded_file($image['tmp_name'],$imagePath);
     }


$statement = $pdo->prepare("INSERT INTO products (title,image,description,price,create_date) 
    VALUES (:title, :image, :description, :price, :date)");
 //truy van
$statement->bindValue(':title',$title);
$statement->bindValue(':image',$imagePath);
$statement->bindValue(':description',$description);
$statement->bindValue(':price',$price);
$statement->bindValue(':date',$date);
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
</head>
<body>

<h1>Create new products</h1>

<?php if(!empty($errors)): ?>
<div class= "alert alert-danger">
  <?php foreach ($errors as $error): ?>
  <div><?php echo $error ?></div>
<?php endforeach; ?>
</div>
<?php endif; ?>


<form action="" method="post" enctype="multipart/form-data">

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