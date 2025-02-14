<?php get_header(); ?>

<?php
// On ouvre "la boucle" (The loop), la structure de contrôle de contenu propre à WordPress:
if (have_posts()): while (have_posts()): the_post(); ?>

    <h2><?= get_the_title(); ?></h2>

    <div><?= get_the_content(); ?></div>

<?php
    // On ferme "la boucle" (The loop)
endwhile;
else: ?>
    <p>La page est vide.</p>
<?php endif; ?>

<?php get_footer(); ?>