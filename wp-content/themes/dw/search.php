<?php get_header(); ?>


<div>
    <h1>
        résultat de la recher : <?= get_search_query(); ?>
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

    <?php endif; ?>
</div>


<?php get_footer(); ?>
