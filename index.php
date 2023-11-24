<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div>
<style>
* {box-sizing: border-box;}

.img-magnifier-container {
  position:relative;
}

.img-magnifier-glass {
  position: absolute;
  border: 1px solid #000;
  margin: 15px;
  /*Set the size of the magnifier glass:*/
  width: 15px;
  height: 15px;
}

body {
            background:url("https://img.freepik.com/free-photo/river-with-nature-landscape_23-2150701879.jpg?size=626&ext=jpg&ga=GA1.1.1880011253.1699747200&semt=ais");
            background-size:280%;
            background-position: -400px 0px;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        h1{
          text-align: center;
          padding:20px;
          font-family:sans-serif;
        }
       

        #sticky-container {
            position: fixed;
            top: 10px;
            right: 10px;
            max-width: 400px;
            max-height: 400px;
        }

        #myimage {
            width: 100%;
            height: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }
    .form.group{
    margin-bottom: 30px ;
    width: 400px;
    margin: 100px auto 0px auto;
}
        
</style>
<script>
var b,c;
function magnify(imgID, zoom) {
  var img, glass, w, h, bw,g;
  img = document.getElementById(imgID);
  /*create magnifier glass:*/
  glass = document.createElement("DIV");
  glass.setAttribute("class", "img-magnifier-glass");
  /*insert magnifier glass:*/
  img.parentElement.insertBefore(glass, img);
  /*set background properties for the magnifier glass:*/
  glass.style.backgroundImage = "url('" + img.src + "')";
  glass.style.backgroundRepeat = "no-repeat";
  glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";
  bw = 3;
  w = glass.offsetWidth / 2;
  h = glass.offsetHeight / 2;
  /*execute a function when someone moves the magnifier glass over the image:*/
  glass.addEventListener("mousemove", moveMagnifier);
  img.addEventListener("mousemove", moveMagnifier);
  /*and also for touch screens:*/
  glass.addEventListener("touchmove", moveMagnifier);
  img.addEventListener("touchmove", moveMagnifier);
   function moveMagnifier(e) {
    var pos, x, y;
    /*prevent any other actions that may occur when moving over the image*/
    e.preventDefault();
    /*get the cursor's x and y positions:*/
    pos = getCursorPos(e);
    x = pos.x;
    y = pos.y;
    /*prevent the magnifier glass from being positioned outside the image:*/
    if (x > img.width - (w / zoom)) {x = img.width - (w / zoom);}
    if (x < w / zoom) {x = w / zoom;}
    if (y > img.height - (h / zoom)) {y = img.height - (h / zoom);}
    if (y < h / zoom) {y = h / zoom;}
    /*set the position of the magnifier glass:*/
    glass.style.left = (x - w) + "px";
    glass.style.top = (y - h) + "px";
    /*display what the magnifier glass "sees":*/
    glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";
  }
  function getCursorPos(e) {
    var a, x = 0, y = 0;
    e = e || window.event;
    /*get the x and y positions of the image:*/
    a = img.getBoundingClientRect();
    /*calculate the cursor's x and y coordinates, relative to the image:*/
    x = e.pageX - a.left;
    y = e.pageY - a.top;
    if(x!=0){
       document.getElementById("display").value=parseInt(x);
       document.getElementById("display1").value=parseInt(y);
                      }
    /*consider any page scrolling:*/
    x = x - window.pageXOffset;
    y = y - window.pageYOffset;
    return {x : x, y : y};
   

  }

}
</script>
</div>

<?php
        if (isset($_POST["submit"])) {
          $fullName = $_POST["fullname"];
          $email = $_POST["email"];
          $password = $_POST["password"];
          $passwordRepeat = $_POST["repeat_password"];
          $sequence = $_POST["sequence"];
          $passwordHash = password_hash($password, PASSWORD_DEFAULT);
           $a = $_POST["display0"];
           $b = $_POST["display11"];
           $c = $_POST["c"];

           $errors = array();

           if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat) OR empty($a)) {
            array_push($errors,"All fields are required");
           }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           }
           if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 charactes long");
           }
           if ($password!==$passwordRepeat) {
            array_push($errors,"Password does not match");
           }
           if (empty($sequence)) {
            array_push($errors,"select colour sequence");
           }
           
           if (strlen($sequence)<3) {
            array_push($errors,"select at least 3 charactes long sequence");
           }
           require_once "database.php";
           $sql = "SELECT * FROM users WHERE email = '$email'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"Email already exists!");
           }
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }
           
          else{

            $sql = "INSERT INTO users (full_name, email, password,sequence,a,b,c) VALUES (?,?,?,?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"sssssss",$fullName, $email, $passwordHash, $sequence,$a,$b,$c);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            }else{
                echo "Something went wrong";
            }
           }


        }
        ?>
         <script>
    function seq(val) { 
            document.getElementById("sequence").value += val 
        } 
  </script>

</head>
<body>



<!DOCTYPE html>
<html>
<body>
<form action="index.php" method="post">
  <div class="main">
   
<div class="form-group">
<div class="register">
  <h1>REGISTER HERE</h1>
                <input type="text" class="form-control" name="fullname" placeholder="Full Name:">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <h2>select colour sequence</h2>
            <div class="form-group">
            <input type="password" class="form-control"id="sequence" name="sequence" placeholder="select sequence">
            </div>
            <div class="form-group">
                <input type="button" class="green" value="green"onclick="seq(1)"><input type="button" class="red" value="red"onclick="seq(2)"><input type="button" class="blue" value="blue"onclick="seq(3)">
            </div>
            <h2>select image area and set password</h2>
            <input type="text" id="display">
            <input type="text" id="display1">
            <div class="img-magnifier-container">
            <input type="file" accept="image/*" id="imageInput" onchange="displayImage()">
            </div>
            <div id="sticky-container">
        <img id="myimage" alt="Sticky Image" onclick="maybe()">
        
    </div>
    <input type="text" id="display0" name="display0">
  <input type="text" id="display11" name="display11">
  <input type="text" id="c" name="c" placeholder="set password">
  <div class="form-btn">
                <input type="submit"  class="btn-primary" value="Register" name="submit">
            </div>
      </div>
      </div> 
      <script>
        /* Initiate Magnify Function
        with the id of the image, and the strength of the magnifier glass:*/
magnify("myimage", 3);
    function maybe(){
      document.getElementById("display0").value=display.value;
      document.getElementById("display11").value=display1.value;
    }
    function displayImage() {
            var input = document.getElementById('imageInput');
            var stickyImage = document.getElementById('myimage');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    stickyImage.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

    
</script>


            <div><p>Already Registered <a href="log1.php">Login Here</a></p></div>
            <style>
            .green{background-color: green;}
            .red{background-color: red;}
            .blue{background-color: blue;}
            .btn-primary{background-color: orange;}      
        </style>
        
  </form>
</body>
</html>



</body>
</html>
