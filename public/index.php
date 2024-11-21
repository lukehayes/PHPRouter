<?php

require '../vendor/autoload.php';

$r = new LDH\Router();

$r->addRoute('GET', '/', fn() => dump("/ Route") );
$r->addRoute('GET', '/hello', fn() => dump("/hello Route") );

$r->run();
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hello</title>
</head>
<body>


<a href="/">Home</a>
<a href="/hello">Hello</a>

</body>
</html>


<?php

