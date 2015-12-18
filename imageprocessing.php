<?php
//Author Ahmad Shahwaiz
//www.ahmadshahwaiz.com

include "conn.php";
include('GIFEncoder.class.php'); 
class ImageProcessing{
	public $name;
	public $path;
	public $email;
	public $userName;
	public $userDp;
	public $uid;
	
	// Open Background, wink and Flower Image Images. Hardcode images//////////////////////
	function OpenBackgroundImages(){
		$FirstBackgroundImage 		= 	imagecreatefrompng("images/bgadjust.png");    
		$SecondBackgroundImage 		= 	imagecreatefrompng("images/bgadjust.png"); 
		$FlowerImage 			= 	imagecreatefrompng("images/sendflower.png"); 
		$SmileImage 			= 	imagecreatefrompng("images/smile.png");
		$WinkImage 			= 	imagecreatefrompng("images/wink.png");
	}
	////////////////Giving Alpha Blend to Above Images//////////////////////////////////////
	function GiveAlphaBlend(){
		imagesavealpha($FirstBackgroundImage, true);
		imagealphablending($SecondBackgroundImage, true);
		imagealphablending($FlowerImage, true);
		imagealphablending($SmileImage, true);
		imagealphablending($WinkImage, true);
	}
  /////////////////LeftSideImage Friend DP	///////////////////////////////////////////////////
  function LeftSideImage(){
	  $LeftSideImage 		= 	new Imagick($path);
	  $LeftSideImage 		->	setImageFormat("png");  
	  $LeftSideImage 		->	roundCorners(20,20);
	  $LeftSideImage 		->	resizeImage(160,200,Imagick::FILTER_LANCZOS,1);
	  $LeftSideImage 		->	setBackgroundColor(new ImagickPixel('transparent')); 
	  $LeftSideImage		->	writeImage("LeftSideImage.png");
	  
	  $CreateLeftSideImage	= 	imagecreatefrompng("LeftSideImage.png"); 
  }
  	
 ////////////////////Below Text/////////////////////////////////////////////////////////////////
	 function BelowText(){
	    $belowtextimage  	= 		new Imagick();
		$draw 				= 		new ImagickDraw();
		$pixel 				= 		new ImagickPixel( 'transparent' );
	 		 
		$belowtextimage  	->	newImage(600, 600, $pixel);
		$draw 				->	setFillColor('red'); 
		$draw 				->	setFont('Bookman-DemiItalic');
		$draw 				->	setFontSize( 20 ); 
		$belowtextimage		->	annotateImage($draw, 5,20, 0, "Find out who has a secret crush on you!");
		$belowtextimage		->	setImageFormat('png');  
		$belowtextimage		->	writeImage("belowtext.png");  
	  
		$belowText			= 	imagecreatefrompng("belowtext.png"); 
	 }
 	//////////////////////Above text//////////////////////////////////////////////////////////////////
 
 	function AboveText(){
		    $abovetextimage		= 		new Imagick();
			$draw 				= 		new ImagickDraw();
			$pixel 				= 		new ImagickPixel( 'transparent' );
		 		 
			$abovetextimage 	->		newImage(600, 600, $pixel);
			$draw 				->		setFillColor('black');
	 		$draw 				->		setFont('Bookman-DemiItalic');
			$draw 				->		setFontSize( 20 );
			
			$myfirstName 		= 		explode(" ", $userName);
			$fname 				= 		$myfirstName[0];
			
			$abovetextimage		->		annotateImage($draw, 5,20, 0, "$name has a secret crush on $fname");
			$abovetextimage		->		setImageFormat('png');  
			$abovetextimage		->		writeImage("abovetext.png");  
		  
			$aboveText			= 		imagecreatefrompng("abovetext.png");
 	}	
 	 //////////////////////Right Side Image (User DP- Your Dp)//////////////////////////////////////////////////
	 function RightSideImage(){
		  $RightSideImage		= 	new Imagick($userDp);
		  $RightSideImage 		->	setImageFormat("png");  
		  $RightSideImage  		->	roundCorners(20,20);
		  $RightSideImage 		->	resizeImage(160,200,Imagick::FILTER_LANCZOS,1);
		  $RightSideImage 		->	setBackgroundColor(new ImagickPixel('transparent')); 
		  $RightSideImage		->	writeImage("RightSideImage.png");
		  
		  $CreateRightSideImage	= 	imagecreatefrompng("RightSideImage.png"); 
	}
	  ///////////////////Merging Images to Backgrounds///////////////////////////////////////////////////////////
	  
	 function MergingImages(){
		imagecopy($FirstBackgroundImage, $belowText, 50,240, 0, 0, 500, 200);
		imagecopy($SecondBackgroundImage, $belowText, 50,240, 0, 0, 500, 200);   
		imagecopy($SecondBackgroundImage, $CreateLeftSideImage, 20,30, 0, 0, 160, 200); //Left side photo frame
	
		imagecopy($FirstBackgroundImage, $CreateRightSideImage, 370,30, 0, 0, 160, 200); //Right side photo frame 
		imagecopy($SecondBackgroundImage, $CreateRightSideImage, 370,30, 0, 0, 160, 200); //Right side photo frame 
	
		imagecopy($FirstBackgroundImage, $CreateLeftSideImage, 20,30, 0, 0, 160, 200); //Leftside photo frame
		imagecopy($FirstBackgroundImage, $aboveText, 50,0, 0, 0, 500, 200); //Text Above
		imagecopy($FirstBackgroundImage, $FlowerImage, 200,100, 0, 0, 100, 80); //Flower Image Left
		imagecopy($FirstBackgroundImage, $SmileImage, 160,30, 0, 0, 100, 100); //Smile Image  
		imagecopy($SecondBackgroundImage, $WinkImage, 160,30, 0, 0, 100, 100); //Wink Image  
		imagecopy($SecondBackgroundImage, $FlowerImage, 280,100, 0, 0, 100, 80); //Flower Image Move Right
	
		imagecopy($SecondBackgroundImage, $aboveText, 50,0, 0, 0, 500, 200);
	 }
	
	///////////////Generate GIF from the $image///////////////////////////////////////////////////////////////////
	function GenerateGIFImages(){
		// We want to put the binary GIF data into an array to be used later,
		//  so we use the output buffer.
		ob_start();
		imagegif($FirstBackgroundImage);
		$frames[]		=		ob_get_contents();
		$framed[]		=		80; // Delay in the animation.
		ob_end_clean();
	 
		 
		///////////////Generate GIF from the $image///////////////////////////////////////////////////////////////////
		// We want to put the binary GIF data into an array to be used later,
		//  so we use the output buffer.
		ob_start();
		$merged_image 	= 	"dps/$uid.gif";
		imagegif($SecondBackgroundImage);
	
		$frames[]		=		ob_get_contents();
		$framed[]		=		80; // Delay in the animation.
		ob_end_clean();
	
		///////////Generate the animated gif and save//////////////////////////////////////////////////////////////
		$gif 			= 		new GIFEncoder($frames,$framed,0,2,0,0,0,'bin'); 
		$fp 			= 		fopen($merged_image, 'w');
		fwrite($fp, $gif->GetAnimation());
		fclose($fp);
	}
	 
	////////////////Insert final image in DB/////////////////////////////////////////////////////////////////////////
	function SaveLog(){
		$insert 		=      mysql_query("insert into friendzone (`uid`, `name`, `path`,`email`,`fromName`,`fromPath`) values('".$uid."','".$name ."','".$merged_image."','".$email."','".$userName."','".$userDp."')");
		if($insert) 	
		{
			echo $name."|".$merged_image;
		}
		else
		{
			echo "fail";
		}
	}
	
}

if(isset($_POST["var1"]) && isset($_POST["var2"]) && isset($_POST["var3"]) && isset($_POST["var4"]) && isset($_POST["var5"]))
{
	////////////////Friend & User: Name,Email and DP///////////////////////////////////////
	$name 					= 	mysql_real_escape_string($_POST['var1']);
	$path 					= 	mysql_real_escape_string($_POST['var2']);
	$email 					= 	mysql_real_escape_string($_POST['var3']); 
	$userName 				= 	mysql_real_escape_string($_POST['var4']); 
	$userDp 				= 	mysql_real_escape_string($_POST['var5']); 
	$uid   					=	md5(microtime().rand());
	
	$ImageProcessing 	= 	new imageprocessing;
	$imageProcessing	->	BelowText();
	$imageProcessing	->	AboveText();
	$imageProcessing	->	RightSideImage();
	$imageProcessing	->	MergingImages();
	$imageProcessing	->	GenerateGIFImages();
	$imageProcessing	->	SaveLog();
   
}	 
?>
