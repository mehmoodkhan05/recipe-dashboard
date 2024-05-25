<?php
include "navbar.php";
include "db/connection.php";

if (isset($_POST["submit"])) {
   $email = $_POST['email'];
   $phoneNumber = $_POST['phoneNumber'];
   $locationLatitude = $_POST['locationLatitude'];
   $locationLongitude = $_POST['locationLongitude'];
   $name = $_POST['name'];
   $type = $_POST['type'];
   $token = $_POST['token'];
   $description = $_POST['description'];
   $coins = $_POST['coins'];
   $password = $_POST['password'];

   // Hash the password before storing it
   $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

   // Handle file upload
   $imagePath = null;
   if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
       $imageTmpPath = $_FILES['image']['tmp_name'];
       $imageName = $_FILES['image']['name'];
       $imageSize = $_FILES['image']['size'];
       $imageType = $_FILES['image']['type'];
       $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
       $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

       if (in_array($imageExt, $allowedExts)) {
           $uploadDir = 'assets/img/users/';
           $imagePath = $uploadDir . basename($imageName);
           if (!is_dir($uploadDir)) {
               mkdir($uploadDir, 0777, true);
           }

           if (move_uploaded_file($imageTmpPath, $imagePath)) {
               // File successfully uploaded
           } else {
               echo "Error uploading the file.";
               $imagePath = null;
           }
       } else {
           echo "Invalid file extension.";
           $imagePath = null;
       }
   }

   $sql = "INSERT INTO `users`(`user_id`, `email`, `phoneNumber`, `locationLatitude`, `locationLongitude`, `name`, `type`, `token`, `description`, `coins`, `password`, `image`) 
   VALUES 
   (NULL,'$email','$phoneNumber','$locationLatitude','$locationLongitude','$name','$type','$token','$description', '$coins', '$hashedPassword', '$imagePath')";

   $result = mysqli_query($conn, $sql);

   if ($result) {
      header("LOCATION: users.php");
   } else {
      echo "Failed: " . mysqli_error($conn);
   }
}
?>

<style>
   .container {
      margin-top: 100px;
   }
</style>

<body>
   <?php include "sidebar.php" ?>
   <div class="container">
      <div class="text-center mb-4">
         <h3>Add New User</h3>
         <!-- <p class="text-muted mb-0">Complete the form below to add a new user</p> -->
         <p class="text-muted">Note: fields with red mark is must</p>
      </div>

      <div class="row justify-content-end">
         <div class="col-10">
            <form action="" method="POST" enctype="multipart/form-data">
               <div class="row">
                  <div class="col-lg-4">
                     <div class="mb-3">
                        <label for="floatingName">Email <span style="color: red;">*</span> </label>
                        <input type="text" class="form-control" name="email" id="floatingEmail" required>
                     </div>
                  </div>

                  <div class="col-lg-4">
                     <div class="mb-3">
                        <label for="floatingName">Phone <span style="color: red;">*</span> </label>
                        <input type="text" class="form-control" name="phoneNumber" id="floatingPhone" required>
                     </div>
                  </div>

                  <div class="col-lg-4">
                     <div class="mb-3">
                        <label for="floatingName">Location Latitude <span>(Optional)</span> </label>
                        <input type="text" class="form-control" name="locationLatitude" id="floatinglLate">
                     </div>
                  </div>

                  <div class="col-lg-4">
                     <div class="mb-3">
                        <label for="floatingName">Location Longitude <span>(Optional)</span> </label>
                        <input type="text" class="form-control" name="locationLongitude" id="floatinglLong">
                     </div>
                  </div>

                  <div class="col-lg-4">
                     <div class="mb-3">
                        <label for="floatingdob">Name <span>(Optional)</span> </label>
                        <input type="text" class="form-control" name="name" id="floatingName">
                     </div>
                  </div>

                  <div class="col-lg-4">
                     <div class="mb-3">
                        <label for="floatingdob">Type <span>(Optional)</span> </label>
                        <input type="text" class="form-control" name="type" id="floatingType">
                     </div>
                  </div>

                  <div class="col-lg-4">
                     <div class="mb-3">
                        <label for="floatingdob">Token <span>(Optional)</span> </label>
                        <input type="text" class="form-control" name="token" id="floatingToken">
                     </div>
                  </div>

                  <div class="col-lg-4">
                     <div class="mb-3">
                        <label for="floatingdob">Descriptions <span>(Optional)</span> </label>
                        <input type="text" class="form-control" name="description" id="floatingDesc">
                     </div>
                  </div>

                  <div class="col-lg-4">
                     <div class="mb-3">
                        <label for="floatingdob">Coins <span>(Optional)</span> </label>
                        <input type="text" class="form-control" name="coins" id="floatingCoins">
                     </div>
                  </div>

                  <div class="col-lg-4">
                     <div class="mb-3">
                        <label for="floatingdob">Password <span style="color: red;">*</span> </label>
                        <input type="password" class="form-control" name="password" id="floatingPass" required>
                     </div>
                  </div>

                  <div class="col-lg-4">
                     <div class="mb-3">
                        <label for="floatingdob">Profile</label>
                        <input type="file" class="form-control" name="image" id="floatingProfile">
                     </div>
                  </div>
               </div>

               <div class="users_confirmation-buttons">
                  <button type="submit" class="btn btn-success" name="submit">Add</button>
                  <a href="users.php" class="btn btn-danger ms-2">Cancel</a>
               </div>
            </form>
         </div>
      </div>
   </div>
</body>