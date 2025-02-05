<?php require 'connectDB.php';
session_start();
if($_SESSION["status"] != true)
{
    header("location:login.php");
}
$emp_num = $_GET['emp'];

$emprow = "SELECT * FROM employees WHERE id = $emp_num";
$empdata = $connection->query($emprow);

if (!$empdata){
    die("Invalid query: " . $connection->error);
}
$employee = $empdata->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="UT-userinfo.css">
  
    <title>User Info | JD Records</title>
</head>
<body>
<nav class="site-nav grid"> 
    <a href="UT-adminview.php"><img src="assets/img/Back.png" alt=""></a>
    <p>User Info</p>
</nav>
<section>
<?php
echo'<div class="primary">
    <img class="prof-img" src="assets/employee_img/' . $employee["IMG"] . '" alt="">
    <div class="name"><p>' . $employee["FIRST_NAME"]. " ". $employee["MIDDLE_NAME"][0] . ". ". $employee["LAST_NAME"] . '</p>
    <a href="UT-userEdit.php?emp='?><?php echo $emp_num ?>"><?php echo '
        <img class="icon" src="assets/img/edit.png" alt=""></a></div>
  
</div>'
?>
</section>
<section class="addinfo">
    <div class="tabs-titles">
        <p id="detail" class="tab-title active-title">Details</p>
    </div>
    <div class="contents-container">
    
    <div class="tab-contents  active-tab" id="details">
         <?php echo'
         
         <p class="subtitle">Username</p>
         <p class="info">' . $employee["USERNAME"] . '</p>
         <p class="subtitle">Password</p>
         <p class="info">' . $employee["PASSWORD"] . '</p>
        
         '?>
         <a href="UT-deleteemployee.php?emp=<?php echo $emp_num ?>">
         <div class="dlt-btn">
            <p class="dlt-text">Delete</p><img class="icon" src="assets/img/delete.png" alt="delete" onClick="javascript:return confirm('Are you sure to delete this?')">
         </div></a>
        </div>
    
    </div>
    </div>
</section>
<script>
    var tabtitles=document.getElementsByClassName("tab-title");
    var tabcontents=document.getElementsByClassName("tab-contents");

    document.addEventListener("click", function(event){
        if(event.target.classList.contains('tab-title')){
            for(tabtitle of tabtitles){
                tabtitle.classList.remove("active-title");
            }
            for(tabcontent of tabcontents){
                tabcontent.classList.remove("active-tab");
            }
            event.target.classList.add("active-title");
            document.getElementById(event.target.id.concat("s")).classList.add("active-tab");
            
        }

    });
    </script>
</body>
</html>