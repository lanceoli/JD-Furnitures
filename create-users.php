<?php
    
    ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="create.css">
    <title>Document</title>
</head>
<body>
<nav class="site-nav grid"> 
    <a href="index.php"><img src="assets/img/Back.png" alt=""></a>
    <p>Create User</p>
</nav>



<form action="php-create-user.php" method="post" enctype="multipart/form-data">
    <div class="forms">
    
    <div class="ins-img">
            <label for="create-img">Add Image</label>
            <input type="file" name="create-img" id="create-img">
    </div>

    <p class="create-cat">Details</p>
    <div class="create-form">
            <p>Last Name</p>
            <input type="text" name="last-name" id="last-name">
    </div>
    <div class="create-form">
            <p>First Name</p>
            <input type="text" name="first-name" id="first-name">

    </div>
    <div class="create-form">
            <p>Middle Name</p>
            <input type="text" name="middle-name"  id="middle-name">
    </div>
    <div class="create-form">
            <p>Username</p>
            <input type="text" name="user-name" id="user-name">
    </div>

    <div class="create-form">
            <p>Password</p>
            <input type="text" name="passwords" id="passwords">
    </div>

    <div class="create-form">
            <p>Confirm Password</p>
            <input type="text" name="confirmation" id="confirmation">
    </div>

    
    </div>

    <div class="create-bar">
        <button type="submit" class="create-button"><p>Create</p></button>
    </div>
</form>

</body>
</html>