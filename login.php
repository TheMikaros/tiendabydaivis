<?php
session_start();
error_reporting(0);
include('includes/config.php');
// Registro de usuario
if(isset($_POST['submit']))
{
$name=$_POST['fullname'];
$email=$_POST['emailid'];
$contactno=$_POST['contactno'];
$password=md5($_POST['password']);
$query=mysqli_query($con,"insert into users(name,email,contactno,password) values('$name','$email','$contactno','$password')");
if($query)
{
	echo "<script>alert('Te registraste satisfactoriamente!!!');</script>";
}
else{
echo "<script>alert('Algo salió mal, intentalo nuevamente');</script>";
}
}
// Acceso de usuario
if(isset($_POST['login']))
{
   $email=$_POST['email'];
   $password=md5($_POST['password']);
$query=mysqli_query($con,"SELECT * FROM users WHERE email='$email' and password='$password'");
$num=mysqli_fetch_array($query);
if($num>0)
{
$extra="my-cart.php";
$_SESSION['login']=$_POST['email'];
$_SESSION['id']=$num['id'];
$_SESSION['username']=$num['name'];
$uip=$_SERVER['REMOTE_ADDR'];
$status=1;
$log=mysqli_query($con,"insert into userlog(userEmail,userip,status) values('".$_SESSION['login']."','$uip','$status')");
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
$extra="login.php";
$email=$_POST['email'];
$uip=$_SERVER['REMOTE_ADDR'];
$status=0;
$log=mysqli_query($con,"insert into userlog(userEmail,userip,status) values('$email','$uip','$status')");
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
$_SESSION['errmsg']="Invalid email id or Password";
exit();
}
}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="Proyecto tienda Online web">
		<meta name="author" content="David Salas y Pedro Ivan">

	    <title>Tienda Online | Signi-in | Signup</title>

	    <!-- Bootstrap Core CSS -->
	    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	    
	    <!-- Customizable CSS -->
	    <link rel="stylesheet" href="assets/css/main.css">
	    <link rel="stylesheet" href="assets/css/green.css">
	    <link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
		<link href="assets/css/lightbox.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/animate.min.css">
		<link rel="stylesheet" href="assets/css/rateit.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">

<script type="text/javascript">
function valid()
{
 if(document.register.password.value!= document.register.confirmpassword.value)
{
alert("Las contraseñas no coinciden !!!");
document.register.confirmpassword.focus();
return false;
}
return true;
}
</script>
    	<script>
function userAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'email='+$("#email").val(),
type: "POST",
success:function(data){
$("#user-availability-status1").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
	</head>
    <body class="cnt-home">
		<!-- ============================= seccion cabeza de pagina ============================= -->
<header class="header-style-1">
<?php include('includes/top-header.php');?>
<?php include('includes/main-header.php');?>
</header>
<!-- ================================= seccion cabeza de pagina ================================== -->
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="home.html">Inicio</a></li>
				<li class='active'>Autenticacion</li>
			</ul>
		</div>
	</div>
</div>

<div class="body-content outer-top-bd">
	<div class="container">
		<div class="sign-in-page inner-bottom-sm">
			<div class="row">
		<!-- Registro exitoso -->	
<div class="col-md-6 col-sm-6 sign-in">
	<h4 class="">Iniciar Sesión</h4>
	<p class="">Hola!, bienvenido de vuelta!</p>
	<form class="register-form outer-top-xs" method="post">
	<span style="color:red;" >
<?php
echo htmlentities($_SESSION['errmsg']);
?>
<?php
echo htmlentities($_SESSION['errmsg']="");
?>  <!-- =================== Formulario para iniciar sesion ================== -->
	</span>
		<div class="form-group">
		    <label class="info-title" for="exampleInputEmail1">Correo electrónico <span>*</span></label>
		    <input type="email" name="email" class="form-control unicase-form-control text-input" id="exampleInputEmail1" >
		</div>
	  	<div class="form-group">
		    <label class="info-title" for="exampleInputPassword1">Contraseña <span>*</span></label>
		 <input type="password" name="password" class="form-control unicase-form-control text-input" id="exampleInputPassword1" >
		</div>
		<div class="radio outer-xs">
		  	<a href="forgot-password.php" class="forgot-password pull-right">¿Olvidaste tu contraseña?</a>
		</div>
	  	<button type="submit" class="btn-upper btn btn-primary checkout-page-button" name="login">Iniciar Sesión</button>
	</form>					
</div>


<!-- ========================= Seccion para crear una nueva cuenta ===================== -->
<div class="col-md-6 col-sm-6 create-new-account">
	<h4 class="checkout-subtitle">registrate</h4>
	<p class="text title-tag-line">Crear nueva cuenta.</p>
	<form class="register-form outer-top-xs" role="form" method="post" name="register" onSubmit="return valid();">
<div class="form-group">
	    	<label class="info-title" for="fullname">Nombre completo <span>*</span></label>
	    	<input type="text" class="form-control unicase-form-control text-input" id="fullname" name="fullname" required="required">
	  	</div>

		<div class="form-group">
	    	<label class="info-title" for="exampleInputEmail2">Correo electrónico <span>*</span></label>
	    	<input type="email" class="form-control unicase-form-control text-input" id="email" onBlur="userAvailability()" name="emailid" required >
	    	       <span id="user-availability-status1" style="font-size:12px;"></span>
	  	</div>

<div class="form-group">
	    	<label class="info-title" for="contactno">Teléfono/Celular. <span>*</span></label>
	    	<input type="text" class="form-control unicase-form-control text-input" id="contactno" name="contactno" maxlength="10" required >
	  	</div>

<div class="form-group">
	    	<label class="info-title" for="password">Contraseña. <span>*</span></label>
	    	<input type="password" class="form-control unicase-form-control text-input" id="password" name="password"  required >
	  	</div>

<div class="form-group">
	    	<label class="info-title" for="confirmpassword">Confirmar contraseña. <span>*</span></label>
	    	<input type="password" class="form-control unicase-form-control text-input" id="confirmpassword" name="confirmpassword" required >
	  	</div>


	  	<button type="submit" name="submit" class="btn-upper btn btn-primary checkout-page-button" id="submit">Registrarse</button>
	</form>
	<span class="checkout-subtitle outer-top-xs">Registrate ahora y obten nuestros beneficios :  </span>
	<div class="checkbox">
	  	<label class="checkbox">
		  	Rapidez y seguridad en tu forma de pagos.
		</label>
		<label class="checkbox">
		Seguimiento de pedidos.
		</label>
		<label class="checkbox">
			Revisa tu Historial de pedidos.
		</label>
	</div>
</div>	
		</div>
		</div>
</div>
</div>
<?php include('includes/footer.php');?>
	<script src="assets/js/jquery-1.11.1.min.js"></script>
	
	<script src="assets/js/bootstrap.min.js"></script>
	
	<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	
	<script src="assets/js/echo.min.js"></script>
	<script src="assets/js/jquery.easing-1.3.min.js"></script>
	<script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/jquery.rateit.min.js"></script>
    <script type="text/javascript" src="assets/js/lightbox.min.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
	<script src="assets/js/scripts.js"></script>	

</body>
</html>