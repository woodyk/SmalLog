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
	font-size: 20px;
}

div.posted {
	font-size: 14px;
	background-color: white;
}

a {
	color:white;
}

.p1 {
	font-size: 14px;
	color:white;
	padding: 5px;
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

.card:hover {
	padding: 5px
}

.center {
	margin: auto;
}

textarea {
	left: 10px;
	top: 10px;
	width: calc(100vw - 20px);
	height: calc(30vh - 20px);
	resize: none;
}

</style>

</head>
<title>SmalLog</title>
<body>
<div class="center">
	<div class="titleHeader">
		<a href="slog.php"><?php echo "$title $version"; ?></a>
	</div>
</div>

<div class="p1">
<form name="sbForm" method="POST">
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

<?php

if (isset($_POST['submit']) && isset($_POST['sbText'])) {
	$name  = $_POST['sbName'];
	$text  = $_POST['sbText'];
	$text  = htmlentities($text);
	$name  = htmlentities($name);
	$dtime = strftime('%c');

	if ($text != "") {
		$posted = "<!--NAME: $name | POSTED: $dtime-->\n<div class=\"card center\">\n<div class=\"timeHeader\"><b>$name</b> ($dtime)</div>\n<div class=\"posted\">\n<pre class=\"p2\">\n$text\n</pre>\n</div>\n</div>\n";

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
