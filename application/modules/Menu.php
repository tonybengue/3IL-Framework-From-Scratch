<?php
namespace app\modules;
defined('F3IL') or die('Accès Interdit');

class Menu implements \f3il\Module {
    private static $items = [
        [
            "title" => "Accueil",
            "url" => "/bachelor/TD/Exercice 2/8 - Messenger/"
        ],
        [
            "title" => "Ajouter",
            "url" => "?action=ajouter#"
        ],
    ];

    public function render() {
?>
<div>
    <ul>
        <?php foreach(self::$items as $m): ?>
        <li style="display:inline-block">
            <a href="<?php echo $m['url'];?>">
                <?php echo $m['title']; ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php
       // echo __METHOD__;
    }
}
