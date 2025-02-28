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

        .trips {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            gap: 1em;
        }

        .trip {
            position: relative;
            width: calc((100% - 3em)/4);
        }

        .trip_link {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }


        .trip_link:hover + .trip_card,
        .trip_link:focus + .trip_card {
            transform: translate3d(0, -4px, 0);
        }

        .trip_card {
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

        .trip_fig {
            display: block;
            position: relative;
            height: 0;
            padding: 60% 0 0 0;
            margin: 0;
        }

        .trip_img {
            display: block;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .trip_head {
            padding:1em
        }
    </style>

    <aside>
        <h2>Bienvenue sur mon site&nbsp;!</h2>
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

    <section>
        <h2>Mes voyages récents</h2>
        <div class="trips">
            <?php
            $travels = new WP_Query([
                    'post_type' => 'travel',
                    'order' => 'DESC',
                    'orderby' => 'date',
                    'posts_per_page' => 8,
            ]);
            if ($travels->have_posts()) : while($travels->have_posts()): $travels->the_post(); ?>
            <article class="trip">
                <a href="<?= get_the_permalink(); ?>" class="trip_link">
                    <span class="sro">Découvrire le voyage <?= get_the_title(); ?></span>
                </a>
                <div class="trip_card">
                    <header class="trip_header">
                        <h3 class="trip_title"> <?= get_the_title(); ?></h3>
                        <p><time datetime="<?= date('c', $depature = get_field('departure')); ?>"><?= date_i18n('F Y', $depature) ?></time></p>
                    </header>
                    <figure class="trip_fig">
                        <?= get_the_post_thumbnail(size: 'medium', attr: ['class' => 'trip_img']); ?>
                    </figure>
                </div>
            </article>
            <?php endwhile; else:?>
            <p>Je n'ai pas de voyages récents pour le moment..</p>
            <?php endif; ?>

        </div>
    </section>

    <?php get_footer(); ?>