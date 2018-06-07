<?php
include "include/auth.php";
session_start();

if (htmlspecialchars($_POST['submit']) == "logout")
{
	session_destroy();
	header("Location:index.php");
}
if (htmlspecialchars($_POST['submit']) == "regme")
	$_SESSION['rereq'] = "register";
if (htmlspecialchars($_POST['submit']) == "logme")
	$_SESSION['rereq'] = "";

print_r($_SESSION);
?>
<!DOCTYPE html>


<html>
<head>
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/slideshow.css">
	<meta charset="utf-8">
	<link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" type="text/css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<header>
	<?php include "header.php"; ?>
</header>
<body>
	<div class="container">
		
		<h1 style="text-align: center">Take a Snap:</h1>
		<div class="photos">
				<video style="display: inline-block;" id=video width="400" height="300"></video>
				<canvas style="display: inline-block;" id="canvas" width="400" height="300" onclick="can();"></canvas></br>
				<div class="snapsave">
					<button id="snap" name="pic">Snap</button>
					<button id="save" name="spic">Save</button>
					<input type="file" accept="image/*;" name="files" >
					<input type="radio" name="filtre" id="volvo" value="volvo" />
						<label><img src="Res/volvo.png" alt="Volvo" width="50" height="20" /></label>
					<input type="radio" name="filtre" id="bitcoin" value="btc"/>
						<label><img src="Res/btc.png" alt="Bitcoin" width="25" height="25" /></label>
					<input type="radio" name="filtre" id="ethereum" value="eth"/>
						<label><img src="Res/eth.png" alt="Ethreum" width="25" height="25" /></label>
				</div>
		</div>

		<div class="gallerie">
			<?php include "slideshow.php";?>
		</div>
	</div>
		<script type="text/javascript">
		var video = document.getElementById('video');
		var canvas = document.getElementById('canvas');
		var context = canvas.getContext('2d');
		var cfile = document.getElementById('file');
		var filtre = new Image();
		
		canvas.onclick = function can(event) {
			var volvo = document.getElementById("volvo");
			var btc = document.getElementById("bitcoin");
			var eth = document.getElementById("ethereum");
			var source = "";
			if (volvo.checked == true)
				source = "Res/volvo.png";
			if (btc.checked == true)
				source = "Res/btc.png";
			if (eth.checked == true)
				source = "Res/eth.png";
			if (source != "")
			{
				filtre.src = source;
				context.drawImage(filtre, event.pageX - canvas.offsetLeft - 35, event.pageY - canvas.offsetTop - 170, 50, 50);
			}

		}

		document.getElementById("snap").addEventListener("click", function() {
			context.drawImage(video, 0, 0, 400, 300);
		});

		document.getElementById("save").addEventListener("click", function() {
				var post = new XMLHttpRequest();
				post.open("POST", "save.php");
				post.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				post.setRequestHeader("Access-Control-Allow-Origin", "http://cama-gru.pe.hu");

				post.send("user=" + "<?php echo $_SESSION['logged_in'];?>" + "&snap=" + canvas.toDataURL());
				post.onreadystatechange = function(event) {
					if (this.readyState == XMLHttpRequest.DONE) {
						console.log(post.responseText);
						console.log("Saved");
						var response = post.responseText;
						alert("Saved");
						location.reload();
					}
				}
		});

		if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
			navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
				video.src = window.URL.createObjectURL(stream);
				video.play();
			});
		}
	</script>
</body>
<footer> Contact me at nocontact@nowhere.x</footer>
</html>