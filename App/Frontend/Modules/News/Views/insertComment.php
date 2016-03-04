<?php
/**
 * Created by PhpStorm.
 * User: fnolackfote
 * Date: 03/03/2016
 * Time: 16:46
 */
?>

<h2>Ajouter un commentaire</h2>
<form action="" method="post">
    <p>
        <?= isset($erreurs) && inarray(\Entity\Comment::AUTEUR_INVALIDE, $erreurs) ? 'L\'auteur est invalide.<br />' : ''; ?>
        <label>Pseudo</label>
        <input type="text" name="pseudo" value="<?= isset($comment) ? htmlspecialchars($comment['author']) : '' ?>" /><br />
        <?= isset($erreur) && in_array(\Entity\Comment::CONTENU_INVALIDE, $erreurs) ? 'Le contenu est invalide.<br />' : '' ?>
        <label>Contenu</label>
        <textarea name="content" rows="7" cols="50"><?= isset($comment) ? htmlspecialchars($comment['contenu']) : '' ?></textarea> <br />

        <input type="submit" value="Commenter" />
    </p>
</form>
