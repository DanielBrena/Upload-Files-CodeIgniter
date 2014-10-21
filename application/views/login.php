



<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Login</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    
<link href="<?=base_url()?>recursos/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>recursos/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

<link href="<?=base_url()?>recursos/css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    
<link href="<?=base_url()?>recursos/css/style.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>recursos/css/pages/signin.css" rel="stylesheet" type="text/css">

</head>

<body>
	
	<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<a class="brand" href="index.html">
				Admin -  Inicio de sesión				
			</a>		
			
				
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->

<?php 
		$usuario = array('name' => 'usuario', 'placeholder' => 'Nombre de usuario', 'class' => 'login username-field');
		$contrasena = array('name' => 'contrasena', 'placeholder' => 'Contraseña', 'class' => 'password username-field');
		$submit = array('name' => 'submit', 'value' => 'Iniciar Sesión', 'title' => 'Iniciar Sesión', 'class' => 'button btn btn-success btn-large');

?>

<div class="account-container">
	
	<div class="content clearfix">
		
		
		<?=form_open(base_url().'index.php/home/validar')?>
			<h1>Inicio de sesión</h1>		
			
			<div class="login-fields">
				
				<p>Por favor ingrese sus datos.</p>

				
				
				<div class="field">
					<label for="usuario">Nombre de usuario:</label>
					<?=form_input($usuario);?>
					<p><?=form_error("usuario")?></p>
					<!-- <label for="username">Username</label>
					<input type="text" id="username" name="username" value="" placeholder="Username" class="login username-field" />
									 -->
				</div> <!-- /field -->
				
				<div class="field">
					<!-- <label for="password">Password:</label>
					<input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
									 -->
					<label for="contrasena">Contraseña:</label>
					<?=form_password($contrasena);?>
					<p><?=form_error("contrasena")?></p>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<?=form_submit($submit)?>
				
									
				<!-- <button class="button btn btn-success btn-large">Sign In</button> -->
				
			</div> <!-- .actions -->
			
			
			
		
		<?=form_close()?>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->



<script src="<?=base_url()?>recursos/js/jquery-1.7.2.min.js"></script>
<script src="<?=base_url()?>recursos/js/bootstrap.js"></script>

<script src="<?=base_url()?>recursos/js/signin.js"></script>

</body>

</html>
