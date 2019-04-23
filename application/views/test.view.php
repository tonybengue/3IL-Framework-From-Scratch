<h2>Vue de test</h2>
<?php defined('F3IL') or die('Accès Interdit'); ?>

<!-- <?php// echo __FILE__; ?>
<p>Depuis la view : <?php //echo $this->groupe; ?></p> -->

<?php
    $message = \f3il\Messenger::getMessage();
    if ($message !== false):
?>
    <p><?php echo $message; ?></p>
<?php
    endif;
?>

<?php //foreach($this->materiels as $m): ?>
    <?php //echo 'Id '.$m['id'].' - '.$m['description'].' '.$m['ip']; ?></li>
    <?php //endforeach; ?>
    <?php foreach($this->materiels as $m): ?>
        <li><?php echo
            filter_var($m['description'], FILTER_SANITIZE_SPECIAL_CHARS).
            ' '.
            filter_var($m['ip'], FILTER_SANITIZE_SPECIAL_CHARS); ?>
            <a href="?controller=materiels&action=modifier&id=<?php echo $m['id']; ?>">
                Modifier
            </a>
            <a href="?controller=materiels&action=supprimer&id=<?php echo $m['id']; ?>">
                Supprimer
            </a>
    <?php endforeach; ?>
