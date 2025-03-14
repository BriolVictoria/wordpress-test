<?php
get_header(); ?>
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

        .recipe_fig {
            display: block;
            position: relative;
            width: 100%;
            height: 0;
            padding-top: 100%;
            margin: 0;
        }

        .recipe_img {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .recipe__rating {
            width: 150px;
            height: 30px;
            display: block;
            position: relative;
            background: url(/wp-content/themes/dw/ressources/img/cake_empty.svg);
            background-repeat: repeat-x;
            background-position: 0 0;
        }

        .recipe__rating:after {
            content: '';
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 0;
            background: url(/wp-content/themes/dw/ressources/img/cake.svg);
            background-repeat: repeat-x;
            background-position: 0 0;
        }

        .recipe__rating[data-score="1"]:after {
            width: 30px;
        }

        .recipe__rating[data-score="2"]:after {
            width: 60px;
        }

        .recipe__rating[data-score="3"]:after {
            width: 90px;
        }

        .recipe__rating[data-score="4"]:after {
            width: 120px;
        }

        .recipe__rating[data-score="5"]:after {
            width: 100%;
        }

        .recipe_fig {
            display: block;
            position: relative;
            width: 100%;
            height: 0;
            padding-top: 100%;
            margin: 0;
        }

        .recipe__head {
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .recipe__container {
            display: flex;
            flex-direction: row;
        }

        .recipe__ingredients {
            width: 320px;
            padding: 20px;
            margin-right: 3em;
            background: #f4c152;
            display: flex;
            flex-direction: column-reverse;
        }
        .recipe__header {
            height: 400px;
            width: 100%;
            position: relative;
            margin-bottom: 3em;
        }
        .recipe__back,
        .recipe__back:before,
        .recipe__head {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
        }
        .recipe__back {
            z-index: 0;
            margin: 0;
            padding: 0;
        }
        .recipe__back:before {
            content: '';
            display: block;
            background: rgba(244, 82, 139, 0.6);
            opacity: 0.75;
        }
        .recipe__travel{
            color: white;
            font-size: 18px;
        }
        .recipe__cover {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
    <!-- // on ouvre la boucle
     // structure de controle de contenu pour wordpress-->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <header class="recipe__header">
        <div class="recipe__head">
            <h2 class="recipe__title"><?= get_the_title(); ?></h2>
            <p class="recipe__excerpt"><?= get_the_excerpt(); ?></p>
        </div>
        <div class="recipe__back">
            <?= get_the_post_thumbnail(size: 'travel-header', attr: ['class' => 'recipe__cover']); ?>
        </div>
    </header>
    <div class="recipe__container">
        <aside class="recipe__ingredients">
            <div>
                <h3>Ingrédients</h3>
                <p><?= get_field('ingredients') ?></p>
            </div>
            <figure class="recipe_fig">
                <?= get_the_post_thumbnail(size: 'large', attr: ['class' => 'recipe_img']) ?>
            </figure>
        </aside>

        <section class="recipe_steps">
            <h3>Etapes</h3>
            <div><?= get_the_content(); ?></div>
        </section>
    </div>
    <!--on ferme la boucle-->
<?php endwhile; else: ?>
    <p>Cette recette n'existe pas</p>
<?php endif; ?>
<?php get_footer(); ?>