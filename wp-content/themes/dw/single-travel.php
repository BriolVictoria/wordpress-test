<?php get_header(); ?>

    <style type="text/css">
        .travel {
            display: flex;
            flex-direction: row-reverse;
            justify-content: space-between;
        }

        .travel_header {
            height: 400px;
            width: 100%;
            position: relative;
        }

        .travel_back,
        .travel_back:before,
        .travel_head {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
        }

        .travel_back {
            Z-index: 0;
            margin: 0;
            padding: 0;
        }

        .travel_back:before {
            content: '';
            display: block;
            background: rgb(161, 196, 251);
            opacity: 0.75;
        }

     .travel_cover {
         display: block;
         width: 100%;
         height:100%;
         object-fit: cover;
     }

        .travel_head {
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .travel_container {
            display: flex;
            flex-direction: row-reverse;
            justify-content: space-between;
        }

        .travel_ingredients {
            width: 320px;
            padding: 20px;
            background-color: #f1f1f1;
            display: flex;
            flex-direction: column-reverse;
        }

        .travel_fig {
            display: block;
            position: relative;
            width: 100%;
            height: 0;
            padding-top: 100%;
            margin: 0;
        }

        .travel_img {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

<?php
// On ouvre "la boucle" (The loop), la structure de contrôle de contenu propre à WordPress:
if (have_posts()): while (have_posts()): the_post(); ?>

    <div class="travel">

        <header class="travel_header">
            <div class="travel_head">
                <h2 class="travel_title"><?= get_the_title(); ?></h2>

                <p class="travel_excerpt"><?= get_the_excerpt(); ?></p>
            </div>
            <figure class="travel_back">
                <?= get_the_post_thumbnail(size: 'travel-header', attr: ['class' => 'travel_cover']); ?>
            </figure>
        </header>


        <div class="travel_container">


        <aside class="travel_ingredients">

            <div>
                <h3>Informations</h3>
                <p>À compléter</p>
            </div>
            <figure class="travel_fig">
                <?= get_the_post_thumbnail(size: 'travel-size', attr: ['class' => 'travel_img']); ?>
            </figure>

        </aside>
        <section class="travel_step">

            <h3>Prix</h3>
            <div><?= get_the_content(); ?></div>

        </section>
        </div>

    </div>


<?php
    // On ferme "la boucle" (The loop)
endwhile;
else: ?>
    <p>Cet voyage n'existe pas.</p>
<?php endif; ?>

<?php get_footer(); ?>