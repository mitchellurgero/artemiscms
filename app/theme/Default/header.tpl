<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>{$TITLE}</title>
		<meta name="description" content="{$DESC}">
		<meta name="author" content="{$AUTHOR}">
		<link rel="stylesheet" href="{$CONFIG->location}app/theme/{$CONFIG->bootstrap}.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <script src="{$CONFIG->location}app/js/jquery.min.js"></script>
	<script src="{$CONFIG->location}app/js/bootstrap.min.js"></script>
    {include file="navbar.tpl"}