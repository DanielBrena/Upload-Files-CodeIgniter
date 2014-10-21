
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Admin -  Slide</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?=base_url()?>recursos/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=base_url()?>recursos/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
        rel="stylesheet">
<link href="<?=base_url()?>recursos/css/font-awesome.css" rel="stylesheet">
<link href="<?=base_url()?>recursos/css/style.css" rel="stylesheet">
<link href="<?=base_url()?>recursos/css/pages/dashboard.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="index.html">Administración</a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> Usuario<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?=base_url()?>index.php/home/logout">Cerrar sesión</a></li>
            </ul>
          </li>
        </ul>
        
      </div>
      <!--/.nav-collapse --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>
<!-- /navbar -->
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li class="active"><a href="<?=base_url()?>index.php/slide"><i class="icon-dashboard"></i><span>Slide</span> </a> </li>
        <li><a href="<?=base_url()?>index.php/noticia"><i class="icon-list-alt"></i><span>Noticias</span> </a> </li>
        
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        
        <!-- /span6 -->
        <div class="span12">
          
          <div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Subir imagen</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tab-pane" id="formcontrols">
								<form id="upload-file" class="form-horizontal">
									<fieldset>
										
										<div class="control-group">											
											<label class="control-label" for="username">Direccion URL</label>
											<div class="controls">
												<input type="text" class="span8" id="url" name="url" value="" placeholder="http://">
												<p class="help-block">La direccion se valida que sea http:// o https:// .</p>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="firstname">Imagen a subir</label>
											<div class="controls">
												<input type="file" name="imagen-file" id="imagen-file" >
												<!-- <input type="text" class="span6" id="firstname" value="John"> -->
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
													
											
										 <br />
										
											
										<div class="form-actions">
											<input type="submit" class="btn btn-primary" id="submit" value="Enviar">

											
										</div> <!-- /form-actions -->
									</fieldset>
								</form>
								</div>
								
							
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->
          
          <!-- /widget -->

          
          <div class="widget widget-table action-table">
            <div class="widget-header"> <i class="icon-th-list"></i>
              <h3>Imagenes</h3>
            </div>
            <!-- /widget-header -->

            <div id="imagenes">
         	  </div>

            
            <!-- /widget-content --> 
          </div>
          <!-- /widget --> 
          
          <!-- /widget -->
        </div>
        <!-- /span6 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>
<!-- /main -->
<div class="extra">
  <div class="extra-inner">
    <div class="container">
     
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /extra-inner --> 
</div>
<!-- /extra -->
<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <!-- /span12 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /footer-inner --> 
</div>
<!-- /footer --> 
<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster -->
<!--<script src="<?=base_url()?>recursos/js/jquery-1.7.2.min.js"></script>  
<script src="<?=base_url()?>recursos/js/jquery.js"></script>
<script src="<?=base_url()?>recursos/js/ajaxfileupload.js"></script>
<script src="<?=base_url()?>recursos/js/slide-upload-app.js"></script>
<script src="<?=base_url()?>recursos/js/base.js"></script>
-->
 
<script src="<?=base_url()?>recursos/js/jquery-1.7.2.min.js"></script> 

<script src="<?=base_url()?>recursos/js/bootstrap.js"></script>
 
<script src="<?=base_url()?>recursos/js/base.js"></script>


<script src="<?=base_url()?>recursos/js/ajaxfileupload.js"></script>
<script src="<?=base_url()?>recursos/js/slide-upload-app.js"></script>


</body>
</html>
