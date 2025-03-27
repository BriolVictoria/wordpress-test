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
            background: #d6d3ce;
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

        .recipe__travel {
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
            <section>
                <h4>Quand manger?</h4>
                <?php if ($courses = get_the_terms(get_the_ID(), 'course')):?>
                    <ul>
                        <?php foreach ($courses as $term): ?>
                            <li><?= $term->name; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Quand vous-voulez</p>
                <?php endif; ?>
            </section>

            <section>
                <h4>Pour quel régime ?</h4>
                <?php if ($diets = get_the_terms(get_the_ID(), 'diet')): ?>
                    <ul>
                        <?php foreach ($diets as $term): ?>
                            <li><?= $term->name; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Aucun régime particulier</p>
                <?php endif; ?>
            </section>
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
    <style type="text/css">
        .related {
            background: #f1f1f1;
        }
        .related__container {
            display: flex;
            justify-content: flex-start;
            flex-direction: row;
            flex-wrap: wrap;
        }
        .recipe {
            width: 25%;
            display: block;
            position: relative;
        }
        .recipe__link {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .recipe__card {
            display: block;
            position: relative;
            z-index: 0;
            background: white;
            padding: 1em;
        }
        .recipe__title {
            margin: 0;
        }
        .recipe__fig {
            width: auto;
        }
        .recipe__img {
            width: 100%;
        }
        .sro {
            position: absolute;
            overflow: hidden;
            clip: rect(0 0 0 0);
            height: 1px; width: 1px;
            margin: -1px;
            padding: 0;
            border: 0;
        }
    </style>
    <section class="related">
        <h2 class="related__title">Autres recette qui pourraient vous intéresser...</h2>
        <div class="related__container">
            <?php
            $recipes = new WP_Query([
                'post_type' => 'recipe',
                'orderby' => 'rand',
                'posts_per_page' => 4,
                'post__not_in' => [$post->ID], // Toutes les recettes possibles, sauf celle de la page courante ($post est une variable globale à cette page, représentant la recette en cours).

                // On filtre sur les "$course" courants pour obtenir des résultats similaires:
                'tax_query' => [
                    'relation' => 'AND',
                    [
                        'taxonomy' => 'course',
                        'field' => 'term_id',
                        'terms' => array_map(fn($course) => $course->term_id, $courses),
                        // OU (même chose, sans "arrow function" de PHP 8.3) :
                        // 'term' => array_map(function($course) {
                        //     return $course->ID;
                        // }, $courses),
                        'include_children' => true,
                        'operator' => 'IN'
                    ]
                ],
            ]);

            if($recipes->have_posts()): while($recipes->have_posts()): $recipes->the_post(); ?>
                <article class="recipe">
                    <a href="<?= get_the_permalink(); ?>" class="recipe__link"><span class="sro">Voir la recette "<?= get_the_title(); ?>"</span></a>
                    <div class="recipe__card">
                        <h3 class="recipe__title"><?= get_the_title(); ?></h3>
                        <figure class="recipe__fig">
                            <?= get_the_post_thumbnail(size: 'medium', attr: ['class' => 'recipe__img']); ?>
                        </figure>
                    </div>
                </article>
            <?php endwhile; endif; ?>

            <section class="contact">
                <div class="contact__left"><?= get_the_content(); ?></div>
                <div class="contact__right">
                    <?php
                    $errors = $_SESSION['contact_form_errors'] ?? [];
                    unset($_SESSION['contact_form_errors']);
                    $success = $_SESSION['contact_form_success'] ?? false;
                    unset($_SESSION['contact_form_success']);

                    if($success): ?>
                        <div class="contact__success">
                            <p><?= $success; ?></p>
                        </div>
                    <?php else: ?>
                        <form action="<?= admin_url('admin-post.php'); ?>" method="POST" class="form">
                            <fieldset class="form__fields">
                                <div class="field">
                                    <label for="firstname" class="field__label">Prénom</label>
                                    <input type="text" name="firstname" id="firstname" class="field__input">
                                    <?php if(isset($errors['firstname'])): ?>
                                        <p class="field__error"><?= $errors['firstname']; ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="field">
                                    <label for="lastname" class="field__label">Nom</label>
                                    <input type="text" name="lastname" id="lastname" class="field__input">
                                    <?php if(isset($errors['lastname'])): ?>
                                        <p class="field__error"><?= $errors['lastname']; ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="field">
                                    <label for="email" class="field__label">Adresse mail</label>
                                    <input type="email" name="email" id="email" class="field__input">
                                    <?php if(isset($errors['email'])): ?>
                                        <p class="field__error"><?= $errors['email']; ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="field">
                                    <label for="message" class="field__label">Message</label>
                                    <textarea name="message" id="message" class="field__input"></textarea>
                                    <?php if(isset($errors['message'])): ?>
                                        <p class="field__error"><?= $errors['message']; ?></p>
                                    <?php endif; ?>
                                </div>
                            </fieldset>
                            <div class="form__submit">
                                <?php
                                // ce champ "hidden" permet à WP d'identifier la requête et de la transmettre
                                // à notre fonction définie dans functions.php via "add_action('admin_post_[nom-action]')"
                                ?>
                                <input type="hidden" name="action" value="dw_submit_contact_form">
                                <button type="submit" class="btn">Envoyer</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </section>
<?php get_footer(); ?>