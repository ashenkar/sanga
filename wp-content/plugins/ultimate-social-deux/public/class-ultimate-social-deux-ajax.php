<?php
/**
 * Ultimate Social Deux.
 *
 * @package		Ultimate Social Deux
 * @author		Ultimate WP <hello@ultimate-wp.com>
 * @link		http://social.ultimate-wp.com
 * @copyright 	2015 Ultimate WP
 */

class UltimateSocialDeuxAjax {

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

		add_action( 'wp_ajax_nopriv_us_send_mail', array( $this, 'us_send_mail' ) );

		add_action( 'wp_ajax_us_send_mail', array( $this, 'us_send_mail' ) );

		add_action( 'wp_ajax_nopriv_us_counts', array( $this, 'us_counts' ) );

		add_action( 'wp_ajax_us_counts', array( $this, 'us_counts' ) );

		add_action( 'wp_ajax_nopriv_us_love', array( $this, 'us_love_button_ajax' ) );

		add_action( 'wp_ajax_us_love', array( $this, 'us_love_button_ajax' ) );

		add_action( 'wp_ajax_nopriv_us_bitly', array( $this, 'us_bitly_shortener' ) );

		add_action( 'wp_ajax_us_bitly', array( $this, 'us_bitly_shortener' ) );

		add_action( 'wp_ajax_nopriv_us_fan_counts', array( $this, 'us_fan_counts' ) );

		add_action( 'wp_ajax_us_fan_counts', array( $this, 'us_fan_counts' ) );

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
	 * Ajax function to send mail.
	 *
	 * @since	1.0.0
	 */
	public function us_send_mail(){

		if ( wp_verify_nonce( $_POST['nonce'], 'us_nonce' ) ) {

			$url 			= ( $_POST['url'] ) ? $_POST['url']: '';
			$your_name		= ( $_POST['your_name'] ) ? $_POST['your_name']: '';
			$your_email		= ( $_POST['your_email'] ) ? $_POST['your_email']: '';
			$recipient_email = ( $_POST['recipient_email'] ) ? $_POST['recipient_email']: '';
			$subject		= UltimateSocialDeux::mail_replace_vars( UltimateSocialDeux::opt('us_mail_subject', __('A visitor of', 'ultimate-social-deux' ) . ' ' . '{site_title}' . ' ' . __('shared', 'ultimate-social-deux' ) . ' ' . '{post_title}' . ' ' . __('with you.','ultimate-social-deux') ), $url, $your_name, $your_email );
			$message		= ( $_POST['message'] ) ? $_POST['message']: '';
			$captcha		= ( $_POST['captcha'] ) ? $_POST['captcha']: '';
			$captcha_answer	= UltimateSocialDeux::opt('us_mail_captcha_answer', 9);
			$captcha_enable	= UltimateSocialDeux::opt('us_mail_captcha_enable', 'yes');

			$admin_email	= get_bloginfo('admin_email');
			$from_email		= UltimateSocialDeux::opt('us_mail_from_email', $admin_email);
			$from_name		= UltimateSocialDeux::opt('us_mail_from_name', get_bloginfo('name') );
			$admin_copy		= UltimateSocialDeux::opt('us_mail_bcc_enable', 'yes' );

			if ( $captcha_enable == 'yes' ){
				if( '' == $captcha )
					die( __( 'Captcha cannot be empty!', 'ultimate-social-deux' ) );
				if( $captcha !== $captcha_answer )
					die( __( 'Captcha does not match.', 'ultimate-social-deux' ) );
			}

			if ( ! filter_var( $recipient_email, FILTER_VALIDATE_EMAIL ) ) {
				die( __( 'Recipient email address is not valid.', 'ultimate-social-deux' ) );
			} elseif ( ! filter_var( $your_email, FILTER_VALIDATE_EMAIL ) ) {
				die( __( 'Your email address is not valid.', 'ultimate-social-deux' ) );
			} elseif( strlen( $your_name ) == 0 ) {
				die( __( 'Your name cannot be empty.', 'ultimate-social-deux' ) );
			} elseif( strlen( $message ) == 0 ) {
				die( __( 'Message cannot be empty.', 'ultimate-social-deux' ) );
			}
			$headers	= array();
			$headers[] = sprintf('From: %s <%s>', $from_name, $from_email );
			$headers[] = sprintf('Reply-To: %s <%s>', $your_name, $your_email );
			if ($admin_copy == 'yes') {
				$headers[] = sprintf('Bcc: %s', $admin_email);
			}

			if( true === ( $result = wp_mail( $recipient_email, stripslashes($subject), stripslashes($message), implode("\r\n", $headers) ) ) )
				die( 'ok' );

			if ( ! $result ) {

				global $phpmailer;

				if( isset( $phpmailer->ErrorInfo ) ) {
					die( sprintf( 'Error: %s', $phpmailer->ErrorInfo ) );
				} else {
					die( __( 'Unknown wp_mail() error.', 'ultimate-social-deux' ) );
				}
			}
		}
	}

	/**
	 * Ajax function for love button
	 *
	 * @since	3.0.0
	 */
	public function us_love_button_ajax() {

		$url = ( $_POST['url'] ) ? $_POST['url']: '';

		if ( $url && wp_verify_nonce( $_POST['nonce'], 'us_nonce' ) ) {

			$current_user = wp_get_current_user();

			$urlencode = urlencode($url);
			$user_id = ( $current_user->ID ) ? $current_user->ID: 0;
			$options = get_option( 'us_love_count' );

			$id_array = ( !empty($options['data'][$url]['ids']) ) ? $options['data'][$url]['ids']: array();

			if (!in_array( $user_id, $id_array ) ) {

				if ( !empty( $options['data'][$url]['count'] ) ) {
					$options['data'][$url]['count'] = $options['data'][$url]['count'] + 1;
				} else {
					$options['data'][$url]['count'] = 1;
				}

				if( $user_id == 0 ) {
					$options['data'][$url]['ids'][$user_id] = $user_id;
				}

				update_option( 'us_love_count', $options );

				die('ok');
			} else {
				die();
			}
		}
	}

	/**
	 * Ajax function for bit.ly shortener
	 *
	 * @since	3.0.0
	 */
	public function us_bitly_shortener() {

		header('content-type: application/json');

		$url = ( $_POST['url'] ) ? $_POST['url']: '';

		$revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');

		$url = strtr(rawurlencode($url), $revert);

		$access_token = UltimateSocialDeux::opt('us_bitly_access_token', '');

		if ($access_token && wp_verify_nonce( $_POST['nonce'], 'us_nonce' ) ) {
			$content = self::remote_get('https://api-ssl.bitly.com/v3/shorten?access_token='.$access_token.'&longUrl='.$url, false);
			echo $content;
		}

		die();

	}

	/**
	 * Ajax function for getting counts
	 *
	 * @since	1.0.0
	 */
	public function us_counts() {

		header('content-type: application/json');

		$ajax_debug = UltimateSocialDeux::opt('us_ajax_debug', false);

		if(wp_verify_nonce( $_REQUEST['nonce'], 'us_nonce' ) || $ajax_debug) {

			if (!class_exists('Requests')) {
				require_once(plugin_dir_path( __FILE__ ) . '/includes/Requests.php');

				Requests::register_autoloader();
			}

			$args = ( $_REQUEST['args'] ) ? $_REQUEST['args'] : die('Args not set');
			$args = urldecode(stripslashes($args));
			$args = json_decode($args, true);

			$option = maybe_unserialize( get_option('us_share_counts', array() ) );

			$json = array();

			foreach ($args['urls'] as $key => $data) {

				$url = $data['url'];

				if(filter_var($url, FILTER_VALIDATE_URL)){

					$timestamp = time();
					foreach ($data['networks'] as $key => $network) {

						switch($network) {
							case 'facebook':

								$app_token = UltimateSocialDeux::opt('us_facebook_token');

								$fb_token = ($app_token) ? "&access_token=".$app_token:'';

								$requests[$network.' '.$url] = array(
									'url' => "https://graph.facebook.com/fql?q=SELECT%20share_count,like_count,comment_count,total_count,commentsbox_count%20FROM%20link_stat%20WHERE%20url='".$url."'".$fb_token,
									'options' => array(
										'timeout' => 5,
									),
								);

							break;
							case 'twitter':

								$requests[$network.' '.$url] = array(
									'url' => "https://cdn.api.twitter.com/1/urls/count.json?url=".$url,
									'options' => array(
										'timeout' => 5,
									),
								);

							break;
							case 'delicious':

								$requests[$network.' '.$url] = array(
									'url' => "https://avosapi.delicious.com/api/v1/posts/md5/".md5($url),
									'options' => array(
										'timeout' => 5,
									),
								);

							break;
							case 'linkedin':

								$requests[$network.' '.$url] = array(
									'url' => "https://www.linkedin.com/countserv/count/share?format=json&url=".$url,
									'options' => array(
										'timeout' => 5,
									),
								);

							break;
							case 'buffer':

								$requests[$network.' '.$url] = array(
									'url' => "https://api.bufferapp.com/1/links/shares.json?url=".$url,
									'options' => array(
										'timeout' => 5,
									),
								);

							break;
							case 'google':

								$requests[$network.' '.$url] = array(
									'url' => "https://plusone.google.com/u/0/_/+1/fastbutton?count=true&url=".$url,
									'options' => array(
										'timeout' => 5,
									),
								);

							break;
							case 'stumble':

								$requests[$network.' '.$url] = array(
									'url' => "https://www.stumbleupon.com/services/1.01/badge.getinfo?url=".$url,
									'options' => array(
										'timeout' => 5,
									),
								);

							break;
							case 'pinterest':

								$requests[$network.' '.$url] = array(
									'url' => "https://api.pinterest.com/v1/urls/count.json?url=".$url,
									'options' => array(
										'timeout' => 5,
									),
								);

							break;
							case 'vkontakte':

								$requests[$network.' '.$url] = array(
									'url' => "https://vk.com/share.php?act=count&index=0&url=".$url,
									'options' => array(
										'timeout' => 5,
									),
								);

							break;
							case 'pocket':

								$requests[$network.' '.$url] = array(
									'url' => "https://widgets.getpocket.com/v1/button?align=center&count=vertical&label=pocket&url=".$url,
									'options' => array(
										'timeout' => 5,
									),
								);

							break;
							case 'ok':

								$requests[$network.' '.$url] = array(
									'url' => "http://www.odnoklassniki.ru/dk?st.cmd=extLike&uid=odklcnt0&ref=".$url,
									'options' => array(
										'timeout' => 5,
									),
								);

							break;
							case 'xing':

								$requests[$network.' '.$url] = array(
									'url' => 'https://www.xing-share.com/app/share?op=get_share_button;counter=top;lang=en;type=iframe;hovercard_position=2;shape=rectangle;url='.$url,
									'options' => array(
										'timeout' => 5,
									),
								);

							break;
							case 'managewp':

								$requests[$network.' '.$url] = array(
									'url' => 'https://managewp.org/share/frame/small?url='.$url,
									'options' => array(
										'timeout' => 5,
									),
								);

							break;
						}
					}
				} else {
					break;
				}
			}

			$responses = (!empty($requests)) ? Requests::request_multiple($requests): die('No requests sent.');

			foreach ($responses as $key => $data) {

				$key = explode(" ", $key);
				$url = $key[1];
				$network = $key[0];

				$option[$url][$network]['count'] = ( isset($option[$url][$network]['count']) ) ? $option[$url][$network]['count']: 0;
				$json[$url][$network]['count'] = $option[$url][$network]['count'];
				$option[$url][$network]['timestamp'] = $timestamp;

				switch($network) {
					case 'facebook':

						if (isset($responses[$network.' '.$url]->body)) {
							$content = $responses[$network.' '.$url]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$url][$network]['count'] = 0;
							$json[$url][$network]['count'] = 0;

							foreach ($content['data'] as $key => $value) {
								$option[$url][$network]['count'] += intval($value['total_count']);
								$json[$url][$network]['count'] += intval($value['total_count']);
							}
						}

					break;
					case 'twitter':
					case 'linkedin':

						if (isset($responses[$network.' '.$url]->body)) {

							$content = $responses[$network.' '.$url]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$url][$network]['count'] = intval($content['count']);
							$json[$url][$network]['count'] = intval($content['count']);
						}

					break;
					case 'delicious':

						if (isset($responses[$network.' '.$url]->body)) {

							$content = $responses[$network.' '.$url]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$url][$network]['count'] = intval($content['pkg'][0]['num_saves']);
							$json[$url][$network]['count'] = intval($content['pkg'][0]['num_saves']);
						}

					break;
					case 'buffer':

						if (isset($responses[$network.' '.$url]->body)) {

							$content = $responses[$network.' '.$url]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$url][$network]['count'] = intval($content['shares']);
							$json[$url][$network]['count'] = intval($content['shares']);
						}

					break;
					case 'google':

						if (isset($responses[$network.' '.$url]->body)) {

							$content = $responses[$network.' '.$url]->body;

							if ($ajax_debug) {
								print_r($content);
							}

						  	if (preg_match("/window\.__SSR\s=\s\{c:\s([0-9]+)\.0/", $content, $matches)) {
								$option[$url][$network]['count'] = intval($matches[1]);
								$json[$url][$network]['count'] = intval($matches[1]);
							} else {
								$option[$url][$network]['count'] = 0;
								$json[$url][$network]['count'] = 0;
							}
						}

					break;
					case 'stumble':

						if (isset($responses[$network.' '.$url]->body)) {

							$content = $responses[$network.' '.$url]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$url][$network]['count'] = (isset($content['result']['views'])) ? intval($content['result']['views']): 0;
							$json[$url][$network]['count'] = (isset($content['result']['views'])) ? intval($content['result']['views']): 0;
						}

					break;
					case 'pinterest':

						if (isset($responses[$network.' '.$url]->body)) {

							$content = $responses[$network.' '.$url]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = preg_replace('/^receiveCount\((.*)\)$/', "\\1", $content);

							$result = json_decode($content, true);

							$option[$url][$network]['count'] = intval($result['count']);
							$json[$url][$network]['count'] = intval($result['count']);
						}

					break;
					case 'vkontakte':

						if (isset($responses[$network.' '.$url]->body)) {

							$content = $responses[$network.' '.$url]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$content = substr($content, 18, -2);

							$option[$url][$network]['count'] = intval($content);
							$json[$url][$network]['count'] = intval($content);
						}

					break;
					case 'ok':

						if (isset($responses[$network.' '.$url]->body)) {

							$content = $responses[$network.' '.$url]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = substr($content, 29, -3);

							$option[$url][$network]['count'] = intval($content);
							$json[$url][$network]['count'] = intval($content);
						}

					break;
					case 'xing':

						if (isset($responses[$network.' '.$url]->body)) {

							$content = $responses[$network.' '.$url]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$result = array();

							preg_match( '/<span class="xing-count top">(.*?)<\/span>/s', $content, $result );

							if (count($result) > 0) {

								$content = $result[1];
							}

							$option[$url][$network]['count'] = intval($content);
							$json[$url][$network]['count'] = intval($content);
						}

					break;
					case 'managewp':

						if (isset($responses[$network.' '.$url]->body)) {

							$content = $responses[$network.' '.$url]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$result = array();

							$content = preg_match( '/<form(.*?)<\/form>/s', $content, $result );

							if (count($result) > 0) {
								$current_result = $result[1];

								$second_parse = array();
								preg_match( '/<div>(.*?)<\/div>/s', $current_result, $second_parse );

								$value = $second_parse[1];
								$value = str_replace("<span>", "", $value);
								$value = str_replace("</span>", "", $value);

								$option[$url][$network]['count'] = intval($value);
								$json[$url][$network]['count'] = intval($value);
							}
						}
					break;
					default:
						unset($option[$url][$network]);
					break;
				}
			}

			maybe_serialize( update_option('us_share_counts', $option ) );

			echo str_replace('\\/','/',json_encode($json));
		} else {
			die('Nonce not verified');
		}

		die();

	}

	public static function remote_get( $url, $json = true) {
		$request = wp_remote_retrieve_body( wp_remote_get( $url , array( 'timeout' => 18 , 'sslverify' => false ) ) );
		$request = stripslashes($request);
		if( $json ) $request = @json_decode( $request , true );
		return $request;
	}

	public function us_fan_counts() {

		header('content-type: application/json');

		$ajax_debug = UltimateSocialDeux::opt('us_ajax_debug', false);

		if(wp_verify_nonce( $_REQUEST['nonce'], 'us_nonce' ) || $ajax_debug) {

			if (!class_exists('Requests')) {
				require_once(plugin_dir_path( __FILE__ ) . '/includes/Requests.php');

				Requests::register_autoloader();
			}

			$args = ( $_REQUEST['args'] ) ? $_REQUEST['args'] : die('Args not set');
			$args = urldecode(stripslashes($args));
			$args = json_decode($args, true);

			$option = maybe_unserialize( get_option('us_fan_counts', array() ) );

			$json = array();

			$networks = explode(',', $args['networks']);

			$networks = array_keys(array_flip($networks));

			$timestamp = time();
			foreach ($networks as $key => $network) {

				$option[$network]['count'] = ( isset($option[$network]['count']) ) ? $option[$network]['count']: 0;
				$json[$network]['count'] = $option[$network]['count'];
				$option[$network]['timestamp'] = $timestamp;

				$id = '';
				$key = '';
				$secret = '';
				$api = '';
				$app = '';
				$user = '';
				$name = '';
				$username = '';

				switch($network) {
					case 'facebook':

						$app_token = UltimateSocialDeux::opt('us_facebook_token');

						$fb_token = ($app_token) ? "?access_token=".$app_token:'';

						$id = UltimateSocialDeux::opt('us_facebook_id');
						if ($id) {
							$requests[$network] = array(
								'url' => "https://graph.facebook.com/".$id.$fb_token
							);
						}

					break;
					case 'twitter':

						$id = UltimateSocialDeux::opt('us_twitter_id');
						$key = UltimateSocialDeux::opt('us_twitter_key');
						$secret = UltimateSocialDeux::opt('us_twitter_secret');

						if ($id && $key && $secret) {
							$token = get_option( 'us_fan_count_twitter_token' );

							if(!$token) {
								$credentials = $key . ':' . $secret;
								$encode = base64_encode($credentials);

								$args = array(
									'method' => 'POST',
									'httpversion' => '1.1',
									'blocking' => true,
									'headers' => array(
										'Authorization' => 'Basic ' . $encode,
										'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
									),
									'body' => array( 'grant_type' => 'client_credentials' )
								);

								add_filter('https_ssl_verify', '__return_false');
								$response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);

								$keys = json_decode(wp_remote_retrieve_body($response));

								if(!isset($keys->errors) && $keys) {
									update_option('us_fan_count_twitter_token', $keys->access_token);
									$token = $keys->access_token;
								}
							}

							$requests[$network] = array(
								'url' => 'https://api.twitter.com/1.1/users/show.json?screen_name='.$id,
								'headers' => array('Authorization' => "Bearer $token" )
							);
						}

					break;
					case 'google':

						$id = UltimateSocialDeux::opt('us_google_id');
						$key = UltimateSocialDeux::opt('us_google_key');
						if($key && $id) {
							$requests[$network] = array(
								'url' => "https://www.googleapis.com/plus/v1/people/".$id."?key=".$key
							);
						}

					break;
					case 'behance':

						$id = UltimateSocialDeux::opt('us_behance_id');
						$api = UltimateSocialDeux::opt('us_behance_api');
						if ($id && $api) {
							$requests[$network] = array(
								'url' => "http://www.behance.net/v2/users/".$id."?api_key=".$api
							);
						}

					break;
					case 'delicious':

						$id = UltimateSocialDeux::opt('us_delicious_id');
						if ($id) {
							$requests[$network] = array(
								'url' => "http://feeds.delicious.com/v2/json/userinfo/".$id
							);
						}

					break;
					case 'linkedin':

						$id = UltimateSocialDeux::opt('us_linkedin_id');
						$app = UltimateSocialDeux::opt('us_linkedin_app');
						$api = UltimateSocialDeux::opt('us_linkedin_api');
						if (!class_exists('LinkedIn')) {
							require_once plugin_dir_path( __FILE__ ) . 'includes/linkedin/linkedin.php';
						}
						if ( !class_exists( 'OAuthServer' ) ) {
							require_once plugin_dir_path( __FILE__ ) . 'includes/OAuth/OAuth.php';
						}
						if ($id && $api && $id) {
							$count = 0;
							$opt = array (
								'appKey' => $app ,
								'appSecret' => $api ,
								'callbackUrl' => '' ,
							);

							$api_call = new LinkedIn( $opt );
							$response = $api_call->company( trim( 'universal-name=' . $id . ':(num-followers)' ) );

							if ($ajax_debug) {
								print_r($response);
							}

							if ( false !== $response['success'] ) {
								$company = new SimpleXMLElement( $response['linkedin'] );

								if ( isset( $company->{'num-followers'} ) ) {

									$count = intval(current( $company->{'num-followers'} ));
								}
							}
							$option[$network]['count'] = $count;
							$json[$network]['count'] = $count;
						}

					break;
					case 'youtube':

						$id = UltimateSocialDeux::opt('us_youtube_id');
						if ($id) {
							$requests[$network] = array(
								'url' => "http://gdata.youtube.com/feeds/api/users/".$id."?alt=json"
							);
						}

					break;
					case 'soundcloud':

						$id = UltimateSocialDeux::opt('us_soundcloud_id');
						$user = UltimateSocialDeux::opt('us_soundcloud_username');
						if ($id && $user) {
							$requests[$network] = array(
								'url' => 'http://api.soundcloud.com/users/'.$user.'.json?client_id='.$id
							);
						}

					break;
					case 'vimeo':

						$id = UltimateSocialDeux::opt('us_vimeo_id');
						if ($id) {
							$requests[$network] = array(
								'url' => "http://vimeo.com/api/v2/channel/".$id."/info.json"
							);
						}

					break;
					case 'dribbble':

						$id = UltimateSocialDeux::opt('us_dribbble_id');
						if ($id) {
							$requests[$network] = array(
								'url' => "http://api.dribbble.com/".$id
							);
						}

					break;
					case 'github':

						$id = UltimateSocialDeux::opt('us_github_id');
						if ($id) {
							$requests[$network] = array(
								'url' => "https://api.github.com/users/".$id
							);
						}

					break;
					case 'envato':

						$id = UltimateSocialDeux::opt('us_envato_id');

						if ($id) {
							$requests[$network] = array(
								'url' => "http://marketplace.envato.com/api/edge/user:".$id.".json"
							);
						}

					break;
					case 'instagram':

						$api = UltimateSocialDeux::opt('us_instagram_api');
						$id = explode(".", $api);
						if ($api && $id) {
							$requests[$network] = array(
								'url' => "https://api.instagram.com/v1/users/".$id[0]."/?access_token=".$api
							);
						}

					break;
					case 'mailchimp':

						$name = UltimateSocialDeux::opt('us_mailchimp_name');
						$api = UltimateSocialDeux::opt('us_mailchimp_api');

						$count = 0;

						if ($name && $api) {
							if (!class_exists('MCAPI')) {
								require_once( plugin_dir_path( __FILE__ ) . 'includes/MCAPI.class.php' );
							}

							$api = new MCAPI($api);
							$retval = $api->lists();

							if ($ajax_debug) {
								print_r($retval);
							}

							if (count($retval['data']) > 0) {
								foreach ($retval['data'] as $list){
									if($list['name'] == $name){
										$count = intval($list['stats']['member_count']);
										break;
									}
								}
							}
						}

						$option[$network]['count'] = intval($count);
						$json[$network]['count'] = intval($count);

					break;
					case 'vkontakte':

						$id = UltimateSocialDeux::opt('us_vkontakte_id');
						if ($id) {
							$requests[$network] = array(
								'url' => "http://api.vk.com/method/groups.getById?gid=".$id."&fields=members_count"
							);
						}

					break;
					case 'pinterest':

						$username = UltimateSocialDeux::opt('us_pinterest_username');
						if ($username) {
							$requests[$network] = array(
								'url' => 'http://www.pinterest.com/'.$username.'/'
							);
						}

					break;
					case 'flickr':

						$id = UltimateSocialDeux::opt('us_flickr_id');
						$api = UltimateSocialDeux::opt('us_flickr_api');
						if ($id && $api) {
							$requests[$network] = array(
								'url' => "https://api.flickr.com/services/rest/?method=flickr.groups.getInfo&api_key=".$api."&group_id=".$id."&format=json&nojsoncallback=1"
							);
						}

					break;
					case 'feedpress':

						$manual = intval( UltimateSocialDeux::opt('us_feedpress_manual', 0) );

						$url = UltimateSocialDeux::opt('us_feedpress_url');

						if (filter_var($url, FILTER_VALIDATE_URL)) {
							$requests[$network] = array(
								'url' => $url
							);
						}
						if ($manual) {
							$option[$network]['count'] = $manual;
							$json[$network]['count'] = $manual;
						}
					break;
					default:
						unset($option[$network]);
						unset($json[$network]);
					break;
				}
			}

			$responses = (!empty($requests)) ? Requests::request_multiple($requests): die('No requests sent.');

			foreach ($responses as $network => $data) {

				switch($network) {
					case 'facebook':

						if (isset($responses[$network]->body)) {

							$content = $responses[$network]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$network]['count'] = intval($content['likes']);
							$json[$network]['count'] = intval($content['likes']);
						}

					break;
					case 'twitter':
					case 'soundcloud':
					case 'dribbble':

						if (isset($responses[$network]->body)) {

							$content = $responses[$network]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$network]['count'] = intval($content['followers_count']);
							$json[$network]['count'] = intval($content['followers_count']);
						}

					break;
					case 'google':

						if (isset($responses[$network]->body)) {

							$content = $responses[$network]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$network]['count'] = intval($content['circledByCount']);
							$json[$network]['count'] = intval($content['circledByCount']);
						}

					break;
					case 'behance':

						if (isset($responses[$network]->body)) {

							$content = $responses[$network]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$network]['count'] = intval($content['user']['stats']['followers']);
							$json[$network]['count'] = intval($content['user']['stats']['followers']);
						}

					break;
					case 'delicious':

						if (isset($responses[$network]->body)) {

							$content = $responses[$network]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$network]['count'] = intval($content[2]['n']);
							$json[$network]['count'] = intval($content[2]['n']);
						}

					break;
					case 'youtube':

						if (isset($responses[$network]->body)) {

							$content = $responses[$network]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$network]['count'] = intval($content['entry']['yt$statistics']['subscriberCount']);
							$json[$network]['count'] = intval($content['entry']['yt$statistics']['subscriberCount']);
						}

					break;
					case 'vimeo':

						if (isset($responses[$network]->body)) {

							$content = $responses[$network]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$network]['count'] = intval($content['total_subscribers']);
							$json[$network]['count'] = intval($content['total_subscribers']);
						}

					break;
					case 'github':

						if (isset($responses[$network]->body)) {

							$content = $responses[$network]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$network]['count'] = intval($content['followers']);
							$json[$network]['count'] = intval($content['followers']);
						}

					break;
					case 'envato':

						if (isset($responses[$network]->body)) {

							$content = $responses[$network]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$network]['count'] = intval($content['user']['followers']);
							$json[$network]['count'] = intval($content['user']['followers']);
						}

					break;
					case 'instagram':

						if (isset($responses[$network]->body)) {

							$content = $responses[$network]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$network]['count'] = intval($content['data']['counts']['followed_by']);
							$json[$network]['count'] = intval($content['data']['counts']['followed_by']);
						}

					break;
					case 'vkontakte':

						if (isset($responses[$network]->body)) {

							$content = $responses[$network]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$network]['count'] = intval($content['response'][0]['members_count']);
							$json[$network]['count'] = intval($content['response'][0]['members_count']);
						}

					break;
					case 'pinterest':

						if (isset($responses[$network]->body)) {

							$html = $responses[$network]->body;

							if ($ajax_debug) {
								print_r($html);
							}

							$doc = new DOMDocument();
							@$doc->loadHTML($html);
							$metas = $doc->getElementsByTagName('meta');
							for ($i = 0; $i < $metas->length; $i++){
								$meta = $metas->item($i);
								if($meta->getAttribute('name') == 'pinterestapp:followers'){
									$count = intval($meta->getAttribute('content'));
									break;
								}
							}

							$option[$network]['count'] = $count;
							$json[$network]['count'] = $count;
						}

					break;
					case 'flickr':

						if (isset($responses[$network]->body)) {

							$content = $responses[$network]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$network]['count'] = intval($content['group']['members']['_content']);
							$json[$network]['count'] = intval($content['group']['members']['_content']);
						}

					break;
					case 'feedpress':

						if (isset($responses[$network]->body)) {

							$content = $responses[$network]->body;

							if ($ajax_debug) {
								print_r($content);
							}

							$content = json_decode($content, true);

							$option[$network]['count'] = intval($content['subscribers']) + $manuel;
							$json[$network]['count'] = intval($content['subscribers']) + $manuel;
						}
					break;
				}
			}

			maybe_serialize( update_option('us_fan_counts', $option ) );

			echo str_replace('\\/','/',json_encode($json));
		} else {
			die('Nonce not verified');
		}

		die();
	}

}
