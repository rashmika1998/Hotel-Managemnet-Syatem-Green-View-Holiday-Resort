<?php require_once('Backend/taxisession.php'); ?>
<?php
	$errors = array();
	$reservation_id = '';
	$full_name = '';
	$email = '';
	$tel_number = '';
	$reserved_room_no = '';
	$time = '';
	$date = '';
    
    if(isset($_GET['reservation_id'])) {
        //getting user information
        $reservation_id = mysqli_real_escape_string($db, $_GET['reservation_id']);
        $query = "SELECT * FROM taxicustomer WHERE user_id = {$reservation_id} LIMIT 1";
    
       $result_set = mysqli_query($db, $query);
       
       if($result_set) {
           if (mysqli_num_rows($result_set) == 1) {
               //user found
               $result = mysqli_fetch_assoc($result_set);
               $full_name = $result['full_name'];
	           $email = $result['email'];
	           $tel_number = $result['tel_number'];
	           $reserved_room_no = $result['reserved_room_no'];
	           $time = $result['time'];
	           $date = $result['date'];
                  
           } else {
               //user not found
               header('location: viewtaxi.php?err=customer_not_found');
           }
       } else {
           //query unsuccessfull
           header('location: edittaxi.php?err=query_failed');
       }
    
    }

	
	if(isset($_POST['submit'])) {

        $reservation_id = $_POST['reservation_id'];
		$full_name = $_POST['full_name'];
		$email = $_POST['email'];
		$tel_number = $_POST['tel_number'];
		$reserved_room_no = $_POST['reserved_room_no'];
		$time = $_POST['time'];
		$date = $_POST['date'];

		//checking required fields
		$req_fields = array('full_name','email','tel_number','reserved_room_no','time','date');

		foreach ($req_fields as $field) {
			if (empty(trim($_POST[$field]))) {
				$errors[] = $field . ' is requierd';
			}
		}

		//checking if email address already exists
		$email = mysqli_real_escape_string ($db, $_POST['email']);
		$query = "SELECT * FROM taxicustomer WHERE email = '{$email}' AND user_id != {$reservation_id} LIMIT 1";

		$result_set = mysqli_query($db, $query);

		
		

		if(empty($errors)) {
			//no errors found..adding new record
			$full_name = mysqli_real_escape_string($db, $_POST['full_name']);
			$email = mysqli_real_escape_string($db, $_POST['email']);
			$tel_number = mysqli_real_escape_string($db, $_POST['tel_number']);
			$reserved_room_no = mysqli_real_escape_string($db, $_POST['reserved_room_no']);
			$time = mysqli_real_escape_string($db, $_POST['time']);
			$date = mysqli_real_escape_string($db, $_POST['date']);
			 
			$query = "UPDATE taxicustomer SET ";
			$query .= "`full_name` = '{$full_name}', ";
			$query .= "email = '{$email}', ";
			$query .= "tel_number = '{$tel_number}', ";
            $query .= "reserved_room_no = '{$reserved_room_no}', ";
            $query .= "time = '{$time}', ";
            $query .= "date = '{$date}' ";
			$query .= "WHERE user_id = {$reservation_id} LIMIT 1";
            
            

			$result = mysqli_query($db, $query);

			if ($result){
				//query successfull
				header('Location: viewtaxi.php?reservation_changed=true');
			}else{
				$errors[] = 'Failed to modify the record.';
				
			}


		}

	}


	?>
	<!doctype html>
	<html class="no-js" lang="zxx">
		<head>
			<meta charset="utf-8">
			<meta http-equiv="x-ua-compatible" content="ie=edge">
			<title>Green View Holiday Resort | Home</title>
			<meta name="description" content="">
			<meta name="viewport" content="width=device-width, initial-scale=1">
	
			<link rel="manifest" href="site.webmanifest">
			<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
	
			<!-- CSS here -->
				
				<link rel="stylesheet" href="assets/css/bootstrap.min.css">
				<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
				<link rel="stylesheet" href="assets/css/gijgo.css">
				<link rel="stylesheet" href="assets/css/slicknav.css">
				<link rel="stylesheet" href="assets/css/animate.min.css">
				<link rel="stylesheet" href="assets/css/magnific-popup.css">
				<link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
				<link rel="stylesheet" href="assets/css/themify-icons.css">
				<link rel="stylesheet" href="assets/css/slick.css">
				<link rel="stylesheet" href="assets/css/nice-select.css">
				<link rel="stylesheet" href="assets/css/style.css">
				<link rel="stylesheet" href="assets/css/responsive.css">
				<link rel="stylesheet" href="assets/css/taxi.css">


	   </head>
	
	   <body>
		   
		<!-- Preloader Start -->
		<div id="preloader-active">
			<div class="preloader d-flex align-items-center justify-content-center">
				<div class="preloader-inner position-relative">
					<div class="preloader-circle"></div>
					<div class="preloader-img pere-text">
						<strong>Green View Holiday</b>
					</div>
				</div>
			</div>
		</div>
		<!-- Preloader Start -->
	
		<header>
			<!-- Header Start -->
		   <div class="header-area header-sticky">
				<div class="main-header ">
					<div class="container">
						<div class="row align-items-center">
							<!-- logo -->
							<div class="col-xl-2 col-lg-2">
								<div class="logo">
								   <a href="index.php"><img src="assets/img/logo/logo-img.png" alt=""></a>
								</div>
							</div>
						<div class="col-xl-8 col-lg-8">
								<!-- main-menu -->
								<div class="main-menu f-right d-none d-lg-block">
									<nav>
										<ul id="navigation">                                                                                                                                     
											<li><a href="index.php">Home</a></li>
											<li><a href="about.php">About</a></li>
											<li><a href="services.php">Service</a></li>
											<li><a href="#">Pages</a>
												<ul class="submenu">
													<li><a href="rooms.php">Rooms</a></li>
													<li><a href="###">Halls</a></li>
													<li><a href="Promotion.php">Promotions</a></li>
													<li><a href="blog.php">Blog</a></li>
													<li><a href="taxi.php">Taxi Reservation</a></li>
												</ul>
											</li>
											<li><a href="contact.php">Contact</a></li>
											<li><a href="">Logout</a>
                                            <ul class="submenu">
                                                <li><a href="Backend/logout.inc.php">Logout</a></li>
													<li><a href="register.php">SignUp</a></li>
												</ul>
											</li>
										</ul>
									</nav>
								</div>
							</div>             
							<div class="col-xl-2 col-lg-2">
								<!-- header-btn -->
								<div class="header-btn">
									<a href="#" class="btn btn1 d-none d-lg-block ">Book Online</a>
								</div>
							</div>
							
							<!-- Mobile Menu -->
							<div class="col-12">
								<div class="mobile_menu d-block d-lg-none"></div>
							</div>
						</div>
					</div>
				</div>
		   </div>
			<!-- Header End -->
		</header>
<main>
	<h1>Change your Reservation<button class="btn"><a href="viewtaxi.php">Back</a></button></h1>
	<div class="alerttaxi">
  	<span class="closebtntaxi" onclick="this.parentElement.style.display='none';">&times;</span> 
	  <strong>Please Note !</strong> You can't change the location, taxi fee and vehicle type.
	   If you want, please delete this reservation and make a new one. Thank you...
	</div>
	
	<?php
		if(!empty($errors)) {
			echo '<div class="errmsg">';
			echo '<b>There were error(s) on your form.</b><br>';
			foreach ($errors as $error) {
				$error = ucfirst(str_replace("_"," ",$error));
				echo '- '. $error . '<br>';
			}
			echo '</div>';
		}
	?>
	
	<form action="edittaxi.php" method="post" class="userform">
    
	<input type="hidden" name="reservation_id" value="<?php echo $reservation_id;?>">
    
	<p>
		<label for="">Full Name:</label>
		<input type="text" name="full_name" placeholder="Enter your Full Name" <?php echo 'value="' . $full_name .'"';  ?>>
	</p>

	<p>
		<label for="">Email:</label>
		<input type="email" name="email" placeholder="Enter your Email" <?php echo 'value="' . $email .'"';  ?>>
	</p>

	<p>
		<label for="">Phone:</label>
		<input type="tel" placeholder="Enter your phone number" name="tel_number" pattern="[0-9]{3}-[0-9]{7 }" <?php echo 'value="' . $tel_number .'"';  ?>>
		<small>012-3456789</small>
	</p>

	<p>
		<label for="">Reserved Room No:</label>
		<input type="number" name="reserved_room_no" placeholder="Enter your room number" <?php echo 'value="' . $reserved_room_no .'"';  ?>>
	</p>

	<p>
	<label for="">Time:</label>
	<input type="time" name="time" <?php echo 'value="' . $time .'"';  ?>>
	</p>

	<p>
	<label class="form-label">Pickup Date:</label>
	<input class="form-control" type="date" name="date" <?php echo 'value="' . $date .'"';  ?>>
	</p>

	<p>
		
		<label for="">&nbsp;</label>
		<button class="btn" type="submit" name="submit">modify</button>
	</p>
	


	</form>
</main>
<footer>
       <!-- Footer Start-->
       <div class="footer-area black-bg footer-padding">
           <div class="container">
               <div class="row d-flex justify-content-between">
                   <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                      <div class="single-footer-caption mb-30">
                         <!-- logo -->
                         <div class="footer-logo">
                           <a href="index.html"><img src="assets/img/logo/footer-img.png" alt=""></a>
                         </div>
                         <div class="footer-social footer-social2">
                             <a href="https://www.facebook.com"><i class="fab fa-facebook-f"></i></a>
                             <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
                             <a href="#"><i class="fas fa-globe"></i></a>
                             <a href="#"><i class="fab fa-behance"></i></a>
                         </div>
                         <div class="footer-pera">
                              <p>
                                    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved by <a href="###" target="_blank">Green View Holiday Resort</a>
                              </p>
                         </div>
                      </div>
                   </div>
                   <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5">
                       <div class="single-footer-caption mb-30">
                           <div class="footer-tittle">
                               <h4>Quick Links</h4>
                               <ul>
                                   <li><a href="about.php">About Us</a></li>
                                   <li><a href="rooms.php">Our Best Rooms</a></li>
                                   <li><a href="#">Our Photo Gellary</a></li>
                                   <li><a href="services.php">Pool Service</a></li>
                                   <li><a href="taxi.php">Taxi Service</a></li>
                               </ul>
                           </div>
                       </div>
                   </div>
                   <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                       <div class="single-footer-caption mb-30">
                           <div class="footer-tittle">
                               <h4>Reservations</h4>
                               <ul>
                                   <li><a href="#">Tel: +9478 893 38 67</a></li>
                                   <li><a href="#">Skype: Green View Holiday</a></li>
                                   <li><a href="#">Reservations@greenviewholiday.com</a></li>
                               </ul>
                           </div>
                       </div>
                   </div>
                   <div class="col-xl-3 col-lg-3 col-md-4  col-sm-5">
                       <div class="single-footer-caption mb-30">
                           <div class="footer-tittle">
                               <h4>Our Location</h4>
                               <ul>
                                   <li><a href="#">221/3,Ranala Road,Hoabarakada,</a></li>
                                   <li><a href="#">Homagama,Sri Lanka SL 10204</a></li>
                               </ul>
                               <!-- Form -->
                                <div class="footer-form" >
                                    <div id="mc_embed_signup">
                                        <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                                        method="get" class="subscribe_form relative mail_part">
                                            <input type="email" name="email" id="newsletter-form-email" placeholder="Email Address"
                                            class="placeholder hide-on-focus" onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = ' Email Address '">
                                            <div class="form-icon">
                                              <button type="submit" name="submit" id="newsletter-submit"
                                              class="email_icon newsletter-submit button-contactForm"><img src="assets/img/logo/form-iocn.jpg" alt=""></button>
                                            </div>
                                            <div class="mt-10 info"></div>
                                        </form>
                                    </div>
                                </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <!-- Footer End-->
   </footer>
   
	<!-- JS here -->
	
		<!-- All JS Custom Plugins Link Here here -->
        <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
		
		<!-- Jquery, Popper, Bootstrap -->
		<script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
        <script src="./assets/js/popper.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
	    <!-- Jquery Mobile Menu -->
        <script src="./assets/js/jquery.slicknav.min.js"></script>

		<!-- Jquery Slick , Owl-Carousel Plugins -->
        <script src="./assets/js/owl.carousel.min.js"></script>
        <script src="./assets/js/slick.min.js"></script>
        <!-- Date Picker -->
        <script src="./assets/js/gijgo.min.js"></script>
		<!-- One Page, Animated-HeadLin -->
        <script src="./assets/js/wow.min.js"></script>
		<script src="./assets/js/animated.headline.js"></script>
        <script src="./assets/js/jquery.magnific-popup.js"></script>

		<!-- Scrollup, nice-select, sticky -->
        <script src="./assets/js/jquery.scrollUp.min.js"></script>
        <script src="./assets/js/jquery.nice-select.min.js"></script>
		<script src="./assets/js/jquery.sticky.js"></script>
        
        <!-- contact js -->
        <script src="./assets/js/contact.js"></script>
        <script src="./assets/js/jquery.form.js"></script>
        <script src="./assets/js/jquery.validate.min.js"></script>
        <script src="./assets/js/mail-script.js"></script>
        <script src="./assets/js/jquery.ajaxchimp.min.js"></script>
        
		<!-- Jquery Plugins, main Jquery -->	
        <script src="./assets/js/plugins.js"></script>
        <script src="./assets/js/main.js"></script>
        
    </body>
</html>
<?php mysqli_close($db); ?>