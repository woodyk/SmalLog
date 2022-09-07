<html>

<?php
// configure me
$scriptSelf = $_SERVER['SCRIPT_NAME'];
$version = "v0.1";
$title = "SmalLog"; // Title to display on the top of the page
$slog = './slog.html'; // Location for writing log entries
?>

<head>

<!-- Syntax Highlighting -->
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/styles/default.min.css">-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/highlight.min.js"></script>

<script type="text/javascript">
// Init syntax highlighting
hljs.highlightAll();

// hide / show sbForm
function showHide(id) {
	var x = document.getElementById(id);
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
	background-color: white;
	color: black;
	border-radius: 5px;
}

div.titleHeader {
	background-color: #660000;
	color: black ;
	font-size: 16px;
	border-radius: 5px;
	padding: 5px
}

div.sticky {
	position: -webkit-sticky;
	position: sticky;
	top: 0;
}

a {
	color:white;
}

.p1 {
	border-style: solid;
	border-width: 1px;
	border-color: white;
	border-radius: 10px;
	font-size: 14px;
	color:white;
	background-color: rgb(0, 0, 0, 0.8);
	padding: 10px;
}
.p2 {
	font-size: 14px;
	color:black;
	background-color: #272822
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
	background-color: #282c34;
	color: white;
	margin: auto;
	width: calc(100vw - 40px);
	height: calc(20vh - 20px);
	resize: none;
	border-radius: 10px;
	border: none;
	border-style: none;
	padding: 10px;
}

input:focus, textarea:focus, select:focus {
	outline: none;
}

.input-text {
	border-radius: 5px;
	color: black;
	margin: auto;
	font-family: "Lucida Console", "Courier New", monospace;
	width: calc(100vw - 40px);
	height: calc(5vh - 20px);
	font-weight: bold;
	padding: 10px;
}

.submit-button {
	background: #282c34;
	color: white;
	height: 30px;
	width: 80px;
	border-style: none;
	border-radius: 5px;
}

/* highlight.js css theme block */
/* Themes https://highlightjs.org/static/demo/ */
pre code.hljs{border-radius:10px;display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{color:#abb2bf;background:#282c34}.hljs-keyword,.hljs-operator,.hljs-pattern-match{color:#f92672}.hljs-function,.hljs-pattern-match .hljs-constructor{color:#61aeee}.hljs-function .hljs-params{color:#a6e22e}.hljs-function .hljs-params .hljs-typing{color:#fd971f}.hljs-module-access .hljs-module{color:#7e57c2}.hljs-constructor{color:#e2b93d}.hljs-constructor .hljs-string{color:#9ccc65}.hljs-comment,.hljs-quote{color:#b18eb1;font-style:italic}.hljs-doctag,.hljs-formula{color:#c678dd}.hljs-deletion,.hljs-name,.hljs-section,.hljs-selector-tag,.hljs-subst{color:#e06c75}.hljs-literal{color:#56b6c2}.hljs-addition,.hljs-attribute,.hljs-meta .hljs-string,.hljs-regexp,.hljs-string{color:#98c379}.hljs-built_in,.hljs-class .hljs-title,.hljs-title.class_{color:#e6c07b}.hljs-attr,.hljs-number,.hljs-selector-attr,.hljs-selector-class,.hljs-selector-pseudo,.hljs-template-variable,.hljs-type,.hljs-variable{color:#d19a66}.hljs-bullet,.hljs-link,.hljs-meta,.hljs-selector-id,.hljs-symbol,.hljs-title{color:#61aeee}.hljs-emphasis{font-style:italic}.hljs-strong{font-weight:700}.hljs-link{text-decoration:underline}

</style>

</head>
<title>SmalLog</title>
<body>
<div class="p1 center sticky">
	<div class="titleHeader" onclick="showHide('sbForm')">
		<a href="<?php $scriptSelf ?>"><?php echo "$title $version"; ?></a>
	</div>
<div id="sbForm">	
<form name="sbForm" method="POST">
	<p>
		<input class="input-text" type="text" size="50" name="sbName" placeholder=" log title">
		</br>
		</br>
		<textarea id="sbText" name="sbText" rows="10" cols="100" maxlength="1000000" placeholder=" Your log entry here."></textarea>
		</br>
		</br>
		<input type="submit" class="submit-button" name="submit" value="log">
		<input type="reset" class="submit-button" name="reset" value="clear form">
		<input type="submit" class="submit-button" name="clear" value="clear data" onclick="return confirm('Erase all log data?')">
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
		$posted = "<!--NAME: $name | POSTED: $dtime-->\n<div class=\"card center\">\n\t<div class=\"timeHeader\"><b>&nbsp;#&nbsp;$name</b> ($dtime)</div>\n\t<div>\n\t\t<pre class=\"p2\"><code>$text</code></pre>\n\t</div>\n</div>\n";

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
