<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>{$pagetitle|default:"Ultrasonic"}</title>
		<link rel="stylesheet" type="text/css" href="/css/default.css" media="screen" />
	</head>
	<body>
		<div id="upbg"></div>
		<div id="outer">
			<div id="header">
				<div id="headercontent">
					<h1>{$pagetitle|default:"Ultrasonic"}<sup>1.0</sup></h1>
					<h2>Ultra-modern web media streaming</h2>
				</div>
			</div>
			<form method="post" action="">
				<div id="search">
					<input type="text" class="text" maxlength="64" name="keywords" />
					<input type="submit" class="submit" value="Search" />
				</div>
			</form>
			<div id="headerpic"></div>
			<div id="menu">
				<!-- HINT: Set the class of any menu link below to "active" to make it appear active -->
				<ul>
					<li><a href="/index.php">Home</a></li>
					<li><a href="/index.php/admin">Admin</a></li>
{if isset($CurrentLogin)}
					<li><a href="/index.php/user/logout">Logout</a> {$CurrentLogin}</li>
{else}
					<li><a href="/index.php/user/login">Login</a></li>
{/if}
				</ul>
			</div>
			<div id="menubottom"></div>
			<div id="content">
				<!-- Normal content: Stuff that's not going to be put in the left or right column. -->
				<div id="normalcontent">
					<div class="contentarea">
						<!-- Normal content area start -->
						{include file="./tpl/application/flash.tpl"}
						<center>&lt;&lt;&lt; NOW PLAYING &gt;&gt;&gt;</center>
						<!-- Normal content area end -->
					</div>
				</div>

				<div class="divider1"></div>
				<!-- Primary content: Stuff that goes in the primary content column (by default, the left column) -->
				<div id="primarycontainer">
					<div id="primarycontent">
						<!-- Primary content area start -->
						{include file="$ContentBody"}
						<!-- Primary content area end -->
					</div>
				</div>
{if isset($SecondaryContent)}
				<!-- Secondary content: Stuff that goes in the secondary content column (by default, the narrower right column) -->
				<div id="secondarycontent">
					<!-- Secondary content area start -->
					<!-- HINT: Set any div's class to "box" to encapsulate it in (you guessed it) a box -->
					{include file="$SecondaryContent"}
					<!-- Secondary content area end -->
				</div>
{/if}

			</div>

			<div id="footer">
					<div class="left">&copy; 2010 Aaron Ten Clay. All rights reserved.</div>
					<div class="right">Design by <a href="http://www.nodethirtythree.com/">NodeThirtyThree Design</a></div>
			</div>

		</div>

	</body>
</html>