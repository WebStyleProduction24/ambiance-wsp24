<?php
/**
 * Custom header for ambiance
 * @package ambiance
 * @since   1.0
 */
$postID                 = get_the_ID();
$pageTitle              = get_the_title();
$pageIcon               = get_post_meta($postID, 'ambiance_page_icon', true );
$pageSubTitle           = get_post_meta($postID, 'ambiance_page_subtitle', true );
$pageContentTitle       = get_post_meta($postID, 'ambiance_page_content_title', true );
$pageContentSubTitle    = get_post_meta($postID, 'ambiance_page_content_subtitle', true );
$previousPage           = ambiance_get_previous_page($postID);

?>

<header class="detail">
    <a href="#"  onClick="history.back();" class="back" data-transition="<?php echo Ambiance_Arr::get($previousPage, 'animation', 'slide-from-top'); ?>">
    </a>

    <section>
        <?php

        if (is_single()) {
            /* Override title for single posts */
            $page_for_posts = get_option( 'page_for_posts' );
            $pageTitle      = get_the_title();
            $pageSubTitle   = get_post_meta($page_for_posts, 'ambiance_page_subtitle', true );
        }

        ?>
        <h1><?php echo ( is_home() && ! is_front_page() ? single_post_title() : esc_html($pageTitle)); ?></h1>
        <?php echo ((!empty($pageSubTitle)) ? '<h3 class="badge">' . esc_html($pageSubTitle) .'</h3>' : ''); ?>
    </section>
</header>

<div class="content-wrap">
    <div class="content">
<?php
get_template_part('partials/general', 'icon');
?>
        <section>