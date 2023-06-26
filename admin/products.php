<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_POST['add_product'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);
   $category = $_POST['category']; // New category field

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/' . $image_01;

   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/' . $image_02;

   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/' . $image_03;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if ($select_products->rowCount() > 0) {
      $message[] = 'Product name already exists!';
   } else {

      $insert_products = $conn->prepare("INSERT INTO `products`(name, details, price, category, image_01, image_02, image_03) VALUES(?,?,?,?,?,?,?)");
      $insert_products->execute([$name, $details, $price, $category, $image_01, $image_02, $image_03]);

      if ($insert_products) {
         if ($image_size_01 > 2000000 || $image_size_02 > 2000000 || $image_size_03 > 2000000) {
            $message[] = 'Image size is too large!';
         } else {
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            $message[] = 'New product added!';
         }

      }

   }
};

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/' . $fetch_delete_image['image_01']);
   unlink('../uploaded_img/' . $fetch_delete_image['image_02']);
   unlink('../uploaded_img/' . $fetch_delete_image['image_03']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:products.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="add-products">

      <h1 class="heading">Add Product</h1>

      <form action="" method="post" enctype="multipart/form-data">
         <div class="flex">
            <div class="inputBox">
               <span>Product Name (required)</span>
               <input type="text" class="box" required maxlength="100" placeholder="Enter product name" name="name">
            </div>
            <div class="inputBox">
               <span>Product Price (required)</span>
               <input type="number" min="0" class="box" required max="9999999999" placeholder="Enter product price" onkeypress="if(this.value.length == 10) return false;" name="price">
            </div>
            <div class="inputBox">
               <span>Image 01 (required)</span>
               <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
            </div>
            <div class="inputBox">
               <span>Image 02 (required)</span>
               <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
            </div>
            <div class="inputBox">
               <span>Image 03 (required)</span>
               <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
            </div>
            <div class="inputBox">
            <div class="inputBox">
   <span>Product Category (required)</span>
   <div>
      <input type="radio" id="laptop" name="category" value="laptop" required>
      <label for="laptop">Laptop</label>
   </div>
   <div class="fieldName">
      <label for="model">Model No</label>
      <input type="text" id="model" name="model" placeholder="Enter model number" required>
   </div>
   <div class="fieldName">
      <label for="cpu">CPU</label>
      <input type="text" id="cpu" name="cpu" placeholder="Enter CPU details" required>
   </div>
   <div class="fieldName">
      <label for="memory">Memory</label>
      <input type="text" id="memory" name="memory" placeholder="Enter memory details" required>
   </div>
   <div class="fieldName">
      <label for="display">Display</label>
      <input type="text" id="display" name="display" placeholder="Enter display details" required>
   </div>
   <div class="fieldName">
      <label for="battery">Battery</label>
      <input type="text" id="battery" name="battery" placeholder="Enter battery details" required>
   </div>
   <div class="fieldName">
      <label for="weight">Weight</label>
      <input type="text" id="weight" name="weight" placeholder="Enter weight details" required>
   </div>
   <div class="fieldName">
      <label for="graphics">Graphics</label>
      <input type="text" id="graphics" name="graphics" placeholder="Enter graphics details" required>
   </div>
</div>

         </div>
         <div>
            <input type="radio" id="motherboard" name="category" value="motherboard" required>
            <label for="motherboard">Motherboard</label>
         </div>
         <div>
         <div>
  <input type="radio" id="ram" name="category" value="ram" required>
  <label for="ram">RAM</label>
</div>

<div class="fieldName" style="display: none;">
  <label for="model">Model No</label>
  <input type="text" id="model" name="model" placeholder="Enter model number" required>
</div>
<div class="fieldName" style="display: none;">
  <label for="brand">Brand</label>
  <input type="text" id="brand" name="brand" placeholder="Enter brand" required>
</div>
<div class="fieldName" style="display: none;">
  <label for="capacity">Capacity</label>
  <input type="text" id="capacity" name="capacity" placeholder="Enter capacity" required>
</div>
<div class="fieldName" style="display: none;">
  <label for="technology">Technology</label>
  <input type="text" id="technology" name="technology" placeholder="Enter technology" required>
</div>
<div class="fieldName" style="display: none;">
  <label for="frequency">Frequency (Hz)</label>
  <input type="text" id="frequency" name="frequency" placeholder="Enter frequency" required>
</div>

<script>
  var ramRadio = document.getElementById("ram");
  var ramFields = document.querySelectorAll(".fieldName");

  ramRadio.addEventListener("click", function() {
    ramFields.forEach(function(field) {
      field.style.display = "block";
    });
  });
</script>

</div>
<div>
  <input type="radio" id="gpu" name="category" value="gpu" required>
  <label for="gpu">GPU</label>
</div>

<div class="fieldName" style="display: none;">
  <label for="brand">Brand</label>
  <input type="text" id="brand" name="brand" placeholder="Enter brand" required>
</div>
<div class="fieldName" style="display: none;">
  <label for="model">Model</label>
  <input type="text" id="model" name="model" placeholder="Enter model number" required>
</div>
<div class="fieldName" style="display: none;">
  <label for="manufacturer">Manufacturer</label>
  <input type="text" id="manufacturer" name="manufacturer" placeholder="Enter manufacturer" required>
</div>
<div class="fieldName" style="display: none;">
  <label for="memoryClockSpeed">Memory Clock Speed</label>
  <input type="text" id="memoryClockSpeed" name="memoryClockSpeed" placeholder="Enter memory clock speed" required>
</div>
<div class="fieldName" style="display: none;">
  <label for="memorySize">Memory Size</label>
  <input type="text" id="memorySize" name="memorySize" placeholder="Enter memory size" required>
</div>
<div class="fieldName" style="display: none;">
  <label for="directX">DirectX</label>
  <input type="text" id="directX" name="directX" placeholder="Enter DirectX version" required>
</div>

<script>
  var gpuRadio = document.getElementById("gpu");
  var gpuFields = document.querySelectorAll(".fieldName");

  gpuRadio.addEventListener("click", function() {
    gpuFields.forEach(function(field) {
      field.style.display = "block";
    });
  });
</script>

<style>
   .fieldName {
      margin-bottom: 10px;
   }

   .fieldName label {
      display: block;
      margin-bottom: 5px;
   }

   .fieldName input[type="text"] {
      width: 200px;
      padding: 5px;
   }
</style>

<div>
   <input type="radio" id="cpu" name="category" value="cpu" required>
   <label for="cpu">CPU</label>
</div>

<div class="fieldName" id="coreField" style="display: none;">
   <label for="core">Core</label>
   <input type="text" id="core" name="core" placeholder="Enter number of cores" required>
</div>
<div class="fieldName" id="modelField" style="display: none;">
   <label for="model">Model</label>
   <input type="text" id="model" name="model" placeholder="Enter model number" required>
</div>
<div class="fieldName" id="manufacturerField" style="display: none;">
   <label for="manufacturer">Manufacturer</label>
   <input type="text" id="manufacturer" name="manufacturer" placeholder="Enter manufacturer" required>
</div>
<div class="fieldName" id="baseClockSpeedField" style="display: none;">
   <label for="baseClockSpeed">Base Clock Speed</label>
   <input type="text" id="baseClockSpeed" name="baseClockSpeed" placeholder="Enter base clock speed" required>
</div>
<div class="fieldName" id="generationField" style="display: none;">
   <label for="generation">Generation</label>
   <input type="text" id="generation" name="generation" placeholder="Enter generation" required>
</div>
<div class="fieldName" id="cacheField" style="display: none;">
   <label for="cache">Cache</label>
   <input type="text" id="cache" name="cache" placeholder="Enter cache size" required>
</div>

<script>
   const cpuRadio = document.getElementById("cpu");
   const coreField = document.getElementById("coreField");
   const modelField = document.getElementById("modelField");
   const manufacturerField = document.getElementById("manufacturerField");
   const baseClockSpeedField = document.getElementById("baseClockSpeedField");
   const generationField = document.getElementById("generationField");
   const cacheField = document.getElementById("cacheField");

   cpuRadio.addEventListener("change", function() {
      if (this.checked) {
         coreField.style.display = "block";
         modelField.style.display = "block";
         manufacturerField.style.display = "block";
         baseClockSpeedField.style.display = "block";
         generationField.style.display = "block";
         cacheField.style.display = "block";
      } else {
         coreField.style.display = "none";
         modelField.style.display = "none";
         manufacturerField.style.display = "none";
         baseClockSpeedField.style.display = "none";
         generationField.style.display = "none";
         cacheField.style.display = "none";
      }
   });
</script>

            </div>
            <div class="inputBox">
               <span>Product Details (required)</span>
               <textarea name="details" placeholder="Enter product details" class="box" required maxlength="500" cols="30" rows="10"></textarea>
            </div>
         </div>

         <input type="submit" value="Add Product" class="btn" name="add_product">
      </form>

   </section>

   <section class="show-products">

      <h1 class="heading">Products Added</h1>

      <div class="box-container">

         <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <div class="box">
                  <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                  <div class="name"><?= $fetch_products['name']; ?></div>
                  <div class="price">$<span><?= $fetch_products['price']; ?></span>/-</div>
                  <div class="details"><span><?= $fetch_products['details']; ?></span></div>
                  <div class="flex-btn">
                     <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Update</a>
                     <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
                  </div>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">No products added yet!</p>';
         }
         ?>

      </div>

   </section>

   <script src="../js/admin_script.js"></script>
   <script>
   const ramRadio = document.getElementById("ram");
   const ramFields = document.querySelectorAll("#ramFields");

   ramRadio.addEventListener("change", function() {
      if (this.checked) {
         ramFields.forEach(function(field) {
            field.style.display = "block";
         });
      } else {
         ramFields.forEach(function(field) {
            field.style.display = "none";
         });
      }
   });
</script>

</body>

</html>
