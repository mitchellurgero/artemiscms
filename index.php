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
require_once("$dir/app/plugins.php");
//Composer stuff
require_once("$dir/app/vendor/autoload.php");

//Start grabbing classes :D
$parsedown = new ParsedownExtra();
$smarty = new Smarty();
$smarty->setTemplateDir($config->sm_template['TemplateDir']);
$smarty->setCompileDir($config->sm_template['CompileDir']);
$smarty->setConfigDir($config->sm_template['ConfigDir']);
$smarty->setCacheDir($config->sm_template['CacheDir']);
$template = "page";

//Start processing page
$page = "";
if(isset($_REQUEST['page'])){
	$page = $_REQUEST['page'];
} else {
	$page = "home.md";
}
if(!endsWith($config->location,"/")){
	$config->location = $config->location."/";
}
if(strpos($page, "..") !== false){
	$page = str_replace("..",".", $page);
}

// Assign smarty vars before page load
$smarty->assign("CONFIG", $config);

//Generate menu
$navMenu = '';
if(isset($config->menu)){
	foreach($config->menu as $title=>$item){
		if(is_array($item)){
			$navMenu .= '<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">'.$title.'</a>
				  <div class="dropdown-menu">';
			foreach($item as $titleSub=>$itemSub){
				$navMenu .= '<a class="dropdown-item" href="'.$config->location.$itemSub.'">'.$titleSub.'</a>';
			}
			$navMenu .= '</div>
				</li>';
		} else {
			$navMenu .= '<li class="nav-item">
			<a class="nav-link" href="'.$config->location.$item.'">'.$title.'</a>
		</li>';
		}
	}
}
$smarty->assign("MENU", $navMenu);

//Page type processing
$dir = __DIR__;
	
$file = $dir."/app/pages/".$page;
$fileData = "";
$fileFinal = "";
$ini = "";
$iniData = array();
$pageData = "";
$c = 0;

if(file_exists($file)){
	if(is_dir($file)){
		$file = rtrim($file, '/');
		if(file_exists($file."/index.md")){
			//Allows for index files (for folders that are linked.)
			$file = $file."/index.md";
		}
		if(rtrim($page,"/") == "blog"){
			//We are on blog
			$iniData = array("title"=> "Blog Posts");
			$template = "blog-list";
		}
	}
	if($template === "blog-list"){
		$posts = 
		$fileData = <<<EOL
		---
		title = "Posts"
		---
		EOL;
		$posts =  array_diff(scandir(__DIR__."/app/pages/blog/"), array('..', '.'));
		
	} else {
		$fileData = file_get_contents($file);
	}

	foreach(preg_split("/((\r?\n)|(\r\n?))/", $fileData) as $line){
		if($line == "---" && $c < 2){
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
	   ->setMarkupEscaped(false)
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

$smarty->assign("PAGEDATA", $pageData);
$smarty->assign("TITLE", (isset($iniData['title']) ?  $iniData['title'] : $config->title));
$smarty->assign("DESC", (isset($iniData['desc']) ?  $iniData['desc'] : 'Page Description'));
$smarty->assign("AUTHOR", (isset($iniData['author']) ?  $iniData['author'] : 'Page Author'));
$smarty->assign("LOGO", (!empty($config->logo) ?  '<img style="max-height:32px !important;" class="rounded" src="'.$config->location.'app/'.$config->logo.'">' : $config->title));
$smarty->assign("COPYRIGHT", date("Y")."&nbsp;". $config->author);
$smarty->display("$template.tpl");
$smarty->assign("INI", $iniData);


function endswith($string, $test) {
    $strlen = strlen($string);
    $testlen = strlen($test);
    if ($testlen > $strlen) return false;
    return substr_compare($string, $test, $strlen - $testlen, $testlen) === 0;
}