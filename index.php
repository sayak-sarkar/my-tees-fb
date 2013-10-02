<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>My Teees</title>
			<script type="text/javascript" src="js/jquery.js"></script>
			<script type="text/javascript" src="js/thickbox.js"></script>
			<link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" />
			<link href="css/style.css" rel="stylesheet" type="text/css" />
		</head>

		<body bgcolor="#FFFFFF"> 
			<div id="wrapper">
				<h1 style="text-align: center; font-family: sans-serif; margin-bottom: 10px;">It's My Puja Too</h1>
				<p style="margin-bottom: 20px;" width="98%">
					Here goes some text on the event.Here goes some text on the event.Here goes some text on the event.
					Here goes some text on the event.Here goes some text on the event.Here goes some text on the event.</p>
				<div id="galleryArea" style="float: left; width: 650px;">
					<h2 style="text-align: center; font-family: sans-serif; font-size: 22px;">Images shared by people like you</h2>
					<?php
						$dbhost 								= "localhost";
						$dbuser									= "root";
						$dbpass									= "sayak12";
						$dbname									= "gallery";

						// Create connection
						$conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

						// Check connection
						if (mysqli_connect_errno($con))
						{
							echo "Failed to connect to MySQL: " . mysqli_connect_error();
						}

						/*$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Error connecting to database");
						mysql_select_db($dbname) or die ("Error selecting the database");*/

						function cleanString($caption="")
						{
							$removeunderscore = str_replace("_"," ",$caption);
							$removedash = str_replace("-"," ",$removeunderscore);
							$removedimensions = str_replace("1366x768","",$removedash);
							$cleanstring = str_replace(".jpg","",$removedimensions);	
							return $cleanstring;
						}
						$sql = "SELECT  * FROM photos ORDER BY id ASC";
						$query = mysqli_query($conn, $sql);
						while($row = mysqli_fetch_array($query))
						{
							$file = $row['photo_name'];
							echo '<div id="container">
						  			<div id="thumbnail">
						  				<a href="uploads/'. $file .'"  title="'.cleanString($file).'" class="thickbox">
						  					<img src="thumbnails/thumb_'.$row['id'].'.jpeg" width="200" height="200" alt="image" />
						  				</a>
						  			</div>
								  </div>';
						}
					?>
					<div class="clear"></div>
				</div>
				<div id="uploadForm" style="float: left; width: 300px;">
					<h2 style="text-align: center; font-family: sans-serif; font-size: 22px;">Share your photograph</h2>
					<?php
						//error_reporting(0);
						if(isset($_POST['submit']))
						{
							$target = "/var/www/html/simple-php-photo-gallery/uploads/"; 
							$allowedExts = array("jpg", "jpeg");
							$extension = end(explode(".", $_FILES["file_upload"]["name"]));
							$target = $target . basename( $_FILES['file_upload']['name']);
							$comment =  mysqli_real_escape_string($_POST['comment']);
							$date = date("Y-m-d H:i:s");

							//Function to generate image thumbnails
							function make_thumb($src, $dest, $desired_width) {

								/* read the source image */
								$source_image = imagecreatefromjpeg($src);
								$width = imagesx($source_image);
								$height = imagesy($source_image);
							
								/* find the "desired height" of this thumbnail, relative to the desired width  */
								$desired_height = floor($height * ($desired_width / $width));
							
								/* create a new, "virtual" image */
								$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
							
								/* copy source image at a resized size */
								imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
							
								/* create the physical thumbnail image to its destination with 100% quality*/
								imagejpeg($virtual_image, $dest,100);
							}

							//create a mysql connection
							$dbhost							= "localhost";
							$dbuser							= "root";
							$dbpass							= "sayak12";
							$dbname							= "gallery";

							// Create connection
							$conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

							// Check connection
							if (mysqli_connect_errno($con))
							{
								echo "Failed to connect to MySQL: " . mysqli_connect_error();
							}

							//check for allowed extensions
							if ((($_FILES["file_upload"]["type"] == "image/jpg")|| ($_FILES["file_upload"]["type"] == "image/jpeg"))&& in_array($extension, $allowedExts))
							{
								$photoname = $_FILES["file_upload"]["name"];
								if (file_exists("../uploads/" . $photoname))
								{
									die( '<div class="error">Sorry <b>'. $photoname . '</b> already exists</div>');
								}
							
								if(move_uploaded_file($_FILES['file_upload']['tmp_name'], $target.$photoname)) 
								{
									$sqlquery = "INSERT INTO photos (photo_name,comment,date_added) VALUES ('$photoname','$comment','$date')";
									$query = mysqli_query($conn, $sqlquery); 
									$sql = "SELECT MAX(id) FROM photos";
									$max = mysqli_query($conn, $sql);
									$row = mysqli_fetch_array($max);
									$maxId = $row['MAX(id)'];
								
									$type = $_FILES["file_upload"]["type"];
									switch($type)
									{
										case "image/jpeg":
										$ext = ".jpeg";
										break;
										case "image/jpg";
										$ext = ".jpg";
										break;			
									}
								
								    //define arguments for the make_thumb function
									$source = "../uploads/".$photoname;
									$destination = "../thumbnails/thumb_". $maxId . $ext ."";			
									//specify your desired width for your thumbnails
									$width = "282";
									//Finally call the make_thumb function
									make_thumb($source,$destination,$width);
								
									$msg = '<div class="success">
												<b>Upload: </b>' . basename($photoname) . '<br />
						    					<b>Type: </b>' . $_FILES["file_upload"]["type"] . '<br />
						    					<b>Size: </b>' . ceil(($_FILES["file_upload"]["size"] / 1024)) . 'Kb<br />
									  		</div>';
								}	 
								else
								{
									//$msg = $_FILES['file_upload']['error'];
									$msg = '<div class="error">Sorry, there was a problem uploading your file.</div>';
								}
							}
							else
							{
								$msg = '<div class="error">The file type you are trying to upload is not allowed!</div>';
							}
						}
					?>
					<div id="upload">
						<form action="" method="post" enctype="multipart/form-data">
							<div id="fileSelect">
								Click Here To Upload Your Photo
								<input type="file" name="file_upload" id="upload_file"/>
							</div>
							<br/>
							<div id="commentLabel">Add a Comment</div>
							<textarea id="commentBox" name="comment"></textarea>
							<input type="submit" name="submit" value="Submit" id="submit"/>
						</form>
						<?php echo $msg; ?>
					</div>
				</div>
			</div>
		</body>
</html>