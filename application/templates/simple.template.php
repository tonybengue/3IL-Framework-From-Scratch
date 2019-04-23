<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simple Template</title>
</head>
<body>
    <h1>Simple Template</h1>
    <?php //echo __FILE__; ?>
   <!-- <p>Depuis le template : <?php //echo $this->groupe; ?></p> -->
    
    <?php f3il\Page::insertModule('Menu'); ?>
    <?php $this->insertView(); ?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</body>
</html>