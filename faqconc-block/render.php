<!-- <p <?php //echo get_block_wrapper_attributes(); ?>>
	<?php //esc_html_e( 'FAQ Concertina block – hello from a dynamic block!!!!', 'faqconc-block' ); ?>
</p> -->

<?php
wp_register_style( 'faqconc-styles', plugins_url( '/faq-concertina/css/faq-concertina-styles.css') );
wp_enqueue_style( 'faqconc-styles' );

$speed = '750';
$hide_others = '1';
$category = '';
wp_register_script( 'faqconc-script', plugins_url( '/faq-concertina/js/faq-concertina-script.js'), array( 'jquery' ), '1_4_9' );
wp_enqueue_script( 'faqconc-script' );
wp_localize_script( 'faqconc-script', 'faqconcvars', array ( 'speed' => $speed, 'hideothers' => $hide_others, 'category' => $category ) );

$args = array(
  'post_type' 		=> 'faqconc',
  'posts_per_page'	=> '-1'
);

$faqs = new WP_Query( $args );

if ( $faqs->have_posts() ) {

  $current_ver = '1_4_9';

  // ob_start();
    
  $faq_concertina = '<div id="faqconc_' . $current_ver . '" class="faqconc" role="tablist" aria-multiselectable="true">'; // Add category as class if it exists

  while ( $faqs->have_posts() ) {
    $faqs->the_post();
    $faqid = get_the_ID();

    $before_faq = '';
    $before_faq = apply_filters('faqconc_before_faq', $before_faq);

    $this_faq = '';
    $this_faq .= '<div class="faq_item" id="faq' . $faqid . '">';
    $this_faq .= '<div class="faq_q" id="faq' . $faqid . '_q" aria-selected="false" aria-expanded="false" aria-controls ="faq' . $faqid . '_a" role="tab" tabindex="-1">';
    $this_faq .= get_the_title();
    $this_faq .= '</div>'; // .faq_q
    $this_faq .= '<div class="faq_a" id="faq' . $faqid . '_a" aria-labelledby="faq' . $faqid . '_q" aria-hidden="true" role="tabpanel">';
    $this_faq .= get_the_post_thumbnail($faqid, 'post-thumbnail', array( 'class' => 'faq_featured_image' ));
    $this_faq .= '<div class="faq_a_content">';
    $this_faq .=  wpautop( get_the_content() ); // ensure that the content is output with paragraph tags ( <p>...</p> )
    $this_faq .= '</div>'; // .faq_a_content
    $this_faq .= '</div>'; // .faq_a
    $this_faq .= '</div>'; // .faq_item

    $after_faq = '';
    $after_faq = apply_filters('faqconc_after_faq', $after_faq);

    $faq_concertina .= $before_faq;
    $faq_concertina .= $this_faq;
    $faq_concertina .= $after_faq;

//			$faq_concertina .= '<div class="nav-previous alignleft">' . next_posts_link( 'Next page' ) . '</div>';
//			$faq_concertina .= '<div class="nav-next alignright">' . previous_posts_link( 'Previous page' ) . '</div>';
  }
  $faq_concertina .= '</div>'; // .faqconc

} else {
  $faq_concertina = '<div id="faqconc_' . $current_ver . '" class="faqconc"><p><strong>' . __( 'Sorry, no FAQs can be found!', 'faq-concertina' ) . '</strong></p></div>';
}

wp_reset_postdata();

echo $faq_concertina;

// return ob_get_clean();

?>