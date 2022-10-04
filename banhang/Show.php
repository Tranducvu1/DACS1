<?php

$pdo = new PDO('mysql:host=localhost;post=3306;dbname=products_crud','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$search = $_GET['search'] ?? '';
if ($search){
$statement = $pdo->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC');
$statement->bindValue(':title',"%$search%");
} else {
$statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
}
$statement->execute();
$products = $statement->fetchALL(PDO::FETCH_ASSOC);

?>


<!DOCTYPE HTML>  
<html>
<head>
  <meta charset="utf-8">
  <meta name ="viewport" content="width=device-width",initial-scale=1,shrink-to-fit>
  <link rel="stylesheet" href="css//app.css" /> 
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
   <style type="text/css"> 
     .thumb-image {
      width: :50px;
     }
   </style>
   </head>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min. <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
 <title>Product</title>

<body>
<h1>Products</h1>
<p>
  <a href="create.php" class="btn btn-success">Create Product</a>
  </p>
<form action="" method="get">
    <div class="input-group mb-3">
      <input type="text" name="search" class="form-control" placeholder="Search" value="<?php echo $search ?>">
      <div class="input-group-append">
        <button class="btn btn-success" type="submit">Search</button>
      </div>
    </div>
</form>
<table class="table">
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Price</th>
      <th scope="col">Date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
   <?php foreach ($products as $i => $product) : ?>
   <tr>
     <th scope ="row"><?php echo $i + 1 ?></th>
     <td>
       <img src = "<?php echo $product['image']?>" class="thumb-image">
     </td>
     <td><?php echo $product['title'] ?></td>
     <td><?php echo $product['price'] ?></td>
     <td><?php echo $product['create_date'] ?></td>
     <td>
      <a href="update.php?id=<?php echo $product['id'] ?>" type ="button" class="btn btn-outline-primary">Edit</a>
      <form style="display: inline-block" method="post" action="delete.php">
        <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
       <button type ="delete" class="btn btn-outline-danger">Delete</button>
       </form>
   </tr>
<?php endforeach; ?>
   
  </tbody>
</table> 
</body>
</html>