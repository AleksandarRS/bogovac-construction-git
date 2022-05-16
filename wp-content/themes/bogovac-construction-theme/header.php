<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package bogovac
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
	<?php echo wp_kses( get_theme_mod( 'google_analytics_code' ), [ 'script' => [] ] ); ?>
	<meta name="theme-color" content="#010101">
</head>

<?php
	$header_content = get_field('header_content','option');
?>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'bogovac' ); ?></a>
	<header id="masthead" class="site-header" role="banner">
		<div class="container logo-description-wrapper">
			<div class="justify-content-between row logo-description-row">
				<div class="site-branding-main-logo site-branding col">
					<div class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<img src="<?php echo( esc_url( get_header_image() ) ); ?>" alt="<?php echo( esc_attr( get_bloginfo( 'title' ) ) ); ?>"/>
						</a>
					</div>
					<?php if ( bloginfo( 'description' ) != '' ) : ?>
						<p class="site-description"><?php bloginfo( 'description' ); ?></p>
					<?php endif; ?>
				</div><!-- .site-branding -->
				<?php  if ( $header_content ) : ?>
					<div class="entry-content main-header-description col-md-6">
						<?php echo $header_content; ?>
					</div>
                <?php endif; ?>

			</div> <!-- /.justify-content-between row logo-description-row -->
		</div> <!-- /.container logo-description-wrapper -->
	</header><!-- #masthead /.site-header -->

	<div id="content" class="site-content">