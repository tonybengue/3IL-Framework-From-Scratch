<h2>Ajouter un élément</h2>
<?php defined('F3IL') or die('Accès Interdit'); ?>

<?php if(isset($this->_formMessage)): ?>
<p><?php echo $this->_formMessage; ?></p>
<?php endif; ?>

<form action="#" method="POST">
    <div class="form-group">
        <label for="description">Description</label>
        <input class="form-control" id="description" name="description" type="text" placeholder="Description de l'équipement"
        value="<?= filter_var($this->description, FILTER_SANITIZE_SPECIAL_CHARS); ?>">
        <small id="emailHelp" class="form-text text-muted">Nous ne partagerons pas votre e-mail.</small>
    </div>

    <div class="form-group">
        <label for="ip">Adresse IP</label>
        <input class="form-control" id="ip" name="ip" type="text" placeholder="Adresse IP"
        value="<?= filter_var($this->ip, FILTER_SANITIZE_SPECIAL_CHARS); ?>">
    </div>

    <button submit="submit" class="btn btn-primary">Envoyer</button>
    <?php \f3il\Helpers\CsrfHelper::csrf(); ?>
</form>
<a href="?controller=materiels&action=lister">Retour</a>
