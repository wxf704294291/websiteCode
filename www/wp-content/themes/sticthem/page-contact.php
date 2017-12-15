<?php if ( ! isset( $_SESSION ) ) session_start();
/*
Template Name: Contact Page
*/
?>
<?php
	$et_ptemplate_settings = array();
	$et_ptemplate_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_ptemplate_settings',true) );

	$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;

	$et_regenerate_numbers = isset( $et_ptemplate_settings['et_regenerate_numbers'] ) ? (bool) $et_ptemplate_settings['et_regenerate_numbers'] : false;

	$et_error_message = '';
	$et_contact_error = false;

	if ( isset($_POST['et_contactform_submit']) ) {
		if ( !isset($_POST['et_contact_captcha']) || empty($_POST['et_contact_captcha']) ) {
			$et_error_message .= '<p>' . esc_html__('Make sure you entered the captcha. ','Foxy') . '</p>';
			$et_contact_error = true;
		} else if ( $_POST['et_contact_captcha'] <> ( $_SESSION['et_first_digit'] + $_SESSION['et_second_digit'] ) ) {
			$et_numbers_string = $et_regenerate_numbers ? esc_html__('Numbers regenerated.','Foxy') : '';
			$et_error_message .= '<p>' . esc_html__('You entered the wrong number in captcha. ','Foxy') . $et_numbers_string . '</p>';

			if ($et_regenerate_numbers) {
				unset( $_SESSION['et_first_digit'] );
				unset( $_SESSION['et_second_digit'] );
			}

			$et_contact_error = true;
		} else if ( empty($_POST['et_contact_name']) || empty($_POST['et_contact_email']) || empty($_POST['et_contact_subject']) || empty($_POST['et_contact_message']) ){
			$et_error_message .= '<p>' . esc_html__('Make sure you fill all fields. ','Foxy') . '</p>';
			$et_contact_error = true;
		}

		if ( !is_email( $_POST['et_contact_email'] ) ) {
			$et_error_message .= '<p>' . esc_html__('Invalid Email. ','Foxy') . '</p>';
			$et_contact_error = true;
		}
	} else {
		$et_contact_error = true;
		if ( isset($_SESSION['et_first_digit'] ) ) unset( $_SESSION['et_first_digit'] );
		if ( isset($_SESSION['et_second_digit'] ) ) unset( $_SESSION['et_second_digit'] );
	}

	if ( !isset($_SESSION['et_first_digit'] ) ) $_SESSION['et_first_digit'] = $et_first_digit = rand(1, 15);
	else $et_first_digit = $_SESSION['et_first_digit'];

	if ( !isset($_SESSION['et_second_digit'] ) ) $_SESSION['et_second_digit'] = $et_second_digit = rand(1, 15);
	else $et_second_digit = $_SESSION['et_second_digit'];

	if ( ! $et_contact_error && isset( $_POST['_wpnonce-et-contact-form-submitted'] ) && wp_verify_nonce( $_POST['_wpnonce-et-contact-form-submitted'], 'et-contact-form-submit' ) ) {
		$et_email_to = ( isset($et_ptemplate_settings['et_email_to']) && !empty($et_ptemplate_settings['et_email_to']) ) ? $et_ptemplate_settings['et_email_to'] : get_site_option('admin_email');

		$et_site_name = is_multisite() ? $current_site->site_name : get_bloginfo('name');

		$contact_name 	= stripslashes( sanitize_text_field( $_POST['et_contact_name'] ) );
		$contact_email 	= sanitize_email( $_POST['et_contact_email'] );

		$headers  = 'From: ' . $contact_name . ' <' . $contact_email . '>' . "\r\n";
		$headers .= 'Reply-To: ' . $contact_name . ' <' . $contact_email . '>';

		wp_mail( apply_filters( 'et_contact_page_email_to', $et_email_to ), sprintf( '[%s] ' . stripslashes( sanitize_text_field( $_POST['et_contact_subject'] ) ), $et_site_name ), stripslashes( wp_strip_all_tags( $_POST['et_contact_message'] ) ), apply_filters( 'et_contact_page_headers', $headers, $contact_name, $contact_email ) );

		$et_error_message = '<p>' . esc_html__('Thanks for contacting us','Foxy') . '</p>';
	}
?>
<?php get_header(); ?>

<?php get_template_part( 'includes/breadcrumbs', 'page' ); ?>

<?php
	$thumb = '';

	$width = (int) apply_filters( 'et_blog_image_width', 1280 );
	$height = (int) apply_filters( 'et_blog_image_height', 420 );

	$classtext = '';
	$titletext = get_the_title();
	$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Singleimage' );
	$thumb = $thumbnail["thumb"];

	$show_thumb = et_get_option( 'foxy_page_thumbnails', 'false' );
?>
<?php if ( 'on' == $show_thumb && '' != $thumb ) : ?>
	<div class="post-thumbnail">
		<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext ); ?>
	</div> <!-- .post-thumbnail -->
<?php endif; ?>

<div id="content" class="clearfix<?php if ( $fullwidth ) echo ' fullwidth'; ?>">
	<div id="left-area"<?php if ( 'on' == $show_thumb && '' != $thumb ) echo ' class="et_full_width_image"'; ?>>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', get_post_format() ); ?>

		<?php endwhile; ?>

	<?php if ( ! $fullwidth ) get_sidebar(); ?>
</div> <!-- #content -->

<?php get_footer(); ?>