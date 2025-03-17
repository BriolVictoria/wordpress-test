<?php get_header(); ?>
    <style type="text/css">
        .sro {
            position: absolute;
            overflow: hidden;
            clip: rect(0 0 0 0);
            height: 1px; width: 1px;
            margin: -1px;
            padding: 0;
            border: 0;
        }
        .trips, .recipes {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            gap: 1em;
        }
        .trip, .recipe {
            position: relative;
            width: calc((100% - 3em)/4);
        }
        .trip__link, .recipe__link {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .trip__link:hover + .trip__card,
        .trip__link:focus + .trip__card,
        .recipe__link:hover + .recipe__card,
        .recipe__link:focus + .recipe__card{
            transform: translate3d(0, -4px, 0);
        }
        .trip__card, .recipe__card {
            position: relative;
            z-index: 0;
            background: white;
            border-radius: 4px;
            overflow: hidden;
            -webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.2);
            -moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.2);
            box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column-reverse;
            transition: transform 200ms ease-out;
        }
        .trip__fig, .recipe__fig {
            display: block;
            position: relative;
            height: 0;
            padding: 60% 0 0 0;
            margin: 0;
        }
        .trip__img, .recipe__img {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .trip__head, .recipe__head {
            padding: 1em;
        }
        .section--recipe{
            margin-top: 3em;
        }
        .recipe__travel{
            color: black;
            text-decoration: none;
        }
    </style>

    <aside>
        <h2>Bienvenue sur mon site&nbsp;!</h2>
    </aside>
<?php
// On ouvre "la boucle" (The Loop), la structure de contrôle
// de contenu propre à Wordpress:
if(have_posts()): while(have_posts()): the_post(); ?>

    <div><?= get_the_content(); ?></div>

<?php
    // On ferme "la boucle" (The Loop):
endwhile; else: ?>
    <p>La page est vide.</p>
<?php endif; ?>
    <section>
        <h2><?= __hepl('Mes voyages récents') ?></h2>
        <div class="trips">
            <?php
            $travels = new WP_Query([
                'post_type' => 'travel',
                'order' => 'DESC',
                'orderby' => 'date',
                'posts_per_page' => 8,
            ]);

            if($travels->have_posts()): while($travels->have_posts()): $travels->the_post(); ?>
                <article class="trip">
                    <a href="<?= get_the_permalink(); ?>" class="trip__link">
                        <span class="sro">Découvrir le voyage <?= get_the_title(); ?></span>
                    </a>
                    <div class="trip__card">
                        <header class="trip__head">
                            <h3 class="trip__title"><?= get_the_title(); ?></h3>
                            <p><time datetime="<?= date('c', $departure = get_field('departure')); ?>"><?= date_i18n('F Y', $departure); ?></time></p>
                        </header>
                        <figure class="trip__fig">
                            <?= get_the_post_thumbnail(size: 'medium', attr: ['class' => 'trip__img']); ?>
                        </figure>
                    </div>
                </article>
            <?php endwhile; else: ?>
                <p>Je n'ai pas de voyages récents à montrer pour le moment...</p>
            <?php endif; ?>
        </div>
    </section>
    <section class="section--recipe">
        <h2>
            Les recettes de mes voyages
        </h2>
        <div class="recipes">
            <?php
            $recipes = new WP_Query([
                'post_type' => 'recipe',
                'order' => 'DESC',
                'orderby' => 'date',
                'posts_per_page' => 8,
            ]);
            if($recipes->have_posts()): while($recipes->have_posts()): $recipes->the_post(); ?>
                <article class="recipe">
                    <a href="<?= get_the_permalink(); ?>" class="recipe__link">
                        <span class="sro">Découvrir la recette <?= get_the_title(); ?></span>
                    </a>
                    <div class="recipe__card">
                        <header class="recipe__head">
                            <h3 class="recipe__title"><?=get_the_title()?></h3>
                        </header>
                        <figure class="recipe__fig">
                            <?= get_the_post_thumbnail(size: 'medium', attr: ['class' => 'recipe__img']); ?>
                        </figure>
                    </div>
                </article>
            <?php endwhile; else: ?>
                <p>Je n'ai pas de recette pour le moment</p>
            <?php endif; ?>
        </div>
    </section>
<?php get_footer(); ?>