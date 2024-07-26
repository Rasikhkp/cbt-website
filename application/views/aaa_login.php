<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>LOGIN - <?php echo $this->config->item('nama_aplikasi') . " " . $this->config->item('versi'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="description" content="UMBKS - MI/MTs/MA - ">
	<meta name="apple-mobile-web-app-capable" content="yes">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
	<link href="<?php echo base_url(); ?>___/css/login.css" rel="stylesheet">

</head>

<body>
	<img class="logo-beasiswa" src="<?php echo base_url(); ?>___/img/Logo Beasiswa Cakrawala-color.png" alt="">

	<div class="my-card">
		<h2>Login to Your Account</h2>
		<p>Enter your username & password to login</p>

		<form action="" method="post" name="fl" id="f_login" onsubmit="return login();">
			<div>
				<label for="username">Username</label>
				<input style="font-family: 'Poppins';" type="text" id="username" name="username" placeholder="Your username here..." autofocus>
			</div>

			<div>
				<label for="password">Password</label>
				<input style="font-family: 'Poppins';" type="password" id="password" name="password" placeholder="**********">
			</div>

			<button>Login</button>
		</form>

	</div>

	<script src="<?php echo base_url(); ?>___/js/jquery-1.11.3.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

	<script type="text/javascript">
		base_url = "<?php echo base_url(); ?>";
		uri_js = "<?php echo $this->config->item('uri_js'); ?>";

		function tes() {
			console.log('sdflj')
		}
	</script>
	<script src="<?php echo base_url(); ?>___/js/aplikasi.js"></script>
</body>

</html>