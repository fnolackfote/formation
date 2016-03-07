<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 04/03/2016
 * Time: 10:55
 */
?>

<form action="" method="post">
    <p>
        <?= isset($erreurs) && in_array(\Entity\News::AUTEUR_INVALIDE, $erreurs) ? 'L\'auteur est invalide.<br />' : '' ?>
        <label>Auteur</label>
        <input type="text" name="author" value="<?= isset($news) ? $news['author'] : '' ?>" /><br />

        <?= isset($erreurs) && in_array(\Entity\News::TITRE_INVALIDE, $erreurs) ? 'Le titre est invalide.<br />' : '' ?>
        <label>Titre</label><input type="text" name="title" value="<?= isset($news) ? $news['title'] : '' ?>" /><br />

        <?= isset($erreurs) && in_array(\Entity\News::CONTENU_INVALIDE, $erreurs) ? 'Le contenu est invalide.<br />' : '' ?>
        <label>Contenu</label><textarea rows="8" cols="60" name="content"><?= isset($news) ? $news['content'] : '' ?></textarea><br />
        <?php
        if(isset($news) && !$news->isNew())
        {
            ?>
            <input type="hidden" name="id" value="<?= $news['id'] ?>" />
            <input type="submit" value="Modifier" name="modifier" />
            <?php
        }
        else
        {
            ?>
            <input type="submit" value="Ajouter" />
            <?php
        }
        ?>
    </p>
</form>
