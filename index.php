<?php
include 'functions.php';
if (!_session('login'))
	header("location:login.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="icon" href="favicon.ico" />

	<title>Fuzzy Tsukamoto Produksi</title>
	<link href="assets/css/sandstone-bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/general.css" rel="stylesheet" />
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
</head>

<body>
	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="?">Tsukamoto Produksi</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<?php if (empty($_SESSION['login'])) : ?>
						<li><a href="?m=hitung"><span class="glyphicon glyphicon-calendar"></span> Perhitungan</a></li>
						<li><a href="?m=login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
					<?php else : ?>
						<li><a href="?m=produk"><span class="glyphicon glyphicon-th"></span> Produk</a></li>
						<li><a href="?m=training"><span class="glyphicon glyphicon-th-large"></span> Training</a></li>
						<li class="dropdown">
							<a href="?m=produk" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-th"></span> Tsukamoto <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="?m=aturan"><span class="glyphicon glyphicon-th"></span> Aturan</a></li>
								<li><a href="?m=hitung"><span class="glyphicon glyphicon-signal"></span> Perhitungan</a></li>
								<li><a href="?m=hasil"><span class="glyphicon glyphicon-calendar"></span> Hasil</a></li>
							</ul>
						</li>
						<li><a href="?m=password"><span class="glyphicon glyphicon-lock"></span> Password</a></li>
						<li><a href="aksi.php?act=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
					<?php endif ?>
				</ul>
				<div class="navbar-text"></div>
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>

	<div class="container">
		<?php
		if (file_exists($mod . '.php'))
			include $mod . '.php';
		else
			include 'home.php';
		?>
	</div>
	<footer class="footer bg-primary">
		<div class="container">
			<p>Copyright &copy; <?= date('Y') ?> RumahSourceCode.Com <em class="pull-right">Updated 25 Maret 2023</em></p>
		</div>
	</footer>
	<script type="text/javascript">
		$('.form-control').attr('autocomplete', 'off');
	</script>
</body>

</html>