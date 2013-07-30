<?php

if(isset($_GET['request']) && isset($_GET['type']) && isset($_GET['format']))
{
 $query=substr($_GET['type'], 0, 1).'='.substr($_GET['format'], 0, 4).'_'.urlencode($_GET['request']);
 header("Location: ./?$query");
}
else
{
?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
 <meta charset="utf-8">
 <title>twitterbridge-noapi</title>
<style type="text/css">
body {font-family:monospace;padding:1em;color:#444}
form {border:1px solid #aaa;float:left;padding:1em;}
</style>
</head>
<body>
<h1>twitterbridge-noapi launcher</h1>
<form name="input" action="launcher.php" method="get">

<input type="text" name="request" placeholder="username or keyword"><br><br>
request type:<br>
<input type="radio" name="type" value="u">username (timeline)<br>
<input type="radio" name="type" value="q">keywords (search)<br><br>
output format:<br>
<input type="radio" name="format" value="text">plaintext<br>
<input type="radio" name="format" value="json">JSON<br>
<input type="radio" name="format" value="atom">ATOM<br><br>

<input type="submit" value="Redirect me!">
</form>


</body>
</html>

<?php
}
?>
