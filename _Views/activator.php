<html>
<head>
	<title>Activator - HijaIyh </title>
		<link rel="icon"  href="./HijaIyh_App/assets/img/hijaiyh-logo.png">
	<link rel="stylesheet" href="https://fedoracss.github.io/dist/css/fedora.min.css" type="text/css">
	<!-- <script src="https://kit.fontawesome.com/aafae70235.js"></script> -->
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>

	<div class="container">
		<br><br><br>
		<?php
		//$view ='';
		if(empty($this->uri->segment(2))){

			//echo $view;
			?>
	<div class="spacer-large pl-large pr-large bg-dark text-white" style="max-width: 70%;margin:0 auto;border-radius: 20px;box-shadow: 0px 0px 30px #333">
		<center><img src="https://hijaiyh.me/assets/images/hijaiyh-logo.png" style="max-width: 100px;max-height: 100px">
			<h2>Input SIGNATURE KEY & ACCOUNT KEY</h2></center>
			<?=form_open('activation/check');?>
				
					<input type="text" class="input" name="signature" placeholder="IYH-SIG-SIGNATUREKEY" ><br><br>
					<input type="text" class="input" name="account" placeholder="IYH-KEY-ACCOUNTKEY" >
				<br><br>
					<button type="submit" class="btn primary full-width" name="in"><i class="fa fa-sign-in"></i> ACTIVATE</button>
				
			
			<?=form_close();?>
		</div>
		<?php
	}else{
		//print_r($view);
		echo $view;
		echo "<meta http-equiv='refresh' content='2;url=".base_url('auth/signin')."'> ";
	}
	?>
	</div>
</body>
</html>