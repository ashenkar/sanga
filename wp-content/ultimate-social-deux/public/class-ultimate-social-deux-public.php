<?php
/**
 * Ultimate Social Deux.
 *
 * @package		Ultimate Social Deux
 * @author		Ultimate WP <hello@ultimate-wp.com>
 * @link		http://social.ultimate-wp.com
 * @copyright 	2015 Ultimate WP
 */

class UltimateSocialDeux {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since	1.0.0
	 *
	 * @var	 string
	 */
	const VERSION = '1.0.0';

	/**
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since	1.0.0
	 *
	 * @var		string
	 */
	protected $plugin_slug = 'ultimate-social-deux';

	/**
	 * Instance of this class.
	 *
	 * @since	1.0.0
	 *
	 * @var		object
	 */
	protected static $instance = null;

	/**
	 * Return the plugin slug.
	 *
	 * @since	1.0.0
	 *
	 * @return	Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

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
	 * Load the plugin text domain for translation.
	 *
	 * @since	1.0.0
	 */
	public function load_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );

		load_textdomain( $domain, realpath(dirname(__FILE__) . '/..') . '/languages' . '/' . $domain . '-' . $locale . '.mo' );

	}

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since	 1.0.0
	 */
	private function __construct() {

		add_action( 'wp_head', array( $this, 'open_graph_tags' ), 1 );

		add_action( 'init', array( $this, 'load_textdomain' ) );

		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );

		add_action( 'wp_head', array( $this, 'buttons_string' ), 1 );

	}

	/**
	 * If trigger (query var) is tripped, load our pseudo-stylesheet
	 *
	 * We would prefer to esc $content at the very last moment, but we need to allow the > character.
	 *
	 * @since 1.3
	 */
	public static function custom_css() {

		$custom_css = self::opt('us_custom_css', '' );
		$floating_speed = self::opt('us_floating_speed', 1000);

		$hover_color = self::opt('us_hover_color', '#008000');
		$sticky_background = self::opt('us_sticky_background_color', '#ffffff');

		$content = '';

		$content .= sprintf(".us_sticky .us_wrapper { background-color:%s; }", $sticky_background);

		$content .= sprintf(".us_floating .us_wrapper .us_button { width: 45px; -webkit-transition: width %sms ease-in-out, background-color 400ms ease-out; -moz-transition: width %sms ease-in-out, background-color 400ms ease-out; -o-transition: width %sms ease-in-out, background-color 400ms ease-out; transition: width %sms ease-in-out, background-color 400ms ease-out; }", $floating_speed, $floating_speed, $floating_speed, $floating_speed );
		$content .= sprintf(".us_floating .us_wrapper .us_button:hover { width: 90px;-webkit-transition: width %sms ease-in-out, background-color 400ms ease-out; -moz-transition: width %sms ease-in-out, background-color 400ms ease-out; -o-transition: width %sms ease-in-out, background-color 400ms ease-out; transition: width %sms ease-in-out, background-color 400ms ease-out; }", $floating_speed, $floating_speed, $floating_speed, $floating_speed);

		$content .= sprintf(".us_facebook .us_share, .us_facebook { background-color:%s; }", self::opt('us_facebook_color', '#3b5998') );
		$content .= sprintf(".us_facebook:hover .us_share, .us_facebook:hover { background-color:%s; }", self::opt('us_facebook_color_hover', $hover_color) );
		$content .= sprintf(".us_twitter .us_share, .us_twitter { background-color:%s; }", self::opt('us_twitter_color', '#00ABF0') );
		$content .= sprintf(".us_twitter:hover .us_share, .us_twitter:hover { background-color:%s; }", self::opt('us_twitter_color_hover', $hover_color) );
		$content .= sprintf(".us_google .us_share, .us_google { background-color:%s; }", self::opt('us_googleplus_color', '#D95232') );
		$content .= sprintf(".us_google:hover .us_share, .us_google:hover { background-color:%s; }", self::opt('us_googleplus_color_hover', $hover_color) );
		$content .= sprintf(".us_delicious .us_share, .us_delicious { background-color:%s; }", self::opt('us_delicious_color', '#66B2FD') );
		$content .= sprintf(".us_delicious:hover .us_share, .us_delicious:hover { background-color:%s; }", self::opt('us_delicious_color_hover', $hover_color) );
		$content .= sprintf(".us_stumble .us_share, .us_stumble { background-color:%s; }", self::opt('us_stumble_color', '#E94B24') );
		$content .= sprintf(".us_stumble:hover .us_share, .us_stumble:hover { background-color:%s; }", self::opt('us_stumble_color_hover', $hover_color) );
		$content .= sprintf(".us_linkedin .us_share, .us_linkedin { background-color:%s; }", self::opt('us_linkedin_color', '#1C86BC') );
		$content .= sprintf(".us_linkedin:hover .us_share, .us_linkedin:hover { background-color:%s; }", self::opt('us_linkedin_color_hover', $hover_color) );
		$content .= sprintf(".us_pinterest .us_share, .us_pinterest { background-color:%s; }", self::opt('us_pinterest_color', '#AE181F') );
		$content .= sprintf(".us_pinterest:hover .us_share, .us_pinterest:hover { background-color:%s; }", self::opt('us_pinterest_color_hover', $hover_color) );
		$content .= sprintf(".us_buffer .us_share, .us_buffer { background-color:%s; }", self::opt('us_buffer_color', '#000000') );
		$content .= sprintf(".us_buffer:hover .us_share, .us_buffer:hover { background-color:%s; }", self::opt('us_buffer_color_hover', $hover_color) );
		$content .= sprintf(".us_reddit .us_share, .us_reddit { background-color:%s; }", self::opt('us_reddit_color', '#CEE3F8') );
		$content .= sprintf(".us_reddit:hover .us_share, .us_reddit:hover { background-color:%s; }", self::opt('us_reddit_color_hover', $hover_color) );
		$content .= sprintf(".us_vkontakte .us_share, .us_vkontakte { background-color:%s; }", self::opt('us_vkontakte_color', '#537599') );
		$content .= sprintf(".us_vkontakte:hover .us_share, .us_vkontakte:hover { background-color:%s; }", self::opt('us_vkontakte_color_hover', $hover_color) );
		$content .= sprintf(".us_mail .us_share, .us_mail { background-color:%s; }", self::opt('us_mail_color', '#666666') );
		$content .= sprintf(".us_mail:hover .us_share, .us_mail:hover { background-color:%s; }", self::opt('us_mail_color_hover', $hover_color) );
		$content .= sprintf(".us_love .us_share,.us_love { background-color:%s; }", self::opt('us_love_color', '#FF0000') );
		$content .= sprintf(".us_love:hover .us_share, .us_love:hover { background-color:%s; }", self::opt('us_love_color_hover', $hover_color) );
		$content .= sprintf(".us_pocket .us_share, .us_pocket { background-color:%s; }", self::opt('us_pocket_color', '#ee4056') );
		$content .= sprintf(".us_pocket:hover .us_share, .us_pocket:hover { background-color:%s; }", self::opt('us_pocket_color_hover', $hover_color) );
		$content .= sprintf(".us_tumblr .us_share, .us_tumblr { background-color:%s; }", self::opt('us_tumblr_color', '#529ecc') );
		$content .= sprintf(".us_tumblr:hover .us_share, .us_tumblr:hover { background-color:%s; }", self::opt('us_tumblr_color_hover', $hover_color) );
		$content .= sprintf(".us_print .us_share, .us_print { background-color:%s; }", self::opt('us_print_color', '#60d0d4') );
		$content .= sprintf(".us_print:hover .us_share, .us_print:hover { background-color:%s; }", self::opt('us_print_color_hover', $hover_color) );
		$content .= sprintf(".us_flipboard .us_share, .us_flipboard { background-color:%s; }", self::opt('us_flipboard_color', '#c10000') );
		$content .= sprintf(".us_flipboard:hover .us_share, .us_flipboard:hover { background-color:%s; }", self::opt('us_flipboard_color_hover', $hover_color) );
		$content .= sprintf(".us_comments .us_share, .us_comments { background-color:%s; }", self::opt('us_comments_color', '#b69823') );
		$content .= sprintf(".us_comments:hover .us_share, .us_comments:hover { background-color:%s; }", self::opt('us_comments_color_hover', $hover_color) );
		$content .= sprintf(".us_feedly .us_share, .us_feedly { background-color:%s; }", self::opt('us_feedly_color', '#414141') );
		$content .= sprintf(".us_feedly:hover .us_share, .us_feedly:hover { background-color:%s; }", self::opt('us_feedly_color_hover', $hover_color) );
		$content .= sprintf(".us_youtube:hover { background-color:%s; }", self::opt('us_youtube_color_hover', $hover_color) );
		$content .= sprintf(".us_youtube { background-color:%s; }", self::opt('us_youtube_color', '#cc181e') );
		$content .= sprintf(".us_vimeo { background-color:%s; }", self::opt('us_vimeo_color', '#1bb6ec') );
		$content .= sprintf(".us_vimeo:hover { background-color:%s; }", self::opt('us_vimeo_color_hover', $hover_color) );
		$content .= sprintf(".us_behance { background-color:%s; }", self::opt('us_behance_color', '#1769ff') );
		$content .= sprintf(".us_behance:hover { background-color:%s; }", self::opt('us_behance_color_hover', $hover_color) );
		$content .= sprintf(".us_ok .us_share, .us_ok { background-color:%s; }", self::opt('us_ok_color', '#f2720c') );
		$content .= sprintf(".us_ok:hover .us_share, .us_ok:hover { background-color:%s; }", self::opt('us_ok_color_hover', $hover_color) );
		$content .= sprintf(".us_weibo .us_share, .us_weibo { background-color:%s; }", self::opt('us_weibo_color', '#e64141') );
		$content .= sprintf(".us_weibo:hover .us_share, .us_weibo:hover { background-color:%s; }", self::opt('us_weibo_color_hover', $hover_color) );
		$content .= sprintf(".us_managewp .us_share, .us_managewp { background-color:%s; }", self::opt('us_managewp_color', '#098ae0') );
		$content .= sprintf(".us_managewp:hover .us_share, .us_managewp:hover { background-color:%s; }", self::opt('us_managewp_color_hover', $hover_color) );
		$content .= sprintf(".us_xing .us_share, .us_xing { background-color:%s; }", self::opt('us_xing_color', '#026466') );
		$content .= sprintf(".us_xing:hover .us_share, .us_xing:hover { background-color:%s; }", self::opt('us_xing_color_hover', $hover_color) );
		$content .= sprintf(".us_whatsapp .us_share, .us_whatsapp { background-color:%s; }", self::opt('us_whatsapp_color', '#34af23') );
		$content .= sprintf(".us_whatsapp:hover .us_share, .us_whatsapp:hover { background-color:%s; }", self::opt('us_whatsapp_color_hover', $hover_color) );
		$content .= sprintf(".us_meneame .us_share, .us_meneame { background-color:%s; }", self::opt('us_meneame_color', '#ff6400') );
		$content .= sprintf(".us_meneame:hover .us_share, .us_meneame:hover { background-color:%s; }", self::opt('us_meneame_color_hover', $hover_color) );
		$content .= sprintf(".us_digg .us_share, .us_digg { background-color:%s; }", self::opt('us_digg_color', '#000') );
		$content .= sprintf(".us_digg:hover .us_share, .us_digg:hover { background-color:%s; }", self::opt('us_digg_color_hover', $hover_color) );
		$content .= sprintf(".us_dribbble { background-color:%s; }", self::opt('us_dribbble_color', '#f72b7f') );
		$content .= sprintf(".us_dribbble:hover { background-color:%s; }", self::opt('us_dribbble_color_hover', $hover_color) );
		$content .= sprintf(".us_envato { background-color:%s; }", self::opt('us_envato_color', '#82b540') );
		$content .= sprintf(".us_envato:hover { background-color:%s; }", self::opt('us_envato_color_hover', $hover_color) );
		$content .= sprintf(".us_github { background-color:%s; }", self::opt('us_github_color', '#201e1f') );
		$content .= sprintf(".us_github:hover { background-color:%s; }", self::opt('us_github_color_hover', $hover_color) );
		$content .= sprintf(".us_soundcloud { background-color:%s; }", self::opt('us_soundcloud_color', '#ff6f00') );
		$content .= sprintf(".us_soundcloud:hover { background-color:%s; }", self::opt('us_soundcloud_color_hover', $hover_color) );
		$content .= sprintf(".us_instagram { background-color:%s; }", self::opt('us_instagram_color', '#48769c') );
		$content .= sprintf(".us_instagram:hover { background-color:%s; }", self::opt('us_instagram_color_hover', $hover_color) );
		$content .= sprintf(".us_feedpress { background-color:%s; }", self::opt('us_feedpress_color', '#ffafaf') );
		$content .= sprintf(".us_feedpress:hover { background-color:%s; }", self::opt('us_feedpress_color_hover', $hover_color) );
		$content .= sprintf(".us_mailchimp { background-color:%s; }", self::opt('us_mailchimp_color', '#6dc5dc') );
		$content .= sprintf(".us_mailchimp:hover { background-color:%s; }", self::opt('us_mailchimp_color_hover', $hover_color) );
		$content .= sprintf(".us_flickr { background-color:%s; }", self::opt('us_flickr_color', '#0062dd') );
		$content .= sprintf(".us_flickr:hover { background-color:%s; }", self::opt('us_flickr_color_hover', $hover_color) );
		$content .= sprintf(".us_members { background-color:%s; }", self::opt('us_members_color', '#0ab071') );
		$content .= sprintf(".us_members:hover { background-color:%s; }", self::opt('us_members_color_hover', $hover_color) );
		$content .= sprintf(".us_more, .us_more .us_share { background-color:%s; }", self::opt('us_more_color', '#53B27C') );
		$content .= sprintf(".us_more:hover, .us_more:hover .us_share { background-color:%s; }", self::opt('us_more_color_hover', $hover_color) );
		$content .= sprintf(".us_posts { background-color:%s; }", self::opt('us_posts_color', '#924e2a') );
		$content .= sprintf(".us_posts:hover { background-color:%s; }", self::opt('us_posts_color_hover', $hover_color) );

		$content .= sprintf(".us_facebook a { color:%s; }", self::opt('us_facebook_color', '#3b5998') );
		$content .= sprintf(".us_facebook a:hover { color:%s; }", self::opt('us_facebook_color_hover', $hover_color) );
		$content .= sprintf(".us_twitter a { color:%s; }", self::opt('us_twitter_color', '#00ABF0') );
		$content .= sprintf(".us_twitter a:hover { color:%s; }", self::opt('us_twitter_color_hover', $hover_color) );
		$content .= sprintf(".us_google a { color:%s; }", self::opt('us_googleplus_color', '#D95232') );
		$content .= sprintf(".us_google a:hover { color:%s; }", self::opt('us_googleplus_color_hover', $hover_color) );
		$content .= sprintf(".us_delicious a { color:%s; }", self::opt('us_delicious_color', '#66B2FD') );
		$content .= sprintf(".us_delicious a:hover { color:%s; }", self::opt('us_delicious_color_hover', $hover_color) );
		$content .= sprintf(".us_stumble a { color:%s; }", self::opt('us_stumble_color', '#E94B24') );
		$content .= sprintf(".us_stumble a:hover { color:%s; }", self::opt('us_stumble_color_hover', $hover_color) );
		$content .= sprintf(".us_linkedin a { color:%s; }", self::opt('us_linkedin_color', '#1C86BC') );
		$content .= sprintf(".us_linkedin a:hover { color:%s; }", self::opt('us_linkedin_color_hover', $hover_color) );
		$content .= sprintf(".us_pinterest a { color:%s; }", self::opt('us_pinterest_color', '#AE181F') );
		$content .= sprintf(".us_pinterest a:hover { color:%s; }", self::opt('us_pinterest_color_hover', $hover_color) );
		$content .= sprintf(".us_buffer a { color:%s; }", self::opt('us_buffer_color', '#000000') );
		$content .= sprintf(".us_buffer a:hover { color:%s; }", self::opt('us_buffer_color_hover', $hover_color) );
		$content .= sprintf(".us_reddit a { color:%s; }", self::opt('us_reddit_color', '#CEE3F8') );
		$content .= sprintf(".us_reddit a:hover { color:%s; }", self::opt('us_reddit_color_hover', $hover_color) );
		$content .= sprintf(".us_vkontakte a { color:%s; }", self::opt('us_vkontakte_color', '#537599') );
		$content .= sprintf(".us_vkontakte a:hover { color:%s; }", self::opt('us_vkontakte_color_hover', $hover_color) );
		$content .= sprintf(".us_mail a { color:%s; }", self::opt('us_mail_color', '#666666') );
		$content .= sprintf(".us_mail a:hover { color:%s; }", self::opt('us_mail_color_hover', $hover_color) );
		$content .= sprintf(".us_love a, .us_love { color:%s; }", self::opt('us_love_color', '#FF0000') );
		$content .= sprintf(".us_love a:hover, .us_love:hover { color:%s; }", self::opt('us_love_color_hover', $hover_color) );
		$content .= sprintf(".us_pocket a { color:%s; }", self::opt('us_pocket_color', '#ee4056') );
		$content .= sprintf(".us_pocket a:hover { color:%s; }", self::opt('us_pocket_color_hover', $hover_color) );
		$content .= sprintf(".us_tumblr a { color:%s; }", self::opt('us_tumblr_color', '#529ecc') );
		$content .= sprintf(".us_tumblr a:hover { color:%s; }", self::opt('us_tumblr_color_hover', $hover_color) );
		$content .= sprintf(".us_print a { color:%s; }", self::opt('us_print_color', '#60d0d4') );
		$content .= sprintf(".us_print a:hover { color:%s; }", self::opt('us_print_color_hover', $hover_color) );
		$content .= sprintf(".us_flipboard a { color:%s; }", self::opt('us_flipboard_color', '#c10000') );
		$content .= sprintf(".us_flipboard a:hover { color:%s; }", self::opt('us_flipboard_color_hover', $hover_color) );
		$content .= sprintf(".us_comments a, .us_comments { color:%s; }", self::opt('us_comments_color', '#b69823') );
		$content .= sprintf(".us_comments a:hover, .us_comments:hover { color:%s; }", self::opt('us_comments_color_hover', $hover_color) );
		$content .= sprintf(".us_feedly a { color:%s; }", self::opt('us_feedly_color', '#414141') );
		$content .= sprintf(".us_feedly a:hover { color:%s; }", self::opt('us_feedly_color_hover', $hover_color) );
		$content .= sprintf(".us_youtube a { color:%s; }", self::opt('us_youtube_color', '#cc181e') );
		$content .= sprintf(".us_youtube a:hover { color:%s; }", self::opt('us_youtube_color_hover', $hover_color) );
		$content .= sprintf(".us_vimeo a { color:%s; }", self::opt('us_vimeo_color', '#1bb6ec') );
		$content .= sprintf(".us_vimeo a:hover { color:%s; }", self::opt('us_vimeo_color_hover', $hover_color) );
		$content .= sprintf(".us_behance a { color:%s; }", self::opt('us_behance_color', '#1769ff') );
		$content .= sprintf(".us_behance a:hover { color:%s; }", self::opt('us_behance_color_hover', $hover_color) );
		$content .= sprintf(".us_ok a { color:%s; }", self::opt('us_ok_color', '#f2720c') );
		$content .= sprintf(".us_ok a:hover { color:%s; }", self::opt('us_ok_color_hover', $hover_color) );
		$content .= sprintf(".us_weibo a { color:%s; }", self::opt('us_weibo_color', '#e64141') );
		$content .= sprintf(".us_weibo a:hover { color:%s; }", self::opt('us_weibo_color_hover', $hover_color) );
		$content .= sprintf(".us_managewp a { color:%s; }", self::opt('us_managewp_color', '#098ae0') );
		$content .= sprintf(".us_managewp a:hover { color:%s; }", self::opt('us_managewp_color_hover', $hover_color) );
		$content .= sprintf(".us_xing a { color:%s; }", self::opt('us_xing_color', '#026466') );
		$content .= sprintf(".us_xing a:hover { color:%s; }", self::opt('us_xing_color_hover', $hover_color) );
		$content .= sprintf(".us_whatsapp a { color:%s; }", self::opt('us_whatsapp_color', '#34af23') );
		$content .= sprintf(".us_whatsapp a:hover { color:%s; }", self::opt('us_whatsapp_color_hover', $hover_color) );
		$content .= sprintf(".us_meneame a { color:%s; }", self::opt('us_meneame_color', '#ff6400') );
		$content .= sprintf(".us_meneame a:hover { color:%s; }", self::opt('us_meneame_color_hover', $hover_color) );
		$content .= sprintf(".us_digg a { color:%s; }", self::opt('us_digg_color', '#000') );
		$content .= sprintf(".us_digg a:hover { color:%s; }", self::opt('us_digg_colort_hover', $hover_color) );
		$content .= sprintf(".us_dribbble a{ color:%s; }", self::opt('us_dribbble_color', '#f72b7f') );
		$content .= sprintf(".us_dribbble a:hover{ color:%s; }", self::opt('us_dribbble_color_hover', $hover_color) );
		$content .= sprintf(".us_envato a { color:%s; }", self::opt('us_envato_color', '#82b540') );
		$content .= sprintf(".us_envato a:hover { color:%s; }", self::opt('us_envato_color_hover', $hover_color) );
		$content .= sprintf(".us_github a { color:%s; }", self::opt('us_github_color', '#201e1f') );
		$content .= sprintf(".us_github a:hover { color:%s; }", self::opt('us_github_color_hover', $hover_color) );
		$content .= sprintf(".us_soundcloud a { color:%s; }", self::opt('us_soundcloud_color', '#ff6f00') );
		$content .= sprintf(".us_soundcloud a:hover { color:%s; }", self::opt('us_soundcloud_color_hover', $hover_color) );
		$content .= sprintf(".us_instagram a { color:%s; }", self::opt('us_instagram_color', '#48769c') );
		$content .= sprintf(".us_instagram a:hover { color:%s; }", self::opt('us_instagram_color_hover', $hover_color) );
		$content .= sprintf(".us_feedpress { color:%s; }", self::opt('us_feedpress_color', '#ffafaf') );
		$content .= sprintf(".us_feedpress:hover { color:%s; }", self::opt('us_feedpress_color_hover', $hover_color) );
		$content .= sprintf(".us_mailchimp { color:%s; }", self::opt('us_mailchimp_color', '#6dc5dc') );
		$content .= sprintf(".us_mailchimp:hover { color:%s; }", self::opt('us_mailchimp_color_hover', $hover_color) );
		$content .= sprintf(".us_flickr a { color:%s; }", self::opt('us_flickr_color', '#0062dd') );
		$content .= sprintf(".us_flickr a:hover { color:%s; }", self::opt('us_flickr_color_hover', $hover_color) );
		$content .= sprintf(".us_members { color:%s; }", self::opt('us_members_color', '#0ab071') );
		$content .= sprintf(".us_members:hover { color:%s; }", self::opt('us_members_color_hover', $hover_color) );
		$content .= sprintf(".us_more a { color:%s; }", self::opt('us_more_color', '#53B27C') );
		$content .= sprintf(".us_more a:hover { color:%s; }", self::opt('us_more_color_hover', $hover_color) );
		$content .= sprintf(".us_posts { color:%s; }", self::opt('us_posts_color', '#924e2a') );
		$content .= sprintf(".us_posts:hover { color:%s; }", self::opt('us_posts_colo_hoverr', $hover_color) );

		if ( $custom_css ) {
			$raw_content = isset( $custom_css ) ? $custom_css : '';
			$esc_content = esc_html( $raw_content );
			$content .= str_replace( '&gt;', '>', $esc_content );
		}

		$content = str_replace(' { ', '{', $content);
		$content = str_replace(' }', '}', $content);
		$content = str_replace(', .', ',.', $content);
		$content = str_replace(': ', ':', $content);
		$content = str_replace('; ', ';', $content);
		$content = str_replace(', ', ',', $content);

		return $content;
	}

	/**
	* Register and enqueue public-facing style sheet.
	*
	* @since	1.0.0
	*/
	public function register_styles() {
		wp_register_style( 'us-plugin-styles', plugins_url( 'assets/css/style.css', __FILE__ ), array(), ULTIMATE_SOCIAL_DEUX_VERSION );
		if (self::opt('us_enqueue', 'all_pages') == 'all_pages') {
			self::enqueue_stuff();
		}
	}

	/**
	* Register and enqueues public-facing JavaScript files.
	*
	* @since	1.0.0
	*/
	public function register_scripts() {

		$minified = self::opt('us_minified', true);

		$minified_path = ( $minified ) ? 'min/': '';
		$minified_file = ( $minified ) ? '-min': '';

		wp_register_script( 'us-script', plugins_url( 'assets/js/'.$minified_path.'us.script'.$minified_file.'.js',__FILE__ ), array('jquery'), ULTIMATE_SOCIAL_DEUX_VERSION );
		wp_register_script( 'jquery-cookie', plugins_url( 'assets/js/'.$minified_path.'jquery.cookie'.$minified_file.'.js',__FILE__ ), array('jquery'), '1.0' );
		wp_register_script( 'us-native', plugins_url( 'assets/js/'.$minified_path.'us.native'.$minified_file.'.js',__FILE__ ), array(), ULTIMATE_SOCIAL_DEUX_VERSION );
		wp_register_script( 'jquery-magnific-popup', plugins_url( 'assets/js/'.$minified_path.'jquery.magnific-popup'.$minified_file.'.js',__FILE__ ), array('jquery'), '1.0' );
		wp_register_script( 'jquery-sticky', plugins_url( 'assets/js/'.$minified_path.'jquery.sticky'.$minified_file.'.js',__FILE__ ), array('jquery'), '1.0' );
		wp_register_script( 'jquery-fittext', plugins_url( 'assets/js/'.$minified_path.'jquery.fittext'.$minified_file.'.js',__FILE__ ), array('jquery'), '1.2' );

		wp_localize_script( 'us-script', 'us_script',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'tweet_via' => self::opt('us_tweet_via', ''),
				'sharrre_url' => admin_url( 'admin-ajax.php' ),
				'success' => self::opt('us_mail_success', __('Great work! Your message was sent.', 'ultimate-social-deux' ) ),
				'trying' => self::opt('us_mail_try', __('Trying to send email...', 'ultimate-social-deux' ) ),
				'total_shares_text' => self::opt('us_total_shares_text', __( 'Shares', 'ultimate-social-deux' ) ),
				'facebook_height' => intval(self::opt('us_facebook_height', '500' ) ),
				'facebook_width' => intval(self::opt('us_facebook_width', '900' ) ),
				'twitter_height' => intval(self::opt('us_twitter_height', '500' ) ),
				'twitter_width' => intval(self::opt('us_twitter_width', '900' ) ),
				'googleplus_height' => intval(self::opt('us_googleplus_height', '500') ),
				'googleplus_width' => intval(self::opt('us_googleplus_width', '900') ),
				'delicious_height' => intval(self::opt('us_delicious_height', '550') ),
				'delicious_width' => intval(self::opt('us_delicious_width', '550') ),
				'stumble_height' => intval(self::opt('us_stumble_height', '550') ),
				'stumble_width' => intval(self::opt('us_stumble_width', '550') ),
				'linkedin_height' => intval(self::opt('us_linkedin_height', '550') ),
				'linkedin_width' => intval(self::opt('us_linkedin_width', '550') ),
				'pinterest_height' => intval(self::opt('us_pinterest_height', '320') ),
				'pinterest_width' => intval(self::opt('us_pinterest_width', '720') ),
				'buffer_height' => intval(self::opt('us_buffer_height', '500' ) ),
				'buffer_width' => intval(self::opt('us_buffer_width', '900' ) ),
				'reddit_height' => intval(self::opt('us_reddit_height', '500' ) ),
				'reddit_width' => intval(self::opt('us_reddit_width', '900' ) ),
				'vkontakte_height' => intval(self::opt('us_vkontakte_height', '500')),
				'vkontakte_width' => intval(self::opt('us_vkontakte_width', '900')),
				'printfriendly_height' => intval(self::opt('us_printfriendly_height', '500')),
				'printfriendly_width' => intval(self::opt('us_printfriendly_width', '1045')),
				'pocket_height' => intval(self::opt('us_pocket_height', '500')),
				'pocket_width' => intval(self::opt('us_pocket_width', '900')),
				'tumblr_height' => intval(self::opt('us_tumblr_height', '500')),
				'tumblr_width' => intval(self::opt('us_tumblr_width', '900')),
				'flipboard_height' => intval(self::opt('us_flipboard_height', '500')),
				'flipboard_width' => intval(self::opt('us_flipboard_width', '900')),
				'weibo_height' => intval(self::opt('us_weibo_height', '500')),
				'weibo_width' => intval(self::opt('us_weibo_width', '900')),
				'xing_height' => intval(self::opt('us_xing_height', '500')),
				'xing_width' => intval(self::opt('us_xing_width', '900')),
				'ok_height' => intval(self::opt('us_ok_height', '500')),
				'ok_width' => intval(self::opt('us_ok_width', '900')),
				'managewp_height' => intval(self::opt('us_managewp_height', '500')),
				'managewp_width' => intval(self::opt('us_managewp_width', '900')),
				'meneame_height' => intval(self::opt('us_meneame_height', '500')),
				'meneame_width' => intval(self::opt('us_meneame_width', '900')),
				'digg_height' => intval(self::opt('us_digg_height', '500')),
				'digg_width' => intval(self::opt('us_digg_width', '900')),
				'home_url' => home_url(),
				'nonce' => wp_create_nonce( 'us_nonce' ),
				'already_loved_message' => __( 'You have already loved this item.', 'ultimate-social-deux' ),
				'error_message' => __( 'Sorry, there was a problem processing your request.', 'ultimate-social-deux' ),
				'logged_in' => is_user_logged_in() ? 'true' : 'false',
				'bitly' => ( self::opt('us_bitly_access_token', '') ) ? 'true' : 'false',
			)
		);
		wp_localize_script( 'us-native', 'us_native_script',
			array(
				'vkontakte_appid' => self::opt('us_vkontakte_appid', ''),
				'facebook_appid' => self::opt('us_facebook_appid', ''),
			)
		);

	}

	/**
	* Enqueues public-facing JavaScript and CSS files.
	*
	* @since	1.0.0
	*/
	public static function enqueue_stuff() {

		if (self::opt('us_enqueue', 'all_pages') != 'manually') {
			wp_enqueue_style( 'us-plugin-styles' );
			wp_add_inline_style( 'us-plugin-styles', self::custom_css() );
			wp_enqueue_script( 'us-script' );
		}

	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since	1.0.0
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses
	 *										"Network Activate" action, false if
	 *										WPMU is disabled or plugin is
	 *										activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide	) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since	1.0.0
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses
	 *										"Network Deactivate" action, false if
	 *										WPMU is disabled or plugin is
	 *										deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
					self::single_deactivate();
			}

		} else {
				self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since	1.0.0
	 *
	 * @param	int	$blog_id	ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

			if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
					return;
			}

			switch_to_blog( $blog_id );
			self::single_activate();
			restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since	1.0.0
	 *
	 * @return	array|false	The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
				WHERE archived = '0' AND spam = '0'
				AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since	1.0.0
	 */
	private static function single_activate() {

		wp_cache_flush();

		if ( function_exists( 'w3tc_pgcache_flush' ) ) {
			w3tc_pgcache_flush();
		}
		if ( function_exists( 'w3tc_minify_flush' ) ) {
			w3tc_minify_flush();
		}

	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since	1.0.0
	 */
	private static function single_deactivate() {

		delete_option( 'us_fan_count_counters' );
		delete_transient( 'us_fan_count_counters' );

	}

	public static function opt_old( $option, $section, $default = '' ) {

		$options = get_option( $section );

		if ( isset( $options[$option] ) ) {
			return $options[$option];
		}

		return $default;
	}

	public static function opt( $option, $default = '' ) {

		global $us_options;

		if (!isset($us_options)) {
			$us_options = unserialize(get_option( "ultimate-social-deux_options" ) );
		}

		if ( isset($us_options[$option]) ) {
			return $us_options[$option];
		}

		return $default;
	}

	/**
	 * Replace strings for mail options
	 *
	 * @since	1.0.0
	 *
	 * @return	Replaced string
	 */
	public static function mail_replace_vars( $string, $url, $sender_name, $sender_email ) {

		if ( in_the_loop() || is_singular() ) {
			$post_title = get_the_title();
			$post_url = get_permalink();

			global $post;
			$post = get_post();
			$author_id=$post->post_author;
			$user_info = get_userdata($author_id);
			$post_author = $user_info->user_nicename;
		} elseif ( is_home() ) {
			$post_title = get_bloginfo('name');
			$post_url = get_bloginfo('url');
			$post_author = get_bloginfo('name');
		} else {
			$post_title = get_bloginfo('name');
			$post_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$post_author = get_bloginfo('name');
		}

		$post_url = ($url) ? $url: $post_url;

		$site_title = get_bloginfo('name');
		$site_url = get_bloginfo('url');

		$string = str_replace('{post_title}', $post_title, $string);
		$string = str_replace('{post_url}', $post_url, $string);
		$string = str_replace('{post_author}', $post_author, $string);
		$string = str_replace('{site_title}', $site_title, $string);
		$string = str_replace('{site_url}', $site_url, $string);
		$string = str_replace('{sender_name}', $sender_name, $string);
		$string = str_replace('{sender_email}', $sender_email, $string);

		return $string;
	}

	/**
	 * Returns first image of a post or page. If no images found it returns default image.
	 *
	 * @since	1.0.0
	 *
	 * @return	post image
	 */
	public static function catch_first_image($url = '', $post_id) {

		$post = ( get_post($post_id) ) ? get_post($post_id): get_page($post_id);

		$first_img = '';

		$post_content = $post->post_content;

		if ( $post_id ) {
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $matches);

			if ( has_post_thumbnail( $post_id ) ) {
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
				$url = $thumb['0'];

				$first_img = $url;
			} elseif (isset($matches[1][0])) {
				$first_img = $matches[1][0];
			}
		}

		if (!$post) return $first_img;
	}

	/**
	 * Returns random string.
	 *
	 * @since	1.0.0
	 *
	 * @return	random string
	 */
	public static function random_string($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	public function open_graph_tags() {

		global $post;

		$option = self::opt('us_open_graph', 'off');
		$fb_app_id = self::opt('us_facebook_appid', '');

		if ( $option === 'on' )  {

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

			$image = self::catch_first_image($url, $post_id);
			?>
				<meta property="og:title" content="<?php echo $title; ?>" />
				<meta property="og:type" content="article" />
				<meta property="og:image" content="<?php echo $image; ?>" />
				<meta property="og:url" content="<?php echo $url; ?>" />
				<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" />
			<?php

			if ($fb_app_id) {
				printf('<meta property="fb:app_id" content="%s" />', $fb_app_id);
			}
		}
	}

	/**
	 * Return readable count
	 *
	 * @since 	 1.0.0
	 *
	 * @return 	 readable number
	 */
	public static function number_format($n) {
		$n = intval($n);
		if($n>1000000000) return number_format(($n/1000000000),1).'B';
		elseif($n>1000000) return number_format(($n/1000000),1).'M';
		elseif($n>1000) return number_format(($n/1000),1).'k';

		return number_format($n);
	}

	public static function skins_array() {

		$array = array(
			'default' => __( 'Default', 'ultimate-social-deux' ),
			'simple' => __( 'Simple', 'ultimate-social-deux' ),
			'minimal' => __( 'Minimal', 'ultimate-social-deux' ),
			'modern' => __( 'Modern', 'ultimate-social-deux' ),
			'round' => __( 'Round', 'ultimate-social-deux' ),
			'jet' => __( 'Jet', 'ultimate-social-deux' ),
			'easy' => __( 'Easy', 'ultimate-social-deux' )
		);

		return $array;
	}

	public static function buttons_string() {
		$array = self::buttons_array();

		$buttons = '';

		foreach ($array as $button => $name) {
			$buttons .= $button.', ';
		}

		$buttons = substr($buttons, 0, -2);

		return $buttons;
	}

	public static function buttons_array() {

		$facebook = __('Facebook','ultimate-social-deux');
		$twitter = __('Twitter','ultimate-social-deux');
		$google = __('Google Plus','ultimate-social-deux');
		$pinterest = __('Pinterest','ultimate-social-deux');
		$linkedin = __('LinkedIn','ultimate-social-deux');
		$stumble = __('StumbleUpon','ultimate-social-deux');
		$delicious = __('Delicious','ultimate-social-deux');
		$buffer = __('Buffer','ultimate-social-deux');
		$reddit = __('Reddit','ultimate-social-deux');
		$vkontakte = __('VKontakte','ultimate-social-deux');
		$mail = __('Mail','ultimate-social-deux');

		$array = array(
			'total' => __( 'Total', 'ultimate-social-deux' ),
			'facebook' => $facebook,
			'facebook_native' => $facebook . ' ' . __( 'native', 'ultimate-social-deux' ),
			'twitter' => $twitter,
			'googleplus' => $google,
			'googleplus_native' => $google . ' ' . __( 'native', 'ultimate-social-deux' ),
			'pinterest' => $pinterest,
			'linkedin' => $linkedin,
			'stumble' => $stumble,
			'delicious' => $delicious,
			'buffer' => $buffer,
			'reddit' => $reddit,
			'vkontakte' => $vkontakte,
			'vkontakte_native' => $vkontakte . ' ' . __( 'native', 'ultimate-social-deux' ),
			'love' => __( 'Love', 'ultimate-social-deux' ),
			'pocket' => __( 'Pocket', 'ultimate-social-deux' ),
			'ok' => __( 'Odnoklassniki', 'ultimate-social-deux' ),
			'weibo' => __( 'Weibo', 'ultimate-social-deux' ),
			'managewp' => __( 'ManageWP', 'ultimate-social-deux' ),
			'xing' => __( 'Xing', 'ultimate-social-deux' ),
			'whatsapp' => __( 'WhatsApp', 'ultimate-social-deux' ),
			'meneame' => __( 'Meneame', 'ultimate-social-deux' ),
			'digg' => __( 'Digg', 'ultimate-social-deux' ),
			'flipboard' => __( 'Flipboard', 'ultimate-social-deux' ),
			'tumblr' => __( 'Tumblr', 'ultimate-social-deux' ),
			'print' => __( 'Printfriendly', 'ultimate-social-deux' ),
			'mail' => $mail,
			'comments' => __( 'Comments', 'ultimate-social-deux' ),
			'more' => __( 'More - Buttons after this will be hidden', 'ultimate-social-deux' ),
			'more_end' => __( 'More - Buttons after this will be visible', 'ultimate-social-deux' ),
			'names' => __( 'Names - Buttons after this will have names', 'ultimate-social-deux' ),
			'names_end' => __( 'Names - Buttons after this will not have names', 'ultimate-social-deux' ),

		);

		return $array;
	}

}
