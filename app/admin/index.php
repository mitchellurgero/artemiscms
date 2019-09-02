<?php
session_start();
include(__DIR__."/../config.php");
$folder = __DIR__."/../pages/";
if(!$config['admin']){ die(); }
//Process login if needed
if(isset($_POST['inputUsername'])){
	$username = trim($_POST['inputUsername']);
	$password = $_POST['inputPassword'];
	if(array_key_exists($username, $users)){
		//User exists, test password.
		if(password_verify($password,$users[$username])){
			$_SESSION['username'] = $username;
		}
	}
}
if(isset($_GET['logout'])){
	session_unset();
	session_destroy();
	session_start();
	session_regenerate_id(true);
	header("Location: ./");
	die();	
}
if(isset($_POST['pageData'])){
	//we got page data, let's save it.
	$filename = $folder.$_POST['filename'];
	$pageData = $_POST['pageData'];
	
	file_put_contents($filename, $pageData);
}
?>
<!DOCTYPE html>
<html lang="em">
	<head>
		<meta charset="utf-8">
		<title>Artimes Admin</title>
		<link rel="stylesheet" href="../theme/materia.css">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php
if(!isset($_SESSION['username'])){
	?>
			<style>
			html,
			body {
			  height: 100%;
			}
			
			body {
			  display: -ms-flexbox;
			  display: flex;
			  -ms-flex-align: center;
			  align-items: center;
			  padding-top: 40px;
			  padding-bottom: 40px;
			  background-color: #f5f5f5;
			}
			
			.form-signin {
			  width: 100%;
			  max-width: 330px;
			  padding: 15px;
			  margin: auto;
			}
			.form-signin .checkbox {
			  font-weight: 400;
			}
			.form-signin .form-control {
			  position: relative;
			  box-sizing: border-box;
			  height: auto;
			  padding: 10px;
			  font-size: 16px;
			}
			.form-signin .form-control:focus {
			  z-index: 2;
			}
			.form-signin input[type="email"] {
			  margin-bottom: -1px;
			  border-bottom-right-radius: 0;
			  border-bottom-left-radius: 0;
			}
			.form-signin input[type="password"] {
			  margin-bottom: 10px;
			  border-top-left-radius: 0;
			  border-top-right-radius: 0;
			}
		</style>
	<?php
}
?>
	</head>
		<?php
		if(isset($_SESSION['username'])){
			//Body for editing pages
			?>
	<body>
		<br>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3">
					<span><a href="?logout" class="btn btn-sm btn-danger">Logout</a></span>
				</div>
				<div class="col-md-9">
					
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-3">
					<h3>Pages</h3>
					<hr>
					<a href="?newPage" class="btn btn-sm btn-success">New Page</a>
					<br><br>
					<ul>
					<?php
					//List pages available, and a link to create new ones if needed.
					
					$pages = rglob($folder."*.md");
					foreach($pages as $page){
						$p = str_replace(array($folder,".."),array("",""),$page);
						echo '<li><a href="?editPage='.$p.'">'.$p.'</a>'."</li>";
					}
					?>
					</ul>
				</div>
				<div class="col-md-9">
					<h3>Editor</h3>
					<hr>
					<form action="index.php" method="POST">
						<span><button type="submit" class="btn btn-sm btn-success">Save Page Data</button></span>
						<span>&nbsp;&nbsp;&nbsp;Please make sure to use <a href="http://www.markitdown.net/markdown">markdown</a> to create and edit pages.</span>
					<?php
					$pageData = "";
					if(isset($_GET['editPage'])){
						$pn = str_replace(array($folder,".."),array("",""), $_GET['editPage']);
						if(file_exists($folder."$pn")){
							$pageData = file_get_contents($folder."$pn");
						} else {
							
						}
					}
					?>
					<br><br>
					<textarea id="pageData" name="pageData" class="" style="width:100%; height:75vh;"><?php echo $pageData; ?></textarea>
					<input type="hidden" name="filename" id="filename" value="<?php echo $pn ?>">
					</form>
				</div>
			</div>
		</div>
	</body>
			<?php
		} else {
			//Login page
			?>
	<body class="text-center">
		<form class="form-signin" action="index.php" method="POST">
	      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
	      <label for="inputUsername" class="sr-only">Username:</label>
	      <input type="text" id="inputUsername" name="inputUsername" class="form-control" placeholder="Username" required autofocus>
	      <label for="inputPassword" class="sr-only">Password</label>
	      <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
	      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
	      <br>
	      <p class="float-right">Powered by <a href="https://github.com/mitchellurgero/artemiscms" target="_blank">Artemis</a></p>
    	</form>
	</body>
			<?php
		}
		?>

</html>

<?php
function rglob($pattern, $flags = 0) {
    $files = glob($pattern, $flags); 
    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
        $files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
    }
    return $files;
}
?>