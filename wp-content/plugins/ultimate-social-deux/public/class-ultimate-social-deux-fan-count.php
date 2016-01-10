<?php
/**
 * Ultimate Social Deux.
 *
 * @package		Ultimate Social Deux
 * @author		Ultimate WP <hello@ultimate-wp.com>
 * @link		http://social.ultimate-wp.com
 * @copyright 	2015 Ultimate WP
 */

class UltimateSocialDeuxFanCount {

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
	 * Return fan counters
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function fan_count_output($networks = '', $rows = '1', $skin = '') {

		wp_enqueue_script( 'jquery-fittext' );

		UltimateSocialDeux::enqueue_stuff();

		global $us_fan_count_data;

		$skin = ( $skin ) ? sprintf(' us_skin_%s', $skin): ' us_skin_default';

		$networks = str_replace(' ', '', $networks);

		$networks = explode(',', $networks);

		global $us_fan_counts;

		$us_fan_counts = (!isset($us_fan_counts)) ? maybe_unserialize( get_option('us_fan_counts', array()) ): $us_fan_counts;

		$ajaxnetworks = '';

		foreach ($networks as $network) {

			if ( array_key_exists($network, self::ajax_count()) && ( (!array_key_exists($network, $us_fan_counts)) || ( isset($us_fan_counts[$network]['timestamp']) && $us_fan_counts[$network]['timestamp'] + intval(UltimateSocialDeux::opt('us_cache', 2))*3600 < time() ) ) ){
				$ajaxnetworks .= $network.',';
			}
		}

		$ajaxnetworks = ( $ajaxnetworks ) ? sprintf(' data-ajaxnetworks="%s"',substr($ajaxnetworks, 0, -1)):'';

		$output = sprintf('<div class="us_wrapper us_fan_count_wrapper%s"%s>', $skin, $ajaxnetworks);

		foreach ($networks as &$network) {

			$count = (isset($us_fan_counts[$network]['count'])) ? UltimateSocialDeux::number_format( $us_fan_counts[$network]['count'] ):0;

			switch ($network) {
			  	case "facebook":
					$desc = __('Fans', 'ultimate-social-deux');
					$link = sprintf('https://facebook.com/%s', UltimateSocialDeux::opt('us_facebook_id', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
			  	case "twitter":
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('https://twitter.com/%s', UltimateSocialDeux::opt('us_twitter_id', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "google":
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('https://plus.google.com/%s/', UltimateSocialDeux::opt('us_google_id', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "youtube":
					$desc = __('Subscribers', 'ultimate-social-deux');
					$link = sprintf('https://www.youtube.com/user/%s/', UltimateSocialDeux::opt('us_youtube_id', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "love":
					$count = UltimateSocialDeux::number_format( self::love_count() );
					$desc = __('Total loves', 'ultimate-social-deux');
					$link = '';
					$output .= self::counter($network, $count, $desc, $rows, $link, '');
				break;
				case "delicious":
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('https://delicious.com/%s/', UltimateSocialDeux::opt('us_delicious_id', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "linkedin":
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('https://linkedin.com/company/%s', UltimateSocialDeux::opt('us_linkedin_id', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "behance":
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('https://www.behance.net/%s', UltimateSocialDeux::opt('us_behance_id', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "vimeo":
					$desc = __('Subscribers', 'ultimate-social-deux');
					$link = sprintf('http://vimeo.com/channels/%s', UltimateSocialDeux::opt('us_vimeo_id', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "dribbble":
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('https://dribbble.com/%s', UltimateSocialDeux::opt('us_dribbble_id', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "envato":
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('http://codecanyon.net/user/%s/follow', UltimateSocialDeux::opt('us_envato_id', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "github":
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('https://github.com/%s', UltimateSocialDeux::opt('us_github_id', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "soundcloud":
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('https://soundcloud.com/%s', UltimateSocialDeux::opt('us_soundcloud_username', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "instagram":
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('http://instagram.com/%s', UltimateSocialDeux::opt('us_instagram_username', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "vkontakte":
					$desc = __('Members', 'ultimate-social-deux');
					$link = sprintf('http://vk.com/%s', UltimateSocialDeux::opt('us_vkontakte_id', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "feedpress":
					$desc = __('Subscribers', 'ultimate-social-deux');
					$link = sprintf('%s', UltimateSocialDeux::opt('us_feedpress_url', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "pinterest":
					$desc = __('Followers', 'ultimate-social-deux');
					$link = sprintf('http://www.pinterest.com/%s', UltimateSocialDeux::opt('us_pinterest_username', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "mailchimp":
					$desc = __('Subscribers', 'ultimate-social-deux');
					$link = sprintf('%s', UltimateSocialDeux::opt('us_mailchimp_link', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "flickr":
					$desc = __('Members', 'ultimate-social-deux');
					$link = sprintf('https://www.flickr.com/groups/%s/', UltimateSocialDeux::opt('us_flickr_id', ''));
					$output .= self::counter($network, $count, $desc, $rows, $link);
				break;
				case "members":
					$count = UltimateSocialDeux::number_format( self::members_count() );
					$desc = __('Members', 'ultimate-social-deux');
					$link = '';
					$output .= self::counter($network, $count, $desc, $rows, $link, 'false');
				break;
				case "posts":
					$count = UltimateSocialDeux::number_format( self::posts_count() );
					$desc = __('Posts', 'ultimate-social-deux');
					$link = '';
					$output .= self::counter($network, $count, $desc, $rows, $link, 'false');
				break;
				case "comments":
					$count = UltimateSocialDeux::number_format( self::comments_count() );
					$desc = __('Comments', 'ultimate-social-deux');
					$link = '';
					$output .= self::counter($network, $count, $desc, $rows, $link, 'false');
				break;
			}
		}

		$output .= '</div>';

		if ($us_fan_count_data) {
			self::update_count($us_fan_count_data);
		}

		return $output;
	}

	/**
	 * Return counter markup
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 markup
	 */
	public static function counter($network, $count, $desc, $rows, $link = '') {
		$no_link = ($link) ? '': ' us_no_link';
		$output = sprintf('<div class="us_fan_count rows-%s us_%s us_%s_fan_count%s" data-network="%s">', $rows, $network, $network, $no_link, $network);
			$output .= ($link) ? sprintf('<a href="%s" target="_blank" class="us_%s_fan_count_link">', $link, $network): '';
				$output .= sprintf('<div class="us_fan_count_button">', $network);
					$output .= '<div class="us_fan_count_icon_holder">';
						$output .= sprintf('<i class="us-icon-%s"></i>', $network);
					$output .= '</div>';
					$output .= '<div class="us_fan_count_holder">';
						$output .= $count;
					$output .= '</div>';
					$output .= '<div class="us_fan_count_desc">';
						$output .= $desc;
					$output .= '</div>';
				$output .= '</div>';
			$output .= ($link) ? sprintf('</a>', $link): '';
		$output .= '</div>';

		return $output;

	}

	/**
	 * Return Love count
	 *
	 * @since 	 4.0.0
	 *
	 * @return 	 count
	 */
	public static function love_count(){

		global $us_love_counts;

		$us_love_counts = (!isset($us_love_counts)) ? get_option('us_love_count', array()): $us_love_counts;

		$count = 0;

		if (isset($us_love_counts['data'])) {

			$options = $us_love_counts['data'];

			foreach ($options as &$option) {
				$c = $option['count'];
			    $count += $c;
			}

		}

		return $count;
	}

	/**
	 * Return post count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function posts_count() {
		$count_posts = wp_count_posts();
		$count = $count_posts->publish ;
		return $count;
	}

	/**
	 * Return comments count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function comments_count() {
		$comments_count = wp_count_comments() ;
		$count = $comments_count->approved ;
		return $count;
	}

	/**
	 * Return members count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 count
	 */
	public static function members_count() {
		$members_count = count_users() ;
		$count = $members_count['total_users'] ;
		return $count;
	}

	public static function ajax_count() {
		$array = array(
			'facebook' => true,
			'twitter' => true,
			'google' => true,
			'youtube' => true,
			'delicious' => true,
			'linkedin' => true,
			'behance' => true,
			'vimeo' => true,
			'dribbble' => true,
			'envato' => true,
			'github' => true,
			'soundcloud' => true,
			'instagram' => true,
			'vkontakte' => true,
			'feedpress' => true,
			'pinterest' => true,
			'mailchimp' => true,
			'flickr' => true
		);

		return $array;
	}

}
