<?php
/**
 * Ultimate Social Deux.
 *
 * @package		Ultimate Social Deux
 * @author		Ultimate WP <hello@ultimate-wp.com>
 * @link		http://social.ultimate-wp.com
 * @copyright 	2015 Ultimate WP
 */

class UltimateSocialDeuxButtons {

	/**
	 * Instance of this class.
	 *
	 * @since	1.0.0
	 *
	 * @var		object
	 */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @since	 1.0.0
	 *
	 * @return	object	A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public static function buttons($sharetext = '', $networks = array(), $url = '', $align = "center", $count = true, $native = false, $skin = 'default') {

		UltimateSocialDeux::enqueue_stuff();

		if ( $url ) {
			$url = $url;
			$text = '';
			$post_id = url_to_postid( $url );
		} elseif ( is_singular() ) {
			$text = get_the_title();
			$url = get_permalink();
			$post_id = get_the_ID();
		} elseif ( in_the_loop() ) {
			$text = get_the_title();
			$url = get_permalink();
			$post_id = get_the_ID();
		} elseif ( is_home() ) {
			$text = get_bloginfo('name');
			$url = get_bloginfo('url');
			$post_id = url_to_postid( $url );
		} elseif ( is_tax() || is_category() ) {
			global $wp_query;
			$term = $wp_query->get_queried_object();
			$text = $term->name;
			$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$post_id = 0;
		} else {
			$text = get_bloginfo('name');
			$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$post_id = url_to_postid( $url );
		}

		if ($align == 'left') {
			$align = " us_tal";
		} elseif ($align == 'right') {
			$align = " us_tar";
		} else {
			$align = " us_tac";
		}

		$skin = ( $skin ) ? sprintf(' us_skin_%s', $skin): ' us_skin_default';

		$networks = str_replace(' ', '', $networks);

		$networks = ( is_array($networks) ) ? $networks: explode(',', $networks);

		$networks = array_filter($networks);

		$count = filter_var($count, FILTER_VALIDATE_BOOLEAN);

		$native = filter_var($native, FILTER_VALIDATE_BOOLEAN);

		global $us_share_counts;

		$us_share_counts = (!isset($us_share_counts)) ? maybe_unserialize( get_option('us_share_counts', array()) ): $us_share_counts;

		$ajaxnetworks = '';

		$us_share_counts[$url] = (isset($us_share_counts[$url])) ? $us_share_counts[$url]: array();

		foreach ($networks as $network) {

			$network = (strpos($network, 'facebook') === 0) ? 'facebook': $network;
			$network = (strpos($network, 'google') === 0) ? 'google': $network;
			$network = (strpos($network, 'vkontakte') === 0) ? 'vkontakte': $network;

			if ( array_key_exists($network, self::ajax_count()) && ( (!array_key_exists($network, $us_share_counts[$url])) || ( isset($us_share_counts[$url][$network]['timestamp']) && $us_share_counts[$url][$network]['timestamp'] + intval(UltimateSocialDeux::opt('us_counts_transient', 600)) < time() ) ) ){
				$ajaxnetworks .= $network.',';
			}
		}

		$ajaxnetworks = ( $ajaxnetworks ) ? sprintf(' data-ajaxnetworks="%s"',substr($ajaxnetworks, 0, -1)):'';

		if ($url) {

			$output = sprintf('<div class="us_wrapper us_share_buttons%s%s" data-text="%s" data-url="%s"%s>', $align, $skin, strip_tags($text), $url, $ajaxnetworks);

			$more = '';
			$names = '';

			if ($sharetext) {
				$output .= sprintf('<div class="us_button us_share_text"><span class="us_share_text_span">%s</span></div>', $sharetext);
			}

			foreach ($networks as $button) {

				$native = (substr($button, -7) == '_native') ? true : $native;
				$button = (strpos($button, 'facebook') === 0) ? 'facebook': $button;
				$button = (strpos($button, 'google') === 0) ? 'google': $button;
				$button = (strpos($button, 'vkontakte') === 0) ? 'vkontakte': $button;

				$count_number = ( ( !array_key_exists($button, self::ajax_count()) && !array_key_exists($button, self::internal_count()) ) || $count == false ) ? false: $count;

				$number = ( isset($us_share_counts[$url][$button]['count']) ) ? UltimateSocialDeux::number_format($us_share_counts[$url][$button]['count']): '';

				$name = ( $names ) ? UltimateSocialDeux::opt('us_'.$button.'_name', ''):'';

				switch ($button) {
					case 'total':
						$output .= self::total_button($url, $networks, $more, $us_share_counts, $post_id);
					break;
					case 'pinterest':
						$output .= self::pinterest_button($url, $text, $count_number, $more, $number, $name, $post_id);
					break;
					case 'buffer':
						$media = UltimateSocialDeux::catch_first_image($url, $post_id);
						$output .= self::button($button, $url, $count_number, false, $more, $media, $number, $name);
					break;
					case 'mail':
						$output .= self::mail_button($url, $more, $name);
					break;
					case 'comments':
						$output .= self::comments_button($url, $count_number, $more, $name, $post_id);
					break;
					case 'love':
						$output .= self::love_button($url, $count_number, $more, $name, $post_id);
					break;
					case 'print':
						$output .= self::print_button($more, $name);
					break;
					case 'whatsapp':
						$output .= self::whatsapp_button($more, $name);
					break;
					case 'more':
						wp_enqueue_script( 'jquery-magnific-popup' );

						$random_string = UltimateSocialDeux::random_string(5);
						$more = ' us_after_more';
						$output .= '<div class="us_more us_button us_no_count"><a class="us_box" href="#us-modal-'.$random_string.'"><div class="us_share"><i class="us-icon-plus"></i></div></a></div>';
						$output .= sprintf('<div class="us_wrapper us_modal mfp-hide%s" id="us-modal-%s">', $skin, $random_string);

							$output .= '<div class="us_heading">';
								$output .= __('More share buttons', 'ultimate-social-deux');
							$output .= '</div>';
							$output .= sprintf('<div class="us_modal_button_wrapper us_tac" data-text="%s" data-url="%s">', strip_tags($text), $url);

					break;
					case 'more_end':
						$output .= '</div></div>';
						$more = '';
					break;
					case 'names':
						$names = true;
					break;
					case 'names_end':
						$names = false;
					break;
					default:
						$output .= self::button($button, $url, $count_number, $native, $more, false, $number, $name);
					break;
				}

				$native = '';

			}
			if (in_array('more', $networks) && !in_array('more_end', $networks)) {
				$output .= '</div></div>';
			}

			$output .= '</div>';

			return $output;

		}

	}

	/**
	 * Returns total button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public static function total_button($url, $networks, $more = '', $us_share_counts, $post_id) {

		$text = UltimateSocialDeux::opt('us_total_shares_text', __( 'Shares', 'ultimate-social-deux' ) );

		$number = 0;

		if(($key = array_search('googleplus', $networks)) !== false) {
		    unset($networks[$key]);
		    $networks[] = 'google';
		}
		if(($key = array_search('google_native', $networks)) !== false) {
		    unset($networks[$key]);
		    $networks[] = 'google';
		}
		if(($key = array_search('googleplus_native', $networks)) !== false) {
		    unset($networks[$key]);
		    $networks[] = 'google';
		}
		if(($key = array_search('vkontakte_native', $networks)) !== false) {
		    unset($networks[$key]);
		    $networks[] = 'vkontakte';
		}
		if(($key = array_search('facebook_native', $networks)) !== false) {
		    unset($networks[$key]);
		    $networks[] = 'facebook';
		}

		$networks = array_unique($networks);

		foreach ($networks as $network) {

			$network = (strpos($network, 'google') === 0) ? 'google': $network;

			if (in_array($network, self::ajax_count()))  {

				$number += (isset($us_share_counts[$url][$network]['count'])) ? $us_share_counts[$url][$network]['count']:0;

			}
			if ($network == 'comments') {

				if ( $post_id != 0 && comments_open() ){

					$number += ( get_comments_number() ) ? get_comments_number() : 0;

				}
			}
			if ($network == 'love') {

				$love = get_option( 'us_love_count' );

				$number += ( !empty( $love['data'][$url]['count'] ) ) ? $love['data'][$url]['count']: 0;

			}

		}

		$number = UltimateSocialDeux::number_format($number);

		$button = '';

		if ($number) {
			$button .= sprintf('<div class="us_total us_button%s"><div class="us_box" href="#"><div class="us_count">%s</div><div class="us_share">%s</div></div></div>', $more, $number, strip_tags($text));
		}

		return $button;
	}

	public static function button($network, $url, $count = true, $native = false, $more = '', $media, $number, $name) {

		if ($native) {
			wp_enqueue_script( 'us-native' );
		}

		$transient = '';

		$number = ($count) ? '<div class="us_count">'.$number.'</div>': '';

		$media = ($media) ? sprintf(' data-media="%s"',$media): '';

		$name = ($name) ? '<div class="us_name"><span>'.$name.'</span></div>':'';

		$counter_class = ( $count ) ? '': ' us_no_count';

		$native_class = ( $native ) ? ' us_native': '';

		$names_class = ( $name ) ? ' us_names': '';

		$native_markup = '';

		$native_markup .= ( $native && $network == 'facebook' ) ? sprintf('<a class="usnative facebook-like" href="#" data-href="%s" data-layout="button" data-action="like" data-show-faces="true" data-share="false"></a>',$url): '';

		$native_markup .= ( $native && $network == 'google' ) ? sprintf('<a class="usnative googleplus-one" href="#" data-href="%s" data-size="medium" data-annotation="none"></a>',$url): '';

		$native_markup .= ( $native && $network == 'vkontakte' ) ? sprintf('<a class="usnative vkontakte-like vk-like" href="#" data-pageUrl="%s"></a>',$url): '';

		$button = sprintf('<div class="us_%s%s%s%s%s us_button"%s><a class="us_box" href="#"><div class="us_share"><i class="us-icon-%s"></i></div>%s%s</a>%s</div>',$network, $more, $counter_class, $names_class, $native_class, $media, $network, $name, $number, $native_markup );

		return $button;
	}

	/**
	 * Returns Pinterest button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public static function pinterest_button($url, $text, $count = true, $more = '', $number, $name, $post_id) {

		wp_enqueue_script( 'jquery-magnific-popup' );

		$random_string = UltimateSocialDeux::random_string(5);

		$counter_class = ( $count ) ? '': ' us_no_count';

		$number = ($count) ? '<div class="us_count">'.$number.'</div>': '';

		$name = ($name) ? '<div class="us_name"><span>'.$name.'</span></div>':'';

		$names_class = ( $name ) ? ' us_names': '';

		$button = sprintf('<div class="us_pinterest%s%s%s us_button"><a class="us_box" href="#us-modal-%s"><div class="us_share"><i class="us-icon-pinterest"></i></div>%s%s</a></div>',$more, $counter_class, $names_class, $random_string, $name, $number);

		$form = sprintf('<div class="us_wrapper us_modal mfp-hide" id="us-modal-%s" data-url="%s" data-text="%s">', $random_string, $url, strip_tags($text));

			$form .= '<div class="us_heading">';
				$form .= __('Share on Pinterest', 'ultimate-social-deux');
			$form .= '</div>';

			$content = ( !empty($post_id) ) ? get_post_field('post_content', $post_id): '';

			if ($post_id == 0) {

				global $wp_query;

				foreach ($wp_query->posts as $post) {

					$content .= $post->post_content;

				}

			}

			preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*)/i', $content, $matches);

			$matches[1] = array_unique($matches[1]);

			if( has_post_thumbnail( $post_id ) || !empty($matches[1]) ) {

				$form .= '<div class="us_pinterest_images">';

				if(has_post_thumbnail( $post_id )) {
					$src = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
					$form .= sprintf('<div class="us_pinterest_image_holder"><a href="#"><img src="%s"/></a></div>', $src);

				}

				if(!empty($matches[1])) {

					foreach ($matches[1] as $src) {
						$form .= sprintf('<div class="us_pinterest_image_holder"><a href="#"><img src="%s"/></a></div>', $src);
					}

				}

				$form .= '</div>';

			} else {
				$form .= '<div class="us_pinterest_no_images alert alert-danger">' . __('There are no images.', 'ultimate-social-deux') . '</div>';
			}

		$form .= '</div>';

		$button .= $form;

		return $button;

	}

	/**
	 * Returns comments button.
	 *
	 * @since	3.0.0
	 *
	 * @return	button
	 */
	public static function comments_button($url, $count = true, $more = '', $name, $post_id) {

		if ( $post_id != 0 && comments_open() ){

			$name = ($name) ? '<div class="us_name"><span>'.$name.'</span></div>':'';

			$names_class = ( $name ) ? ' us_names': '';

			$number = ( $count ) ? '<div class="us_count">'.UltimateSocialDeux::number_format( get_comments_number() ).'</div>': '';

			$counter_class = ( $count ) ? '': ' us_no_count';

			$button = sprintf('<div class="us_comments%s%s%s us_button"><a class="us_box" href="%s#comments"><div class="us_share"><i class="us-icon-comments"></i></div>%s%s</a></div>', $more, $counter_class, $names_class, $url, $name, $number );

			return $button;

		}

	}

	/**
	 * Returns love button.
	 *
	 * @since	3.0.0
	 *
	 * @return	button
	 */
	public static function love_button($url, $count = true, $more = '', $name) {

		global $us_love_counts;

		$us_love_counts = (!isset($us_love_counts)) ? get_option('us_love_count', array()): $us_love_counts;

		wp_enqueue_script( 'jquery-cookie' );

		$current_user = wp_get_current_user();

		$user_id = ( $current_user->ID ) ? $current_user->ID: 0;

		$name = ($name) ? '<div class="us_name"><span>'.$name.'</span></div>':'';

		$names_class = ( $name ) ? ' us_names': '';

		$number = ( !empty( $us_love_counts['data'][$url]['count'] ) ) ? $us_love_counts['data'][$url]['count']: 0;

		$number = ( $count ) ? '<div class="us_count">'.$number.'</div>': '';

		$counter_class = ( $count ) ? '': ' us_no_count';

		$id_array = ( !empty($options['data'][$url]['ids']) ) ? $options['data'][$url]['ids']: array();

		$loved_class = ( in_array( $user_id, $id_array ) ) ? ' loved': '';

		$button = sprintf('<div class="us_love%s%s%s us_button"><a class="us_box%s" href="#"><div class="us_share"><i class="us-icon-love"></i></div>%s%s</a></div>', $more, $counter_class, $names_class, $loved_class, $name, $number);

		return $button;

	}

	/**
	 * Returns WhatsApp button.
	 *
	 * @since	4.0.0
	 *
	 * @return	button
	 */
	public static function whatsapp_button( $more = '', $name) {

		$name = ($name) ? '<div class="us_name"><span>'.$name.'</span></div>':'';

		$names_class = ( $name ) ? ' us_names': '';

		$button = sprintf('<div class="us_whatsapp%s%s us_no_count us_button"><a class="us_box" href="#"><div class="us_share"><i class="us-icon-whatsapp"></i></div>%s</a></div>', $more, $names_class, $name );

		return $button;
	}

	/**
	 * Returns Print button.
	 *
	 * @since	3.0.0
	 *
	 * @return	button
	 */
	public static function print_button($more = '', $name) {

		$name = ($name) ? '<div class="us_name"><span>'.$name.'</span></div>':'';

		$names_class = ( $name ) ? ' us_names': '';

		$button = sprintf('<div class="us_print%s%s us_no_count us_button"><a class="us_box" href="#"><div class="us_share"><i class="us-icon-print"></i></div>%s</a></div>', $more, $names_class, $name);

		return $button;

	}

	/**
	 * Returns Mail button.
	 *
	 * @since	1.0.0
	 *
	 * @return	button
	 */
	public static function mail_button($url, $more = '', $name) {

		wp_enqueue_script( 'jquery-magnific-popup' );

		global $us_popup_form;

		$name = ($name) ? '<div class="us_name"><span>'.$name.'</span></div>':'';

		$names_class = ( $name ) ? ' us_names': '';

		$random_string = UltimateSocialDeux::random_string(5);

		$body = UltimateSocialDeux::mail_replace_vars( UltimateSocialDeux::opt('us_mail_body', __('I read this article and found it very interesting, thought it might be something for you. The article is called', 'ultimate-social-deux' ) . ' ' . '{post_title} ' . ' ' . __('and is located at', 'ultimate-social-deux' ) . ' ' . ' {post_url}.'), $url, '', '' );

		$captcha_enable	= UltimateSocialDeux::opt('us_mail_captcha_enable', 'yes');
		$captcha = UltimateSocialDeux::opt('us_mail_captcha_question', __('What is the sum of 7 and 2?', 'ultimate-social-deux') );

		$us_share = UltimateSocialDeux::opt('us_mail_header', __('Share with your friends','ultimate-social-deux') );

		$your_name = __('Your Name','ultimate-social-deux');
		$your_email = __('Your Email','ultimate-social-deux');
		$recipient_email = __('Recipient Email','ultimate-social-deux');
		$your_message = __('Enter a Message','ultimate-social-deux');
		$captcha_label = __('Captcha','ultimate-social-deux');

		$form = sprintf('<div class="us_wrapper us_modal mfp-hide" id="us-modal-%s">', $random_string);
			$form .= '<div class="us_heading">';
				$form .= $us_share;
			$form .= '</div>';
			$form .= '<div class="us_mail_response"></div>';
			$form .= '<div class="us_mail_form_holder">';
				$form .= '<form role="form" id="ajaxcontactform" class="form-group contact" action="" method="post" enctype="multipart/form-data">';
					$form .= '<div class="form-group">';
						$form .= sprintf('<label class="label" for="ajaxcontactyour_name">%s</label><br>', $your_name );
						$form .= sprintf('<input type="text" id="ajaxcontactyour_name" class="border-box form-control us_mail_your_name" name="%s" placeholder="%s"><br>', $your_name, $your_name );
						$form .= sprintf('<label class="label" for="ajaxcontactyour_email">%s</label><br>', $your_email );
						$form .= sprintf('<input type="email" id="ajaxcontactyour_email" class="border-box form-control us_mail_your_email" name="%s" placeholder="%s"><br>', $your_email, $your_email );
						$form .= sprintf('<label class="label" for="ajaxcontactrecipient_email">%s</label><br>', $recipient_email );
						$form .= sprintf('<input type="email" id="ajaxcontactrecipient_email" class="border-box form-control us_mail_recipient_email" name="%s" placeholder="%s"><br>', $recipient_email, $recipient_email);
						$form .= sprintf('<label class="label" for="ajaxcontactmessage">%s</label><br>', $your_message);
						$form .= sprintf('<textarea class="border-box form-control border-us_box us_mail_message" id="ajaxcontactmessage" name="%s" placeholder="%s">%s</textarea>', $your_message, $your_message, $body);
						$form .= sprintf('<input type="email" id="ajaxcontactrecipient_url" class="border-box form-control us_mail_url" style="display:none;" name="%s" placeholder="%s"><br>', $url, $url);
					$form .= '</div>';

					if ( $captcha_enable == 'yes' ){
						$form .= '<div class="form-group">';
							$form .= sprintf('<label class="label" for="ajaxcontactcaptcha">%s</label><br>', $captcha_label);
							$form .= sprintf('<input type="text" id="ajaxcontactcaptcha" class="border-box form-control us_mail_captcha" name="%s" placeholder="%s"><br>', $captcha_label, $captcha);
						$form .= '</div>';
					}
				$form .= '</form>';
				$form .= sprintf('<a class="btn btn-success us_mail_send">%s</a>', __('Submit','ultimate-social-deux') );
			$form .= '</div>';
		$form .= '</div>';

		$button = sprintf('<div class="us_mail%s%s us_button us_no_count"><a class="us_box" href="#us-modal-%s"><div class="us_share"><i class="us-icon-mail"></i></div>%s</a></div>', $more, $names_class, $random_string, $name);

		$button .= $form;
		return $button;

	}

	public static function ajax_count() {
		$array = array(
			'facebook' => true,
			'twitter' => true,
			'google' => true,
			'pinterest' => true,
			'linkedin' => true,
			'stumble' => true,
			'delicious' => true,
			'buffer' => true,
			'vkontakte' => true,
			'ok' => true,
			'managewp' => true,
			'xing' => true,
		);

		return $array;
	}

	public static function internal_count() {
		$array = array(
			'love' => true,
			'comments' => true,
		);

		return $array;
	}

}
