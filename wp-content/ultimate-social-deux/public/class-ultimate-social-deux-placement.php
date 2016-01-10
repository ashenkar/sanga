<?php
/**
 * Ultimate Social Deux.
 *
 * @package		Ultimate Social Deux
 * @author		Ultimate WP <hello@ultimate-wp.com>
 * @link		http://social.ultimate-wp.com
 * @copyright 	2015 Ultimate WP
 */

class UltimateSocialDeuxPlacement {

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
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since	 1.0.0
	 */
	private function __construct() {

		add_filter( 'the_content', array( $this, 'the_content'), 15 );

		add_filter( 'the_excerpt', array( $this, 'the_excerpt') );

		add_filter( 'get_the_excerpt', array( $this, 'get_the_excerpt') );

		add_action( 'wp_head', array( $this, 'buttons_floating' ) );

		if (class_exists('Woocommerce')) {
			add_action( 'woocommerce_single_product_summary', array( $this, 'woocommerce_top' ), 1 );
			add_action( 'woocommerce_single_product_summary', array( $this, 'woocommerce_bottom' ), 50 );
		}

		if (class_exists('IT_Exchange')) {
			add_action( 'it_exchange_content_product_before_base_price_element', array( $this, 'exchange_top' ) );
			add_action( 'it_exchange_content_product_after_super_widget_element', array( $this, 'exchange_bottom' ), 99 );
		}

		if (class_exists('Jigoshop')) {
			add_action( 'jigoshop_before_single_product_summary', array( $this, 'jigoshop_top' ) );
			add_action( 'jigoshop_template_single_summary', array( $this, 'jigoshop_bottom' ), 100 );
		}

		if (class_exists('Easy_Digital_Downloads')) {
			add_action( 'edd_before_download_content', array( $this, 'buttons_edd_bottom') );
			add_action( 'edd_after_download_content', array( $this, 'buttons_edd_top') );
		}

		if (class_exists('bbPress')) {
			add_action ( 'bbp_template_before_replies_loop', array ($this, 'bbpress_before_replies' ) );
			add_action ( 'bbp_template_after_replies_loop', array ($this, 'bbpress_after_replies' ) );
			add_action ( 'bbp_template_before_topics_loop', array ($this, 'bbpress_before_topics' ) );
			add_action ( 'bbp_template_after_topics_loop', array ($this, 'bbpress_after_topics' ) );
		}

		if (class_exists('BuddyPress')) {
			add_action ( 'bp_before_group_home_content', array ($this, 'buddypress_group' ) );
			add_action ( 'bp_activity_entry_meta', array ($this, 'buddypress_activity' ), 999 );
		}

	}

	public function the_content($content) {

		if(in_array('get_the_excerpt', $GLOBALS['wp_current_filter'])) return $content;

		if (!is_feed()) {
			$content = self::buttons_posts_top() . $content . self::buttons_posts_bottom();

			$content = self::buttons_pages_top() . $content . self::buttons_pages_bottom();

			$content = self::buttons_cpt_top() . $content . self::buttons_cpt_bottom();
		}

		return $content;

	}

	public function the_excerpt($content) {

		if( !is_feed() ) {

			global $post;

			$content = self::buttons_excerpts_top() . $content . self::buttons_excerpts_bottom();

		}

		return $content;

	}

	public function get_the_excerpt($content) {

		return $content;

	}

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
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_posts_top() {

		global $post;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_posts_top_buttons'));

		$options = maybe_unserialize(UltimateSocialDeux::opt('us_posts_top_options'));

		$hide_blogpage = ( in_array('hide_blogpage', $options ) ) ? true : '';
		$hide_archive = ( in_array('hide_archive', $options ) ) ? true : '';
		$hide_search = ( in_array('hide_search', $options ) ) ? true : '';

		$exclude = UltimateSocialDeux::opt('us_posts_top_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		$post_type = get_post_type( $post->ID );

		if( !( ( $hide_blogpage && is_home() ) || ( $hide_search && is_search() ) || ( $hide_archive && is_archive() ) ) && $post_type == 'post' && !in_array($post->ID, $exclude, false) && is_array($networks) && !empty($networks)  ) {

			$sharetext = UltimateSocialDeux::opt('us_posts_top_share_text');

			$sticky = ( in_array('sticky', $options ) ) ? true : '';

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$align = UltimateSocialDeux::opt('us_posts_top_align', 'center' );

			$skin = UltimateSocialDeux::opt('us_posts_top_skin');

			$margin_top = intval(UltimateSocialDeux::opt('us_posts_top_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_posts_top_margin_bottom', '0'));

			$custom_content = sprintf('<div class="us_posts_top" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			if ( !( is_home() || is_search() || is_archive() ) && $sticky ) {

				wp_enqueue_script( 'jquery-sticky' );

				$sticky_offset = intval(UltimateSocialDeux::opt('us_sticky_offset', 0));
				$sticky_get_width_from = UltimateSocialDeux::opt('us_sticky_get_width_from');
				$custom_content .= '
					<script type="text/javascript">
						jQuery(document).ready(function(){
							jQuery(".us_posts_top").sticky({
								topSpacing:'.$sticky_offset.',
								getWidthFrom: "'.$sticky_get_width_from.'",
								wrapperClassName: "us_sticky"
							});
						});
					</script>
				';
			}

			return $custom_content;

		}

	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_posts_bottom() {

		global $post;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_posts_bottom_buttons'));

		$options = maybe_unserialize(UltimateSocialDeux::opt('us_posts_bottom_options'));

		$exclude = UltimateSocialDeux::opt('us_posts_bottom_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		$hide_blogpage = ( in_array('hide_blogpage', $options ) ) ? true : '';
		$hide_archive = ( in_array('hide_archive', $options ) ) ? true : '';
		$hide_search = ( in_array('hide_search', $options ) ) ? true : '';

		$post_type = get_post_type( $post->ID );

		if( !( ( $hide_blogpage && is_home() ) || ( $hide_search && is_search() ) || ( $hide_archive && is_archive() ) ) && $post_type == 'post' && !in_array($post->ID, $exclude, false) && is_array($networks) && !empty($networks)  ) {

			$sharetext = UltimateSocialDeux::opt('us_posts_bottom_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$skin = UltimateSocialDeux::opt('us_posts_bottom_skin');

			$align = UltimateSocialDeux::opt('us_posts_bottom_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_posts_bottom_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_posts_bottom_margin_bottom', '0'));

			$custom_content = sprintf('<div class="us_posts_bottom" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			return $custom_content;

		}

	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_pages_top() {

		global $post;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_pages_top_buttons'));

		$exclude = UltimateSocialDeux::opt('us_pages_top_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		$post_type = get_post_type( $post->ID );

		if( !in_array($post->ID, $exclude, false) && $post_type == 'page' && is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_pages_top_options'));

			$sharetext = UltimateSocialDeux::opt('us_pages_top_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;
			$native = ( in_array('native', $options ) ) ? true : false;
			$sticky = ( in_array('sticky', $options ) ) ? true : '';

			$skin = UltimateSocialDeux::opt('us_pages_top_skin');

			$align = UltimateSocialDeux::opt('us_pages_top_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_pages_top_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_pages_top_margin_bottom', '0'));

			$custom_content= sprintf('<div class="us_pages_top" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			if ( $sticky ) {

				wp_enqueue_script( 'jquery-sticky' );

				$sticky_offset = intval(UltimateSocialDeux::opt('us_sticky_offset', 0));
				$sticky_get_width_from = UltimateSocialDeux::opt('us_sticky_get_width_from');
				$custom_content .= '
					<script type="text/javascript">
						jQuery(document).ready(function(){
							jQuery(".us_pages_top").sticky({
								topSpacing:'.$sticky_offset.',
								getWidthFrom: "'.$sticky_get_width_from.'",
								wrapperClassName: "us_sticky"
							});
						});
					</script>
				';
			}

			return $custom_content;

		}

	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_pages_bottom() {

		global $post;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_pages_bottom_buttons'));

		$exclude =UltimateSocialDeux::opt('us_pages_bottom_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		$post_type = get_post_type( $post->ID );

		if( !in_array($post->ID, $exclude, false) && $post_type == 'page' && is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_pages_bottom_options'));

			$sharetext = UltimateSocialDeux::opt('us_pages_bottom_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$skin = UltimateSocialDeux::opt('us_pages_bottom_skin');

			$align = UltimateSocialDeux::opt('us_pages_bottom_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_pages_bottom_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_pages_bottom_margin_bottom', '0'));

			$custom_content = sprintf('<div class="us_pages_bottom" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			return $custom_content;

		}


	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_floating() {

		global $wp_query;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_floating_buttons'));

		$options = maybe_unserialize(UltimateSocialDeux::opt('us_floating_options'));

		$hide_frontpage = ( in_array('hide_frontpage', $options) ) ? true : '';

		$hide_blogpage = ( in_array('hide_blogpage', $options ) ) ? true : '';

		$hide_posts = ( in_array('hide_posts', $options ) ) ? true : '';

		$hide_pages = ( in_array('hide_pages', $options ) ) ? true : '';

		$hide_archive = ( in_array('hide_archive', $options ) ) ? true : '';

		$hide_search = ( in_array('hide_search', $options ) ) ? true : '';

		$hide_mobile = ( in_array('hide_mobile', $options ) ) ? true : '';

		$hide_mobile_class = ( $hide_mobile ) ? ' us_mobile_hide' : '';

		$hide_desktop = ( in_array('hide_desktop', $options ) ) ? true : '';

		$hide_desktop_class = ( $hide_desktop ) ? ' us_desktop_hide' : '';

		$exclude = UltimateSocialDeux::opt('us_floating_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		$post_id = ( isset($wp_query->post) && isset( $wp_query->post->ID ) ) ? $wp_query->post->ID : 0;

		$post_type = get_post_type( $post_id );

		if ( !( ( $hide_frontpage && is_front_page() ) || ( $hide_posts && $post_type == 'post' && !is_home() ) || ( $hide_blogpage && is_home() ) || ( $hide_pages && $post_type == 'page' ) || ( $hide_mobile && wp_is_mobile() ) || ( $hide_search && is_search() ) || ( $hide_archive && is_archive() ) || is_404() ) && !in_array($post_id, $exclude, false) && is_array($networks) && !empty($networks) ) {

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$skin = UltimateSocialDeux::opt('us_floating_skin');

			$url = UltimateSocialDeux::opt('us_floating_url');

			$floating = sprintf('<div class="us_floating%s%s">', $hide_mobile_class, $hide_desktop_class);

				$floating .= UltimateSocialDeuxButtons::buttons('', $networks, $url, '', $count, $native, $skin);

			$floating .= '</div>';

			echo $floating;
		}

	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function woocommerce_top() {

		global $post;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_woocommerce_top_buttons'));

		$exclude = UltimateSocialDeux::opt('us_woocommerce_top_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		if( !in_array($post->ID, $exclude, false) && is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_woocommerce_top_options'));

			$sharetext = UltimateSocialDeux::opt('us_woocommerce_top_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$skin = UltimateSocialDeux::opt('us_woocommerce_top_skin');

			$align = UltimateSocialDeux::opt('us_woocommerce_top_align','center');

			$margin_top = intval(UltimateSocialDeux::opt('us_woocommerce_top_margin_top', '0'));

			$margin_bottom =intval(UltimateSocialDeux::opt('us_woocommerce_top_margin_bottom', '0'));

			$custom_content = sprintf('<div class="us_woocommerce_top" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			echo $custom_content;

		}

	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function woocommerce_bottom() {

		global $post;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_woocommerce_bottom_buttons'));

		$exclude = UltimateSocialDeux::opt('us_woocommerce_bottom_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		if( !in_array($post->ID, $exclude, false) && is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_woocommerce_bottom_options'));

			$sharetext = UltimateSocialDeux::opt('us_woocommerce_bottom_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$skin = UltimateSocialDeux::opt('us_woocommerce_bottom_skin');

			$align = UltimateSocialDeux::opt('us_woocommerce_bottom_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_woocommerce_bottom_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_woocommerce_bottom_margin_bottom', '0'));

			$custom_content = sprintf('<div class="us_woocommerce_bottom" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			echo $custom_content;

		}

	}

		/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function jigoshop_top() {

		global $post;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_jigoshop_top_buttons'));

		$exclude = UltimateSocialDeux::opt('us_jigoshop_top_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		if( !in_array($post->ID, $exclude, false) && is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_jigoshop_top_options'));

			$sharetext = UltimateSocialDeux::opt('us_jigoshop_top_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$skin = UltimateSocialDeux::opt('us_jigoshop_top_skin');

			$align = UltimateSocialDeux::opt('us_jigoshop_top_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_jigoshop_top_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_jigoshop_top_margin_bottom', '0'));

			$custom_content = sprintf('<div class="us_jigoshop_top" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			echo $custom_content;

		}

	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function jigoshop_bottom() {

		global $post;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_jigoshop_bottom_buttons'));

		if( !in_array($post->ID, $exclude, false) && is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_jigoshop_bottom_options'));

			$sharetext = UltimateSocialDeux::opt('us_jigoshop_bottom_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$skin = UltimateSocialDeux::opt('us_jigoshop_bottom_skin');

			$exclude = UltimateSocialDeux::opt('us_jigoshop_bottom_exclude');

			$exclude = explode(',', $exclude);

			$exclude = array_map('trim', $exclude);

			$align = UltimateSocialDeux::opt('us_jigoshop_bottom_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_jigoshop_bottom_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_jigoshop_bottom_margin_bottom', '0'));

			$custom_content = sprintf('<div class="us_jigoshop_bottom" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			echo $custom_content;
		}
	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function exchange_top() {

		global $post;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_exchange_top_buttons'));

		$exclude = UltimateSocialDeux::opt('us_exchange_top_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		if( !in_array($post->ID, $exclude, false) && is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_exchange_top_options'));

			$sharetext = UltimateSocialDeux::opt('us_exchange_top_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$skin = UltimateSocialDeux::opt('us_exchange_top_skin');

			$align = UltimateSocialDeux::opt('us_exchange_top_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_exchange_top_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_exchange_top_margin_bottom', '0'));

			$custom_content = sprintf('<div class="us_exchange_top" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			echo $custom_content;

		}

	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function exchange_bottom() {

		global $post;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_exchange_bottom_buttons'));

		$exclude = UltimateSocialDeux::opt('us_exchange_bottom_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		if( !in_array($post->ID, $exclude, false) && is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_exchange_bottom_options'));

			$sharetext = UltimateSocialDeux::opt('us_exchange_bottom_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$skin = UltimateSocialDeux::opt('us_exchange_bottom_skin');

			$align = UltimateSocialDeux::opt('us_exchange_bottom_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_exchange_bottom_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_exchange_bottom_margin_bottom', '0'));

			$custom_content = sprintf('<div class="us_exchange_bottom" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			echo $custom_content;
		}
	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_edd_top() {

		global $post;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_edd_top_buttons'));

		$exclude = UltimateSocialDeux::opt('us_edd_top_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		if( !in_array($post->ID, $exclude, false) && is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_edd_top_options'));

			$sharetext = UltimateSocialDeux::opt('us_edd_top_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$skin = UltimateSocialDeux::opt('us_edd_top_skin');

			$align = UltimateSocialDeux::opt('us_edd_top_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_edd_top_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_edd_top_margin_bottom', '0'));

			$custom_content = sprintf('<div class="us_edd_top" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			echo $custom_content;

		}

	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_edd_bottom( $content ) {

		global $post;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_edd_bottom_buttons'));

		$exclude = UltimateSocialDeux::opt('us_edd_bottom_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		if( !in_array($post->ID, $exclude, false) && is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_edd_bottom_options'));

			$sharetext = UltimateSocialDeux::opt('us_edd_bottom_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$skin = UltimateSocialDeux::opt('us_edd_bottom_skin');

			$align = UltimateSocialDeux::opt('us_edd_bottom_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_edd_bottom_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_edd_bottom_margin_bottom', '0'));

			$custom_content = sprintf('<div class="us_edd_bottom" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			echo $custom_content;

		}

	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_excerpts_top() {

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_excerpts_top_buttons'));

		global $post;

		$exclude = UltimateSocialDeux::opt('us_excerpts_top_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		if( !in_array($post->ID, $exclude, false) && is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_excerpts_top_options'));

			$sharetext = UltimateSocialDeux::opt('us_excerpts_top_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$skin = UltimateSocialDeux::opt('us_excerpts_top_skin');

			$align = UltimateSocialDeux::opt('us_excerpts_top_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_excerpts_top_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_excerpts_top_margin_bottom', '0'));

			$custom_content = sprintf('<div class="us_excerpts_top" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			return $custom_content;
		}

	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_excerpts_bottom() {

		global $post;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_excerpts_bottom'));

		$exclude = UltimateSocialDeux::opt('us_excerpts_bottom_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		if( !in_array($post->ID, $exclude, false) &&  is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_excerpts_bottom_options'));

			$sharetext = UltimateSocialDeux::opt('us_excerpts_bottom_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$skin = UltimateSocialDeux::opt('us_excerpts_bottom_skin');

			$align = UltimateSocialDeux::opt('us_excerpts_bottom_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_excerpts_bottom_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_excerpts_bottom_margin_bottom', '0'));

			$custom_content = sprintf('<div class="us_excerpts_bottom" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			return $custom_content;

		}

	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_cpt_top () {

		global $post;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_cpt_top_buttons'));

		$options = maybe_unserialize(UltimateSocialDeux::opt('us_cpt_top_options'));

		$exclude = UltimateSocialDeux::opt('us_cpt_top_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		$cpt = UltimateSocialDeux::opt('us_cpt_top_cpt', array());

		$cpt = explode(',', $cpt);

		$cpt = array_map('trim', $cpt);

		if( !in_array($post->ID, $exclude, false) && in_array(get_post_type( $post->ID ), $cpt, false) && is_array($networks) && !empty($networks) ) {

			$sharetext = UltimateSocialDeux::opt('us_cpt_top_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$skin = UltimateSocialDeux::opt('us_cpt_top_skin');

			$align = UltimateSocialDeux::opt('us_cpt_top_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_cpt_top_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_cpt_top_margin_bottom', '0'));

			$custom_content = sprintf('<div class="us_cpt_top" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			return $custom_content;

		}

	}

	/**
	 * Returns social buttons.
	 *
	 * @since	1.0.0
	 *
	 * @return	buttons
	 */
	public function buttons_cpt_bottom() {

		global $post;

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_cpt_bottom_buttons'));

		$exclude = UltimateSocialDeux::opt('us_cpt_bottom_exclude');

		$exclude = explode(',', $exclude);

		$exclude = array_map('trim', $exclude);

		$cpt = UltimateSocialDeux::opt('us_cpt_bottom_cpt', array());

		$cpt = explode(',', $cpt);

		$cpt = array_map('trim', $cpt);

		if( !in_array($post->ID, $exclude, false) && in_array(get_post_type( $post->ID ), $cpt, false) && is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_cpt_bottom_options'));

			$sharetext = UltimateSocialDeux::opt('us_cpt_bottom_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$skin = UltimateSocialDeux::opt('us_cpt_bottom_skin');

			$align = UltimateSocialDeux::opt('us_cpt_bottom_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_cpt_bottom_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_cpt_bottom_margin_bottom', '0'));

			$custom_content = sprintf('<div class="us_cpt_bottom" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			return $custom_content;

		}

	}

	/**
	 * Returns social buttons.
	 *
	 * @since	4.0.0
	 *
	 * @return	buttons
	 */
	public function buddypress_group() {

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_buddypress_top_buttons'));

		if( is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_buddypress_top_options'));

			$sharetext = UltimateSocialDeux::opt('us_buddypress_top_share_text');

			$count = ( !is_string($options) && in_array('hide_count', $options ) ) ? false : true;

			$native = ( !is_string($options) && in_array('native', $options ) ) ? true : false;

			$group = groups_get_group( array( 'group_id' => bp_get_group_id() ) );

			$group_permalink = trailingslashit( bp_get_root_domain() . '/' . bp_get_groups_root_slug() . '/' . $group->slug . '/' );

			$url = $group_permalink;

			$align = UltimateSocialDeux::opt('us_buddypress_top_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_buddypress_top_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_buddypress_top_margin_bottom', '0'));

			$skin = UltimateSocialDeux::opt('us_buddypress_top_skin');

			$custom_content = sprintf('<div class="us_buddypress_group" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, $url, $align, $count, $native, $skin);

			$custom_content .= '</div>';

			echo $custom_content;
		}
	}

	/**
	 * Returns social buttons.
	 *
	 * @since	4.0.0
	 *
	 * @return	buttons
	 */
	public function buddypress_activity() {

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_buddypress_activity_buttons'));

		if( is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_buddypress_activity_options'));

			$sharetext = UltimateSocialDeux::opt('us_buddypress_activity_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$url = bp_activity_get_permalink(bp_get_activity_id());

			$align = UltimateSocialDeux::opt('us_buddypress_activity_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_buddypress_activity_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_buddypress_activity_margin_bottom', '0'));

			$skin = UltimateSocialDeux::opt('us_buddypress_activity_skin');

			$custom_content = sprintf('<div class="us_buddypress_activity" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, $url, $align, $count, $native, $skin);

			$custom_content .= '</div>';

			echo $custom_content;
		}
	}

	/**
	 * Returns social buttons.
	 *
	 * @since	4.0.0
	 *
	 * @return	buttons
	 */
	public function bbpress_before_replies() {

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_bbpress_before_replies_buttons'));

		if( is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_bbpress_before_replies_options'));

			$sharetext = UltimateSocialDeux::opt('us_bbpress_before_replies_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$align = UltimateSocialDeux::opt('us_bbpress_before_replies_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_bbpress_before_replies_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_bbpress_before_replies_margin_bottom', '0'));

			$skin = UltimateSocialDeux::opt('us_bbpress_before_replies_skin');

			$custom_content = sprintf('<div class="us_bbpress_before_replies" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			echo $custom_content;
		}
	}

	/**
	 * Returns social buttons.
	 *
	 * @since	4.0.0
	 *
	 * @return	buttons
	 */
	public function bbpress_after_replies() {

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_bbpress_after_replies_buttons'));

		if( is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_bbpress_after_replies_options'));

			$sharetext = UltimateSocialDeux::opt('us_bbpress_after_replies_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$align = UltimateSocialDeux::opt('us_bbpress_after_replies_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_bbpress_after_replies_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_bbpress_after_replies_margin_bottom', '0'));

			$skin = UltimateSocialDeux::opt('us_bbpress_after_replies_skin');

			$custom_content = sprintf('<div class="us_bbpress_after_replies" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			echo $custom_content;
		}
	}

	/**
	 * Returns social buttons.
	 *
	 * @since	4.0.0
	 *
	 * @return	buttons
	 */
	public function bbpress_before_topics() {

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_bbpress_before_topics_buttons'));

		if( is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_bbpress_before_topics_options'));

			$sharetext = UltimateSocialDeux::opt('us_bbpress_before_topics_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$align = UltimateSocialDeux::opt('us_bbpress_before_topics_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_bbpress_before_topics_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_bbpress_before_topics_margin_bottom', '0'));

			$skin = UltimateSocialDeux::opt('us_bbpress_before_topics_skin');

			$custom_content = sprintf('<div class="us_bbpress_before_topics" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			echo $custom_content;
		}
	}

	/**
	 * Returns social buttons.
	 *
	 * @since	4.0.0
	 *
	 * @return	buttons
	 */
	public function bbpress_after_topics() {

		$networks = maybe_unserialize(UltimateSocialDeux::opt('us_bbpress_after_topics_buttons'));

		if( is_array($networks) && !empty($networks) ) {

			$options = maybe_unserialize(UltimateSocialDeux::opt('us_bbpress_after_topics_options'));

			$sharetext = UltimateSocialDeux::opt('us_bbpress_after_topics_share_text');

			$count = ( in_array('hide_count', $options ) ) ? false : true;

			$native = ( in_array('native', $options ) ) ? true : false;

			$align = UltimateSocialDeux::opt('us_bbpress_after_topics_align', 'center');

			$margin_top = intval(UltimateSocialDeux::opt('us_bbpress_after_topics_margin_top', '0'));

			$margin_bottom = intval(UltimateSocialDeux::opt('us_bbpress_after_topics_margin_bottom', '0'));

			$skin = UltimateSocialDeux::opt('us_bbpress_after_topics_skin');

			$custom_content = sprintf('<div class="us_bbpress_after_topics" style="margin-top:%spx;margin-bottom:%spx;">', $margin_top, $margin_bottom);

				$custom_content .= UltimateSocialDeuxButtons::buttons($sharetext, $networks, '', $align, $count, $native, $skin);

			$custom_content .= '</div>';

			echo $custom_content;
		}
	}

}