<?php
define('SMARTY_RESOURCE_CHAR_SET', 'UTF-8');
$config  = new stdClass();

// Users for the janky admin portal
$users = array(
	"admin"		=> '$2y$10$clicLxJG/qOXhuBmdgJ7Y.ExvOv9yP.Fgc78hYR3HH2tzaw4VObBC', //Single quotes, not double - and use password_hash function to generate passwords.
	                // ^ The password is "password", however the admin panel has not been created yet!
);
// Admin Portal disabled by default
$config->admin = false;

// Full URL to the hosted site.
$config->location = "http://localhost"; 

// Basic Site Information
$config->title = 'Artemis CMS';
$config->desc = "Flat-File CMS built with PHP7 & Markdown!";
$config->author = "Mitchell Urgero";
// Logo image, leave blank to use title instead. place logo in app/img/ folder then put "img/image.png" in here.
$config->logo = "";

// Theme Information
$config->theme = "Default"; // Which template theme to use
$config->bootstrap = "litera"; // bootstrap (or bootstrap compatible CSS file to load)
$config->style = "primary"; // Bootstrap style to load
$config->navbar = "dark"; // Navbar default (usually dark / light)

// Navbar menu
$config->menu = array( //Menu for the site, this is a PHP array, use similar formatting as below. Will be placed in order that they are in as well.
	"Home"	   => "home.md",
	
	"Page 1"   => "page1.md",
	
	"Sub-Menu" => array(
			"Item 1" => "sub1/item1.md",
			"Item 2" => "sub1/item2.md",
			),
	"Page2"	   => "page2.md",
	"Page3"    => "folder1"
);


// Smarty Templates, you should not need to change these unless you absolutely need to
$config->sm_template = array(
	"TemplateDir"  => __DIR__."/theme/".$config->theme,
	"CompileDir"   => __DIR__."/t_compile/",
	"ConfigDir"    => __DIR__."/t_configs/",
	"CacheDir"  => __DIR__."/t_cache/"
);

