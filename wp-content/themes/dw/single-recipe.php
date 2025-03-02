<?php get_header(); ?>

    <style type="text/css">
        .sro {
            position: absolute;
            overflow: hidden;
            clip: rect(0 0 0 0);
            height: 1px;
            width: 1px;
            margin: -1px;
            padding: 0;
            border: 0;
        }


        .recipe_header {
            height: 400px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .recipe_back,
        .recipe_back:before,
        .recipe_head {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
        }

        .recipe_back {
            Z-index: 0;
            margin: 0;
            padding: 0;
        }

        .recipe_back:before {
            content: '';
            display: block;
            background: rgb(161, 196, 251);
            opacity: 0.75;
        }

        .recipe_cover {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .recipe_head {
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .recipe_container {
            display: flex;
            flex-direction: row-reverse;
            justify-content: space-between;
        }

        .recipe_ingredients {
            width: 320px;
            padding: 20px;
            background-color: #f1f1f1;
            display: flex;
            flex-direction: column-reverse;
        }

        .recipe_fig {
            display: block;
            position: relative;
            width: 100%;
            height: 0;
            padding-top: 100%;
            margin: 0;
        }

        img {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .recipe_rating {
            width:150px;
            height: 30px;
            display: block;
            position: relative;
            background: url("/wp-content/themes/dw/ressources/img/start_empty.svg");
            background-repeat: repeat-x;
            background-position: 0 0;
        }

        .recipe_rating:after {
            content: '';
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 0;
            background: url("/wp-content/themes/dw/ressources/img/star_fill.svg");
            background-repeat: repeat-x;
            background-position: 0 0;
        }

        .recipe_rating[data-score="1"]:after {
            width: 30px;
        }
        .recipe_rating[data-score="2"]:after {
            width: 60px;
        }
        .recipe_rating[data-score="3"]:after {
            width: 90px;
        }
        .recipe_rating[data-score="4"]:after {
            width: 120px;
        }
        .recipe_rating[data-score="5"]:after {
            width: 100%;
        }

    </style>

<?php
// On ouvre "la boucle" (The loop), la structure de contrôle de contenu propre à WordPress:
if (have_posts()): while (have_posts()): the_post(); ?>

    <div class="recipe">
        <header class="recipe_header">
            <div class="recipe_head">
                <h2 class="recipe_title"><?= get_the_title(); ?></h2>
                <p class="recipe_excerpt"><?= get_the_excerpt(); ?></p>
                <div class="recipe_rating" data-score="<?= $rating= get_field('rating')?>">
                    <p class="sro">Cette recette obtient l'appréciation de <?= $rating?> étoiles sur 5</p>
            </div>
                <figure class="recipe_back">
                    <?= get_the_post_thumbnail(size: 'recipe-header', attr: ['class' => 'recipe_cover']); ?>
                </figure>
        </header>

        <div class="recipe_container">


            <aside class="recipe_ingredients">

                <div>
                    <h3>Ingrédients</h3>
                    <div class="wyswig">
                        <?= get_field('ingredients') ?>
                    </div>
                </div>
                <figure class="recipe_fig">
                    <?= wp_get_attachment_image(get_field('side_image'), 'recipe_side') ?>
                </figure>

            </aside>

            <section class="recipe_step">

                <h3>Etapes de la recettes</h3>
                <div><?= get_field('steps') ?></div>

            </section>
        </div>
    </div>



<?php
    // On ferme "la boucle" (The loop)
endwhile;
else: ?>
    <p>Cette recette n'éxiste pas.</p>
<?php endif; ?>

<?php get_footer(); ?>