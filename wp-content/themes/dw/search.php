<?php get_header(); ?>


<div>
    <h1>
        résultat de la recherche : <?= get_search_query(); ?>
    </h1>

    <?php if (have_posts()): ?>
    <ul>
        <?php while (have_posts()): the_post(); ?>
        <li>
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </li>
        <?php endwhile;?>
    </ul>

    <?php else: ?>
<p>Désolé il n'y a rien</p>
    <?php endif; ?>
</div>


<?php get_footer(); ?>
