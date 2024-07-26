<?php
/*
Template Name: Contact
*/
get_template_part('parts/header'); 
?>

<div class="content-area">
  <main class="site-main">
    <div class="contact-page site-wrap">
      <div class="contact-title">
      <h1>Contactez-nous</h1>
      <p>Veuillez remplir le formulaire ci-dessous pour nous envoyer un message.</p>
      </div>
      <div class="contact-info">
      <div class="contact-map">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2834.5422099282687!2d3.854551076485625!3d44.728953771071424!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12b4a4678faee59b%3A0x4ad1c792ac27f8f3!2s1%20Rue%20du%20Boulodrome%2C%2048300%20Langogne!5e0!3m2!1sfr!2sfr!4v1721996409811!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
      <div class="contact-form">
        <?php echo do_shortcode('[contact-form-7 id="caada61" title="Contact"]'); ?>
      </div>
      </div>
      <!-- Ajoutez d'autres contenus ici -->
    </div>
  </main>
<?php get_template_part('parts/footer'); ?>