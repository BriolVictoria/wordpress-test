<?php get_header(); ?>

<div>
    <h1>
        Page non trouvé
    </h1>
    <p>
        Désolé la page que vous recherchez n'existe pas ou a été déplacée.
    </p>
    <p>
        Retour à la <a href="<?= home_url() ?>" title="retour a la page d'accueil"> page d'accueil</a> ou utilisez la ..
    </p>

    <?= get_search_form() ?>
</div>

<?php get_footer(); ?>
