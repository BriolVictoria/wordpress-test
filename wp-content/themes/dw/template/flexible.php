<?php
if (have_rows('content')):
    while (have_rows('content')):
        the_row();
        if (get_row_layout() === 'text-media'):
            include('content/text-media/text-media.php');
        elseif (get_row_layout() === 'image'):
            include('content/image/image.php');
        elseif (get_row_layout() === 'video'):
            include('content/video/video.php');
        elseif (get_row_layout() === 'galerie'):
            include('content/galerie/galerie.php');
        endif;
    endwhile;
endif;
?>