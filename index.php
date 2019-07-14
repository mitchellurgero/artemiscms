<?php
session_start();
//Include libs and config:
$dir = __DIR__;
if(file_exists("$dir/app/config.php")){
	require_once("$dir/app/config.php");
} else {
	require_once("$dir/app/config.example.php");
}
require_once("$dir/app/libs/md.php");
$parsedown = new ParsedownExtra();
//Start processing page
$page = "";
if(isset($_REQUEST['page'])){
	$page = $_REQUEST['page'];
} else {
	$page = "home.md";
}

load_page($page, $users, $config);

function load_page($page, $users, $config){
	$dir = __DIR__;
	if(strpos($page, "..") !== false){
		$page = str_replace("..",".", $page);
	}
	$file = $dir."/app/pages/".$page;
	$fileData = "";
	$fileFinal = "";
	$ini = "";
	$iniData = "";
	$pageData = "";
	if(file_exists($file)){
		$fileData = file_get_contents($file);
		$c = 0;
		foreach(preg_split("/((\r?\n)|(\r\n?))/", $fileData) as $line){
		    if($line == "---"){
		    	$c++;
		    	continue;
		    }
		    if($c >= 2){
		    	$fileFinal .= $line."\r\n";
		    } else {
		    	$ini .= $line."\r\n";
		    }
		    
		}
		$iniData = parse_ini_string($ini);
		$pageData = Parsedown::instance()
   		->setMarkupEscaped(false) # escapes markup (HTML)
   		->text($fileFinal);
	} else {
		//file not found?????
		$iniData = array("title" => "404 Page Not Found");
		$pageData = '
		<div class="container">
			<br><br><br>
			<div class="row">
				<div class="col"><h3>The page you requested cannot be displayed at this time.</h3><p>Please contact the System Administrator for more details.</p></div>
			</div>
		</div>
		';
	}
	$css = $config['location']."app/css/bootstrap.min.css";
	if(!empty($config['theme'])){
		$css = $config['location']."app/theme/".$config['theme'].".css";
	}
	?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo (isset($iniData['title']) ?  $iniData['title'] : 'Title'); ?> | <?php echo $config['title'];?></title>
		<meta name="description" content="<?php echo (isset($iniData['desc']) ?  $iniData['desc'] : 'Page Description'); ?>">
		<meta name="author" content="<?php echo (isset($iniData['author']) ?  $iniData['author'] : 'Page Author'); ?>">
		<link rel="stylesheet" href="<?php echo $css; ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<style>
			html {
			  position: relative;
			  min-height: 100%;
			}
			body {
			  margin-bottom: 60px; /* Margin bottom by footer height */
			}
			.footer {
			  position: absolute;
			  bottom: 0;
			  width: 100%;
			  height: 60px; /* Set the fixed height of the footer here */
			  line-height: 60px; /* Vertically center the text there */
			  background-color: #f5f5f5;
			}
		</style>
	</head>
	<body>
		<script src="<?php echo $config['location']."app/js/jquery.min.js"; ?>"></script>
		<script src="<?php echo $config['location']."app/js/bootstrap.min.js"; ?>"></script>
	<nav class="navbar navbar-expand-sm bg-<?php echo $config['style']; ?> navbar-<?php echo $config['navbar']; ?>">
	<a class="navbar-brand" href="<?php echo $config['location']; ?>"><?php echo (!empty($config['logo']) ?  '<img src="'.$config['location'].'app/'.$config['logo'].'">' : $config['title']); ?></a>
	
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    	<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="collapsibleNavbar">
	<ul class="navbar-nav">
		<?php
		if(isset($config['menu'])){
			foreach($config['menu'] as $title=>$item){
				if(is_array($item)){
					echo '<li class="nav-item dropdown">
						  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">'.$title.'</a>
						  <div class="dropdown-menu">';
					foreach($item as $titleSub=>$itemSub){
						echo '';
						?>
						    <a class="dropdown-item" href="<?php echo $config['location'].$itemSub; ?>"><?php echo $titleSub; ?></a>
						<?php
					}
					echo '</div>
						</li>';
				} else {
					echo '';
				?>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo $config['location'].$item; ?>"><?php echo $title; ?></a>
				</li>
				<?php
				}
			}
		}
		?>
		
	</ul>
	</div>
	
	</nav>
	<br>
		<div class="container">
			<?php echo $pageData; ?>
			
		</div>
		<br>
		<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col">
					<span class="text-muted">Copyright &copy; <?php echo date("Y")."&nbsp;". $config['author']; ?></span>
				</div>
				<div class="col">
					<p class="float-right">Powered by <a href="https://github.com/mitchellurgero/artemiscms" target="_blank">Artemis</a></p>
				</div>
			</div>
			
		</div>
    </footer>
	</body>
</html>
	<?php
	
}