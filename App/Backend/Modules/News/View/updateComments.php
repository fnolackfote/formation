<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 04/03/2016
 * Time: 11:06
 */
?>

<form action="" method="post">
    <p>
        <?= isset($erreurs) && in_array(\Entity\Comment::AUTEUR_INVALIDE, $erreurs) ? 'L\'auteur est invalide.<br />' : '' ?>
        <label>Pseudo</label><input type="text" name="pseudo" value="<?= htmlspecialchars($comment['author']) ?>" /><br />

        <?= isset($erreurs) && in_array(\Entity\Comment::CONTENU_INVALIDE, $erreurs) ? 'Le contenu est invalide.<br />' : '' ?>
        <label>Contenu</label><textarea name="contenu" rows="7" cols="50"><?= htmlspecialchars($comment['content']) ?></textarea><br />

        <input type="hidden" name="news" value="<?= $comment['news'] ?>" />
        <input type="submit" value="Modifier" />
    </p>
</form>