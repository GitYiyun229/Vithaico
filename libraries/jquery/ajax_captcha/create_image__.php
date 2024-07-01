<?php
/*
	This is PHP file that generates CAPTCHA image for the How to Create CAPTCHA Protection using PHP and AJAX Tutorial

	You may use this code in your own projects as long as this 
	copyright is left in place.  All code is provided AS-IS.
	This code is distributed in the hope that it will be useful,
 	but WITHOUT ANY WARRANTY; without even the implied warranty of
 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
	
	For the rest of the code visit http://www.WebCheatSheet.com
	
	Copyright 2006 WebCheatSheet.com	

*/

//Start the session so we can store what the security code actually is
session_start();

//Send a generated image to the browser 
create_image(); 
exit(); 

function create_image() 
{ 
    //Let's generate a totally random string using md5 
    $md5 = md5(microtime() * time());
    $string = substr($md5, 0, 4);
    $image = imagecreatefromjpeg("images/1.jpg");
    //Set the session to store the security code
    $_SESSION["security_code"] = $string;

	//Allocate a color for an image
	//black
	$black = imagecolorallocate($image, 0, 0, 0);
	//random dark colors
	$line = imagecolorallocate($image, rand(0,70), rand(0, 70), rand(0, 70));
	$line2 = imagecolorallocate($image, rand(0,70), rand(0, 70), rand(0, 70));
	
	//draw askew random lines
//	imagesetthickness($image, rand(1, 3));
//	imageline($image, 10, 1, rand(30,200), rand(25,58), $line2);
//	imagesetthickness($image, rand(1, 3));
//	imageline($image, 1, 60, rand(40, 200), rand(10, 60), $line);
//	imagesetthickness($image, rand(1, 3));
//	imageline($image, 5 ,8 , rand(120, 200), rand(20, 60),$line2);
//	imagesetthickness($image, rand(1, 3));
//	imageline($image, rand(6, 60), rand(40, 60), rand(20, 200) , rand(15, 60), $line);
	
	//set random pixels with random color
	for ($i = 0; $i <= 256; $i++)
	{
		$point_color = imagecolorallocate ($image, rand(0,255), rand(0,255), rand(0,255));
		imagesetpixel($image, rand(6,200), rand(2,58), $point_color);
	}
	
	//Write text to the image using TrueType fonts
	$y1 = rand(25, 50);
	ImageTTFText ($image, rand(17, 20), rand(-30, 30), rand(10, 20), $y1, $black, 'verdana.ttf', substr($string,  0, 1));
	$y2 = rand(25, 50);
	ImageTTFText ($image, rand(17, 20), rand(0, 30), rand(45, 55), $y2, $line2,'trebuc.ttf', substr($string,  1, 1));
	$y3 = rand(25, 50);
	ImageTTFText ($image, rand(17, 25), rand(-20, 0), rand(80, 90), $y3, $black,'trebuc.ttf', substr($string,  2, 1));
	$y4 = rand(25, 50);
	ImageTTFText ($image, rand(16, 25), rand(0, 30), rand(115, 125), $y4, $black, 'verdana.ttf', substr($string,  3, 1));
	$x = rand(0, 50);
	$y = rand(0, 50);
	
	$_SESSION['key'] = md5($string);
	
	header("Content-type: image/jpeg");
	imagejpeg($image); 
	    
    //Free up resources
    ImageDestroy($image); 
} 
?>