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
        .travel {
        }
        .travel__header {
            height: 400px;
            width: 100%;
            position: relative;
        }
        .travel__back,
        .travel__back:before,
        .travel__head {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
        }
        .travel__back {
            z-index: 0;
            margin: 0;
            padding: 0;
        }
        .travel__back:before {
            content: '';
            display: block;
            background: rgb(100,20,40);
            opacity: 0.75;
        }
        .travel__cover {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .travel__head {
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
        }
        .travel__container {
            display: flex;
            flex-direction: row-reverse;
            justify-content: space-between;
        }
        .travel__ingredients {
            width: 320px;
            padding: 20px;
            background: #f1f1f1;
            display: flex;
            flex-direction: column-reverse;
        }
        .travel__fig {
            display: block;
            position: relative;
            width: 100%;
            height: 0;
            padding-top: 100%;
            margin: 0;
        }
        .travel__img {
            display: block;
            position: absolute;
            top:0;
            left:0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .travel__rating {
            width: 150px;
            height: 30px;
            display: block;
            position: relative;
            background: url(/wp-content/themes/dw/resources/img/star_empty.svg);
            background-repeat: repeat-x;
            background-position: 0 0;
        }
        .travel__rating:after {
            content:'';
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 0;
            background: url(/wp-content/themes/dw/resources/img/star_filled.svg);
            background-repeat: repeat-x;
            background-position: 0 0;
        }
        .travel__rating[data-score="1"]:after {
            width: 30px;
        }
        .travel__rating[data-score="2"]:after {
            width: 60px;
        }
        .travel__rating[data-score="3"]:after {
            width: 90px;
        }
        .travel__rating[data-score="4"]:after {
            width: 120px;
        }
        .travel__rating[data-score="5"]:after {
            width: 100%;
        }
    </style>

<?php
// On ouvre "la boucle" (The Loop), la structure de contrôle
// de contenu propre à Wordpress:
if(have_posts()): while(have_posts()): the_post(); ?>
    <div class="travel">
        <header class="travel__header">
            <div class="travel__head">
                <h2 class="travel__title"><?= get_the_title(); ?></h2>
                <p class="travel__excerpt"><?= get_the_excerpt(); ?></p>
                <div class="travel__rating" data-score="<?= $rating = get_field('rating'); ?>">
                    <p class="sro">Ce voyage obtient l'appréciation de <?= $rating; ?> étoiles sur 5</p>
                </div>
                <div class="travel__dates">
                    <?php
                    $departure = get_field('departure');
                    $return = get_field('return');
                    if($return): ?>
                        <p>Du <time datetime="<?= date('c', $departure); ?>"><?= date_i18n('d F Y', $departure); ?></time> au <time datetime="<?= date('c', $return); ?>"><?= date_i18n('d F Y', $return); ?></time></p>
                    <?php else: ?>
                        <p>Depuis le <time datetime="<?= date('c', $departure); ?>"><?= date_i18n('d F Y', $departure); ?></time>.</p>
                    <?php endif; ?>
                </div>
            </div>
            <figure class="travel__back">
                <?= get_the_post_thumbnail(size: 'travel-header', attr: ['class' => 'travel__cover']); ?>
            </figure>
        </header>

        <div class="travel__container">
            <aside class="travel__ingredients">
                <div>
                    <h3>Points-clés</h3>
                    <div class="wysiwyg">
                        <?= get_field('keypoints'); ?>
                    </div>
                </div>
                <figure class="travel__fig">
                    <?= wp_get_attachment_image(get_field('side_image'), 'travel-side', attr: ['class' => 'travel__img']); ?>
                </figure>
            </aside>

            <section class="travel__steps">
                <h3>Récit de voyage</h3>
                <div class="wysiwyg">
                    <?= get_field('story'); ?>
                </div>
            </section>
        </div>
    </div>

<?php
    // On ferme "la boucle" (The Loop):
endwhile; else: ?>
    <p>Ce voyage n'existe pas.</p>
<?php endif; ?>
<?php get_footer(); ?>