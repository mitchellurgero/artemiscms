<?php

$users = array(
	"admin"		=> '$2y$10$clicLxJG/qOXhuBmdgJ7Y.ExvOv9yP.Fgc78hYR3HH2tzaw4VObBC', //Single quotes, not double - and use password_hash function to generate passwords.
	                // ^ The password is "password", however the admin panel has not been created yet!
	
);

$config = array(
	"theme"		=> "materia", //Filename of theme CSS minus the .css part.
	"style"		=> "primary", //primary, light, or dark for the navigation bar.
	"navbar"	=> "dark", //dark or light for the navigation bar.
	"location"	=> "http://localhost/", //Full URL to the hosted site.
	"title"		=> "Artemis CMS", //Title for the website.
	"desc"		=> "Flat-File CMS built with PHP7 & Markdown!", //Description for the site (when one is not set for the page)
	"author"	=> "Mitchell Urgero", //Website owner, author, etc.
	"logo"		=> "", //Logo image, leave blank to use title instead. place logo in app/img/ folder then put "img/image.png" in here.
	"menu"		=> array( //Menu for the site, this is a PHP array, use similar formatting as below. Will be placed in order that they are in as well.
					"Home"	=> "home.md",
					
					"Page 1"		=> "page1.md",
					
					"Sub-Menu"		=> array(
										"Item 1" => "sub1/item1.md",
										"Item 2" => "sub1/item2.md",
										),
					"Page2"			=> "page2.md"
	),
	
);
