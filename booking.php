<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
$db = new Database();
$db->connect();

?>
<?php
if (isset($_POST['btnAdd'])) {
    $name = $db->escapeString(($_POST['name']));
    $email = $db->escapeString($_POST['email']);
    $mobile = $db->escapeString(($_POST['mobile']));
    $passengers = $db->escapeString(($_POST['passengers']));
    $pick_address = $db->escapeString(($_POST['pick_address']));
    $drop_address = $db->escapeString(($_POST['drop_address']));
    $date = $db->escapeString(($_POST['date']));
    $time = $db->escapeString(($_POST['time']));
    $category = $db->escapeString(($_POST['category']));
    $vehicle_type = $db->escapeString(($_POST['vehicle_type']));
    $error = array();

   
   if (!empty($name) && !empty($mobile) && !empty($email) && !empty($date) && !empty($pick_address) && !empty($drop_address)  && !empty($time) && !empty($category) && !empty($vehicle_type) ) 
   {
        $sql_query = "INSERT INTO bookings (name,mobile,email,date,time,pick_address,drop_address,category,vehicle_type,passengers)VALUES('$name','$mobile','$email','$date','$time','$pick_address','$drop_address','$category','$vehicle_type','$passengers')";
        $db->sql($sql_query);
        $result = $db->getResult();
        if (!empty($result)) {
            $result = 0;
        } else {
            $result = 1;
        }
        if ($result == 1) {
            $error['add_booking'] = "<section class='content-header'>
                                            <span class='label label-success'>Booked Successfully</span> </section>";
        } else {
            $error['add_booking'] = " <span class='label label-danger'>Failed</span>";
        }
    }
}
      
?>
<?php
if (isset($_POST['btnDriver'])) {

                $name = $db->escapeString(($_POST['name']));
                $email = $db->escapeString($_POST['email']);
                $mobile = $db->escapeString(($_POST['mobile']));
                $dob = $db->escapeString($_POST['dob']);
                $address = $db->escapeString($_POST['address']);
                $pincode = $db->escapeString($_POST['pincode']);
                $category = $db->escapeString(($_POST['category']));
                $vehicle_type = $db->escapeString(($_POST['vehicle_type']));
                $vehicle_number = $db->escapeString($_POST['vehicle_number']);
                $error = array();

              // get Profile image info
              $menu_image = $db->escapeString($_FILES['profile_image']['name']);
              $image_error = $db->escapeString($_FILES['profile_image']['error']);
              $image_type = $db->escapeString($_FILES['profile_image']['type']);

              //  RC Image info
              $menu_image = $db->escapeString($_FILES['rc_image']['name']);
              $image_error = $db->escapeString($_FILES['rc_image']['error']);
              $image_type = $db->escapeString($_FILES['rc_image']['type']);

              //License Image info
              $menu_image = $db->escapeString($_FILES['license_image']['name']);
              $image_error = $db->escapeString($_FILES['license_image']['error']);
              $image_type = $db->escapeString($_FILES['license_image']['type']);

                // common image file extensions
            $allowedExts = array("gif", "jpeg", "jpg", "png");

            // get profile_image file extension
            error_reporting(E_ERROR | E_PARSE);
            $extension = end(explode(".", $_FILES["profile_image"]["name"]));

            //get rc_image file extension
            error_reporting(E_ERROR | E_PARSE);
            $extension = end(explode(".", $_FILES["rc_image"]["name"]));

            //get license_image file extension
            error_reporting(E_ERROR | E_PARSE);
            $extension = end(explode(".", $_FILES["license_image"]["name"]));


      if (!empty($name) && !empty($mobile) && !empty($email) && !empty($address) && !empty($pincode) && !empty($dob)&& !empty($category)) 
      {
        // create random image file name
        $string = '0123456789';
        $file = preg_replace("/\s+/", "_", $_FILES['profile_image']['name']);
        $menu_image = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;

        // upload new image
        $upload = move_uploaded_file($_FILES['profile_image']['tmp_name'], 'upload/driver/' . $menu_image);

        // insert new data to menu table
        $upload_image = $menu_image;
        $upload_image1 ='';
        $upload_image2 ='';

        //rc_image info
        if ($_FILES['rc_image']['size'] != 0 && $_FILES['rc_image']['error'] == 0 && !empty($_FILES['rc_image'])){
            // create random image1 file name
            $string = '0123456789';
            $file = preg_replace("/\s+/", "_", $_FILES['rc_image']['name']);
            $image1 = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;

            //upload new image1
            $upload = move_uploaded_file($_FILES['rc_image']['tmp_name'], 'upload/driver-proof/' . $image1);

            // insert new data to menu table
            $upload_image1 = $image1;
       
        }
         //license_image info
        if ($_FILES['license_image']['size'] != 0 && $_FILES['license_image']['error'] == 0 && !empty($_FILES['license_image'])){
            // create random image2 file name
            $string = '0123456789';
            $file = preg_replace("/\s+/", "_", $_FILES['license_image']['name']);
            $image2 = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;

            //upload new image2
            $upload = move_uploaded_file($_FILES['license_image']['tmp_name'], 'upload/driver-proof/' . $image2);

            // insert new data to menu table
            $upload_image2 = $image2;

        }
   
    $sql_query = "INSERT INTO drivers (name,email,mobile,dob,address,pincode,category,vehicle_type,vehicle_number,profile_image,rc_image,license_image) VALUES ('$name','$email','$mobile','$dob','$address','$pincode','$category','$vehicle_type','$vehicle_number','$upload_image','$upload_image1','$upload_image2')";
    $db->sql($sql_query);
    $result = $db->getResult();
    if (!empty($result)) {
        $result = 0;
    } else {
        $result = 1;
    }

    if ($result == 1) {
        $error['add_driver'] = " <section class='content-header'><span class='label label-success'>Driver Added Successfully</span></section>";
    } else {
        $error['add_driver'] = " <span class='label label-danger'>Failed!</span>";
    }
    }
}
?>
<?php
if (isset($_POST['btnMessage'])) {
    $name = $db->escapeString(($_POST['name']));
    $email = $db->escapeString($_POST['email']);
    $message = $db->escapeString(($_POST['message']));
    $subject = (isset($_POST['subject']) && !empty($_POST['subject'])) ? $db->escapeString($fn->xss_clean($_POST['subject'])) : "";
    $mobile = (isset($_POST['mobile']) && !empty($_POST['mobile'])) ? $db->escapeString($fn->xss_clean($_POST['mobile'])) : "";

    $error = array();

   
   if (!empty($name) && !empty($message) && !empty($email)) 
   {
        $sql_query = "INSERT INTO messages (name,mobile,email,subject,message)VALUES('$name','$mobile','$email','$subject','$message')";
        $db->sql($sql_query);
        $result = $db->getResult();
        if (!empty($result)) {
            $result = 0;
        } else {
            $result = 1;
        }
        if ($result == 1) {
            $error['add_message'] = "<section class='content-header'>
                                            <span class='label label-success'>Message Sent Successfully</span> </section>";
        } else {
            $error['add_message'] = " <span class='label label-danger'>Failed</span>";
        }
    }
}
      
?>


<!DOCTYPE html>
<html lang="en">
  <!-- Mirrored from ashik.templatepath.net/conexi-preview-files/book-ride.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 24 Jan 2023 10:59:06 GMT -->
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Confirmation | GoodDe</title>
    <link
      rel="apple-touch-icon"
      sizes="57x57"
      href="images/favicon/apple-icon-57x57.png"
    />
    <link
      rel="apple-touch-icon"
      sizes="60x60"
      href="images/favicon/apple-icon-60x60.png"
    />
    <link
      rel="apple-touch-icon"
      sizes="72x72"
      href="images/favicon/apple-icon-72x72.png"
    />
    <link
      rel="apple-touch-icon"
      sizes="76x76"
      href="images/favicon/apple-icon-76x76.png"
    />
    <link
      rel="apple-touch-icon"
      sizes="114x114"
      href="images/favicon/apple-icon-114x114.png"
    />
    <link
      rel="apple-touch-icon"
      sizes="120x120"
      href="images/favicon/apple-icon-120x120.png"
    />
    <link
      rel="apple-touch-icon"
      sizes="144x144"
      href="images/favicon/apple-icon-144x144.png"
    />
    <link
      rel="apple-touch-icon"
      sizes="152x152"
      href="images/favicon/apple-icon-152x152.png"
    />
    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="images/favicon/apple-icon-180x180.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="192x192"
      href="images/favicon/android-icon-192x192.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="images/favicon/favicon-32x32.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="96x96"
      href="images/favicon/favicon-96x96.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="images/favicon/favicon-16x16.png"
    />
    <link rel="manifest" href="images/favicon/manifest.json" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-TileImage" content="../ms-icon-144x144.html" />
    <meta name="theme-color" content="#ffffff" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <style>
      body{
        background-color:white!important;
      }
      #confirmed{
        margin-top:25%!important;
        align-items:center!important;
        font-size:25px;
        font-weight:bold;
      }
      .top-bar{
        background-color:black;
      }
    </style>
  </head>

  <body>
    <div class="preloader"></div>
    <!-- /.preloader -->
      <header class="site-header header-one">
        <div class="top-bar">
          <div class="container">
            <div class="left-block">
              <a href="#"><i class="fa fa-user-circle"></i> Customer Sign In</a>
              <a href="#"><i class="fa fa-envelope"></i> needhelp@goodde.com</a>
            </div>
            <!-- /.left-block -->
            <div class="logo-block">
              <a href="index.html"
                ><img src="images/resources/logo-1-1.png" alt="Awesome Image"
              /></a>
            </div>
            <!-- /.logo-block -->
            <div class="social-block">
              <a href="#"><i class="fa fa-twitter"></i></a>
              <a href="#"><i class="fa fa-facebook-f"></i></a>
              <a href="#"><i class="fa fa-youtube-play"></i></a>
              <a href="#"><i class="fa fa-google-plus"></i></a>
            </div>
            <!-- /.social-block -->
          </div>
          <!-- /.container -->
        </div>
        <!-- /.top-bar -->
      </header>
      <!-- /.site-header header-one -->
     <div class="container" id="confirmed">
        <div class="text-center">
                <img src="images/check.png" alt="" height="50" width="50"><br><br>
              Success!... We will contact You soon....
          </div>
  
     </div>
    <!-- /.scroll-to-top -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/jquery.bxslider.min.js"></script>
    <script src="js/theme.js"></script>
  </body>
  <script>
      setTimeout(function(){
          window.location.href = "index.html";
      }, 2000); // 2000 milliseconds = 2 seconds
</script>

</html>
