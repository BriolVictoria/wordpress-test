<?php /* Template Name: Page Contact */ ?>

<?php get_header(); ?>

    <aside>
        <h2>Contactez-moi</h2>
    </aside>
<?php
// On ouvre "la boucle" (The loop), la structure de contrôle de contenu propre à WordPress:
if(have_posts()): while (have_posts()): the_post(); ?>

    <div><?= get_the_content(); ?></div>

<?php
    // On ferme "la boucle" (The loop)
endwhile; else: ?>
    <p>La page est vide.</p>
<?php endif; ?>

<?php get_footer(); ?>