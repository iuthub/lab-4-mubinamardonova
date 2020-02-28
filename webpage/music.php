<?php  
$playlist = array();
$is_playlist= FALSE;
if($_REQUEST){
	$playlist = $_REQUEST["playlist"];
	$songs = file("songs/$playlist");
	$is_playlist=TRUE;
}
else{
	$songs = glob("songs/*.mp3");
	$playlist = glob("songs/*.txt");
}
function file_size_converter($bytes){
	$bytes = floatval($bytes);
	$sizes = array(
		0 => array(
			"UNIT"=>"MB",
			"VALUE"=>pow(1024, 2)
		),
		1 => array(
			"UNIT"=>"KB",
			"VALUE"=>pow(1024, 1)
		),
		2 => array(
			"UNIT"=>"B",
			"VALUE"=>pow(1024, 0)
		),
	);
	foreach($sizes as $size) {
		if($bytes >= $size["VALUE"]){
			$result = $bytes/$size["VALUE"];
			$result = str_replace(".", ",", strval(round($result, 2))." ".$size["UNIT"]);
			break;
		}
	}
	return $result;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN""http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Music Viewer</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="viewer.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div id="header">

			<h1>190M Music Playlist Viewer</h1>
			<h2>Search Through Your Playlists and Music</h2>
		</div>


		<div id="listarea">
			<ul id="musiclist">
				<?php
							
					foreach ($songs as $key) { 
						?>
					 	<li class="mp3item">
							<a href="<?= $key ?>" ><?= basename($key) ?></a>
							<?php if (!$is_playlist){ echo "(".file_size_converter(filesize($key)).")"; } ?>
						</li>
					<?php 
				}
						foreach ($playlist as $list) { 
						?>
					 	<li class="playlistitem">
							<a href="music.php?playlist=<?= basename($list) ?>"><?= basename($list) ?></a>
						</li>

					 
					<?php }
					
					 ?>
			</ul>
		</div>
	</body>
</html>
