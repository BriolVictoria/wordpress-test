<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= wp_title('·', false, 'right') . get_bloginfo('name') ?></title>
</head>
<body>

<header>
    <h1><?= get_bloginfo('name') ?></h1>
    <p> <?= get_bloginfo('description') ?></p>

    <nav class="nav">
        <h2 class="sro">Navigation principale</h2>
        <ul class="nav_container">
            <?php foreach (dw_get_navigation_links('header') as $link): ?>
            <li class="nav_item nav_item--<?= $link->icon; ?>">
                <a href="<?=$link->href  ?>" class="nav_link"><?= $link->label; ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>

<main>