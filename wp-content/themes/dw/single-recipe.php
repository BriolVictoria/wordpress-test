<?php get_header(); ?>

    <style type="text/css">
        .recipe {
            display: flex;
            flex-direction: row-reverse;
            justify-content: space-between;
        }

        .recipe_ingredients {
            width: 320px;
            padding: 20px;
            background-color: #f1f1f1;
        }
    </style>

<?php
// On ouvre "la boucle" (The loop), la structure de contrôle de contenu propre à WordPress:
if (have_posts()): while (have_posts()): the_post(); ?>

    <h2><?= get_the_title(); ?></h2>

    <div class="recipe">


    <aside class="recipe_ingredients">

        <h3>Ingrédients</h3>
        <p>À compléter</p>

    </aside>
    <section class="recipe_step">

        <h3>Etapes</h3>
        <div><?= get_the_content(); ?></div>

    </section>

    </div>


<?php
    // On ferme "la boucle" (The loop)
endwhile;
else: ?>
    <p>Cette recette n'éxiste pas.</p>
<?php endif; ?>

<?php get_footer(); ?>