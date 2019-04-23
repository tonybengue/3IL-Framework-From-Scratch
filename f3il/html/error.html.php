<?php defined("F3IL") or die('Acèes Interdit'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error</title>
</head>
<body>
<h1>Error</h1>
<p><?php echo $this->message; ?></p>
<dl>
    <dt>File : </dt>
    <dd><?php echo $file; ?></dd>
    <dt>Line : </dt>
    <dd><?php echo $line; ?></dd>
    <dt>Function : </dt>
    <dd><?php echo $function; ?></dd>
</dl>
<pre>
    <?php echo $this->getTraceAsString(); ?>
</pre>
</body>
</html>
