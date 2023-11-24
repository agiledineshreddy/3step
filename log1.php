<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index1.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
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

<?php
        if (isset($_POST["login"])) {
          $email = $_POST["email"];
          $password = $_POST["password"];
          $sequence = $_POST["sequence"];
           $a = $_POST["display0"];
           $b = $_POST["display11"];
           $c = $_POST["c"];
           require_once "database.php";
           $sql = "SELECT * FROM users WHERE email = '$email'";
           /*$sql = "SELECT * FROM users WHERE sequence = '$sequence'";
           $sql = "SELECT * FROM users WHERE a = '$a'";
           $sql = "SELECT * FROM users WHERE b = '$b'";
           $sql = "SELECT * FROM users WHERE c = '$c'";*/
           $result = mysqli_query($conn, $sql);
            $user= mysqli_fetch_array($result, MYSQLI_ASSOC);
           $count = mysqli_num_rows($result);
           if($count>=1){
                        if ($user) {
                         if (password_verify($password, $user["password"])) {
                               /* session_start();
                               $_SESSION["user"] = "yes";
                                header("Location: index1.php");
                                  die();*/
                                  require_once "database.php";
                                   $sql = "SELECT * FROM users WHERE sequence = '$sequence'";
                                   $result = mysqli_query($conn, $sql);
                                    $count = mysqli_num_rows($result);
                                    if($count>=1){
                                       require_once "database.php";
                                        $sql = "SELECT * FROM users WHERE a = '$a' OR a = ('$a'+1)OR a = ('$a'+2) OR a = ('$a'-1) OR a = ('$a'-2)OR a = ('$a'-3)OR a = ('$a'+4) AND b='$b' OR b=('$b'+1) OR b=('$b'+2)OR b=('$b'-1)OR b=('$b'-2) OR b=('$b'+3)OR b=('$b'-3) ";
                                        $result = mysqli_query($conn, $sql);
                                        $count = mysqli_num_rows($result);
                                       if($count>=1){
                                        require_once "database.php";
                                         $sql = "SELECT * FROM users WHERE c = '$c'";
                                         $result = mysqli_query($conn, $sql);
                                          $count = mysqli_num_rows($result);
                                    if($count>=1){
                                     session_start();
                                       $_SESSION["user"] = "yes";
                                      header("Location: index1.php");
                                       die();
                                           }
                                           else{
                                            echo "image password not correct";
                                           }
                }
                else{
                  echo "image area is not correct";
                }

              }
              else{
                echo "sequence does not match";
              }
               
            }else{
                echo "<div class='alert alert-danger'>Password does not match</div>";
            }
        }
          
          }
           else{
               echo '<script>
               window.location.href = "log1.php";
              alert("login failed.email does not match")
              </script>';
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
<form action="log1.php" method="post">
  <h1>ENTER DETAILS TO LOGIN</h1>
<div class="form-group">
            <input type="email" placeholder="Enter Email:" name="email" class="form-control">
        </div>
        <div class="form-group">
            <input type="password" placeholder="Enter Password:" name="password" class="form-control">
        </div>
        <h2>enter colour sequence</h2>
        <div class="form-group">
                <input type="password" class="form-control"id="sequence" name="sequence" placeholder="enter colour sequence">
            </div>
            <div class="form-group">
                <input type="button" class="green" value="green"onclick="seq(1)"><input type="button" class="red" value="red"onclick="seq(2)"><input type="button" class="blue" value="blue"onclick="seq(3)">
            </div>
            <h2>select image area and enter password</h2>
<input type="text" id="display">
<input type="text" id="display1">
<div class="img-magnifier-container">
<input type="file" accept="image/*" id="imageInput" onchange="displayImage()">
</div>
<div id="sticky-container">
        <img id="myimage" alt="Sticky Image" onclick="maybe()">
    </div>
    <div>
  <input type="text" id="display0" name="display0">
  <input type="text" id="display11" name="display11">
  <input type="text" id="c" name="c" placeholder="enter password">
  <div class="form-btn">
                <input type="submit" class="btn-primary" value="login" name="login">
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
  </form>
  <style>
        
        .green{background-color: green;}
        .red{background-color: red;}
        .blue{background-color: blue;}
        .btn-primary{background-color: orange;}

        
        </style>
      </form>
     <div><p>Not registered yet <a href="index.php">Register Here</a></p></div>
    </div>
</body>
</html>



</body>
</html>
