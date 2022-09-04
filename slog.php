<html>
<!--
Name: SmalLog
Author: Woody K.
-->
<?php

$version = "v0.1";
$title = "SmalLog";
$slog = './slog.html';

?>

<head>
<script type="text/javascript">
function showHide() {
	var x = document.getElementById("sbForm");
	if (x.style.display === "none") {
		x.style.display = "block";
	} else {
		x.style.display = "none";
	}
}
</script>

<style type="text/css">
html {
	font-family: "Lucida Console", "Courier New", monospace;
}

body {
	background-color: #090909;
}

div.timeHeader {
	background-color: #3d3d3d;
	color: white;
}

div.titleHeader {
	background-color: #660000;
	color: white;
	font-size: 16px;
}

div.sticky {
	position: -webkit-sticky;
	position: sticky;
	top: 0;
}

div.posted {
	font-size: 14px;
	background-color: white;
}

a {
	color:white;
}

.p1 {
	border-style: solid;
	border-width: 1px;
	border-color: white;
	border-radius: 5px;
	font-size: 14px;
	color:white;
	background-color: rgb(0, 0, 0, 0.8);
	padding: 10px;
}
.p2 {
	font-size: 14px;
	color:black;
	white-space: pre-wrap;       /* Since CSS 2.1 */
	white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
	white-space: -pre-wrap;      /* Opera 4-6 */
	white-space: -o-pre-wrap;    /* Opera 7 */
	word-wrap: break-word;       /* Internet Explorer 5.5+ */
}

.card {
	width: 100%;
}

/*
.card:hover {
	padding: 5px
}
*/

.center {
	margin: auto;
}

textarea {
	margin: auto;
	width: calc(100vw - 40px);
	height: calc(20vh - 20px);
	resize: none;
}

</style>

</head>
<title>SmalLog</title>
<body>
<div class="sticky">
<div class="p1 center">
	<div class="titleHeader" onclick="showHide()">
		<a href="slog.php"><?php echo "$title $version"; ?></a>
	</div>
<form id="sbForm" name="sbForm" method="POST">
	<p>
		<b>Title:</b> <input type="text" size="25" name="sbName">
		</br>
		<textarea id="sbText" name="sbText" rows="10" cols="100" placeholder="Your log entry here."></textarea>
		</br>	
		<input type="submit" name="submit" value="post">
		<input type="submit" name="clear" value="clear" onclick="return confirm('Are you sure?')">
	</p>
</form>
</div>
</div>
</br>

<?php

if (isset($_POST['submit']) && isset($_POST['sbText'])) {
	$name  = $_POST['sbName'];
	$text  = $_POST['sbText'];
	$text  = htmlentities($text);
	$name  = htmlentities($name);
	$dtime = strftime('%c');

	if ($text != "") {
		$posted = "<!--NAME: $name | POSTED: $dtime-->\n<div class=\"card center\">\n<div class=\"timeHeader\"><b>#$name</b> ($dtime)</div>\n<div class=\"posted\">\n<pre class=\"p2\">\n$text\n</pre>\n</div>\n</div>\n";

		if (file_exists($slog)) {
			$handle = fopen($slog, "r");
			$content = fread($handle, filesize($slog));
			fclose($handle);
		}

		$handle = fopen($slog, "w");
		fwrite($handle, $posted);
		fwrite($handle, $content);
		fclose($handle);
	}
} elseif (isset($_POST['clear'])) {
	unlink($slog);
}


if (file_exists($slog)) {
	include($slog);
}

?>
</body>
</html>
