<?php /* Template Name: Page Contact */ ?>

<?php get_header(); ?>

    <aside>
        <h2>Contactez-moi</h2>
    </aside>
<?php
// On ouvre "la boucle" (The loop), la structure de contrôle de contenu propre à WordPress:
if(have_posts()): while (have_posts()): the_post(); ?>

    <section class="contact">
        <div class="contact_left"><?= get_the_content(); ?></div>
        <div class="contact_right">
            <form action="<?= admin_url('admin-post.php') ?>" class="form" method="post" >
                <fieldset class="form_fields">
                    <div class="field">
                        <label for="firstname" class="field_label">Prénom</label>
                        <input type="text" name="firsname" id="firstname" class="field_input">
                    </div>
                    <div class="field">
                        <label for="lastname" class="field_label">Nom</label>
                        <input type="text" name="lastname" id="lastname" class="field_input">
                    </div>
                    <div class="field">
                        <label for="email" class="field_label">Email</label>
                        <input type="text" name="email" id="email" class="field_input">
                    </div>
                    <div class="field">
                        <label for="message" class="field_label">Message</label>
                        <textarea type="text" name="message" id="message" class="field_input"></textarea>
                    </div>
                </fieldset>
                    <div class="form_submit">
                        <?php  //Ce champs 'hidden' permet à wordpress d'indentifer la requêtre et de la transmettre à votre fonction définie dans fonctions.php via add_action('admin_post_[nom_action]') ?>
                        <input type="hidden" name="action" value="dw_submit_contact_form">
                        <button class="btn" type="submit">Envoyer</button>
                    </div>
            </form>
        </div>
    </section>

<?php
    // On ferme "la boucle" (The loop)
endwhile; else: ?>
    <p>La page est vide.</p>
<?php endif; ?>

<?php get_footer(); ?>