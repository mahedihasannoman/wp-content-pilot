<?php
/**
 * Feed Class
 *
 * @package     WP Content Pilot
 * @subpackage  Feed
 * @copyright   Copyright (c) 2019, MD Sultan Nasir Uddin(manikdrmc@gmail.com)
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.2.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPCP_Feed extends WPCP_Campaign {

	/**
	 * WPCP_Feed constructor.
	 */
	public function __construct() {
		//campaign settings
		add_filter( 'wpcp_modules', array( $this, 'register_module' ) );
		add_filter( 'wpcp_campaign_keyword_input_args', array( $this, 'campaign_keyword_input' ), 99, 3 );
		add_action( 'wpcp_after_campaign_keyword_input', array( $this, 'campaign_option_fields' ), 10, 2 );
		add_action( 'wpcp_update_campaign_settings', array( $this, 'update_campaign_settings' ), 10, 2 );

		add_filter( 'wpcp_keyword', array( $this, 'feed_links' ), 10, 2 );

		//campaign actions
		add_action( 'wp_feed_options', array( $this, 'set_feed_options' ) );
		add_action( 'http_response', array( $this, 'trim_feed_content' ) );
		add_action( 'wp_feed_options', array( $this, 'force_feed' ), 10, 1 );

		add_action( 'wpcp_fetching_campaign_contents', array( $this, 'prepare_contents' ) );

	}

	public function register_module( $modules ) {
		$modules['feed'] = [
			'title'       => __( 'Feed', 'wp-content-pilot' ),
			'description' => __( 'Scraps articles from the feed urls', 'wp-content-pilot' ),
			'supports'    => self::get_template_tags(),
			'callback'    => __CLASS__,
		];

		return $modules;
	}

	/**
	 * Supported template tags
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public static function get_template_tags() {
		$tags = array( 'author', 'title', 'except', 'content', 'image_url' );

		return $tags;
	}


	/**
	 * Filter keyword input to change as links
	 *
	 * @since 1.0.0
	 *
	 * @param $attr
	 * @param $post_id
	 * @param $campaign_type
	 *
	 * @return mixed
	 */
	public function campaign_keyword_input( $attr, $post_id, $campaign_type ) {
		if ( $campaign_type == 'feed' ) {
			$attr['label'] = __( 'Feed Links', 'wp-content-pilot' );
			$attr['name']  = '_feed_links';
			$attr['desc']  = __( 'Input feed links separate comma', 'wp-content-pilot' );
			$attr['value'] = wpcp_get_post_meta( $post_id, '_feed_links' );
		}

		return $attr;
	}

	/**
	 * Conditionally show meta fields
	 *
	 * @since 1.0.0
	 *
	 * @param $post_id
	 * @param $campaign_type
	 *
	 * @return bool
	 */
	public function campaign_option_fields( $post_id, $campaign_type ) {
		if ( 'feeds' != $campaign_type ) {
			return false;
		}

		echo content_pilot()->elements->select( array(
			'label'            => __( 'Force Feed', 'wp-content-pilot' ),
			'name'             => '_force_feed',
			'placeholder'      => '',
			'show_option_all'  => '',
			'show_option_none' => '',
			'options'          => array(
				'yes' => __( 'Yes', 'wp-content-pilot' ),
				'no'  => __( 'No', 'wp-content-pilot' ),
			),
			'required'         => true,
			'double_columns'   => true,
			'selected'         => wpcp_get_post_meta( $post_id, '_force_feed', 'no' ),
			'desc'             => __( 'If you are putting exact feed link then set this to yes, otherwise feed links will be auto discovered', 'wp-content-pilot' ),
		) );

	}

	/**
	 * update campaign settings
	 *
	 * @since 1.0.0
	 *
	 * @param $post_id
	 * @param $posted
	 */
	public function update_campaign_settings( $post_id, $posted ) {
		$raw_links = empty( $posted['_feed_links'] ) ? '' : esc_html( $posted['_feed_links'] );
		$links     = wpcp_string_to_array( $raw_links, ',', array( 'trim', 'esc_url' ) );
		$str_links = implode( ',', $links );

		update_post_meta( $post_id, '_feed_links', $str_links );
		update_post_meta( $post_id, '_force_feed', empty( $posted['_force_feed'] ) ? 'no' : esc_attr( $posted['_force_feed'] ) );
	}

	/**
	 * fe
	 *
	 * @since 1.0.0
	 *
	 * @param $keywords
	 * @param $campaign_id
	 *
	 * @return null|string
	 */
	public function feed_links( $keywords, $campaign_id ) {
		$type = wpcp_get_post_meta( $campaign_id, '_campaign_type', 'feed' );
		if ( 'feed' === $type ) {
			return wpcp_get_post_meta( $campaign_id, '_feed_links', '' );
		}

		return $keywords;
	}

	/**
	 * Set user agent to fix curl transfer
	 * closed without complete data
	 *
	 * @since 1.0.0
	 *
	 * @param $args
	 */
	public function set_feed_options( $args ) {
		$args->set_useragent( 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/41.0.2272.76 ' );
	}

	/**
	 * Trim body to remove extra space
	 *
	 * since 1.0.0
	 *
	 * @param $args
	 *
	 * @return mixed
	 */
	public function trim_feed_content( $args ) {
		$args['body'] = trim( $args['body'] );

		return $args;
	}

	/**
	 * Force feed with the given feedlink
	 *
	 * since 1.0.0
	 *
	 * @param $feed
	 */
	public function force_feed( $feed ) {
		if ( 'yes' == wpcp_get_post_meta( $this->campaign_id, '_force_feed', 'no' ) ) {
			$feed->force_feed( true );
		}
	}

	/**
	 * Hook in background process and prepare contents
	 *
	 * @since 1.0.0
	 *
	 * @param $link
	 *
	 * @return bool
	 */
	public function prepare_contents( $link ) {

		if ( 'feed' !== $link->camp_type ) {
			return false;
		}

		do_action( 'wpcp_feed_content_proceeding', $link, $this );
		wpcp_update_link( $link->id, array(
			'status' => 'ready',
		) );
	}


	/**
	 * Nothing to check
	 * since 1.0.0
	 *
	 * @return bool
	 */
	public function setup() {
		return true;
	}

	public function discover_links() {
		include_once( ABSPATH . WPINC . '/feed.php' );
		$rss = fetch_feed( $this->keyword );

		if ( is_wp_error( $rss ) ) {
			return $rss;
		}

		if ( $this->is_result_like_last_time( $rss ) ) {
			$msg = __( sprintf( 'Could not discover any new post to for the url . Please try letter.', $this->keyword ), 'wp-content-pilot' );
			wpcp_log( $msg, 'log' );

			return new \WP_Error( 'no-new-result', $msg );
		}

		$max_items = $rss->get_item_quantity();
		$rss_items = $rss->get_items( 0, $max_items );

		if ( ! isset( $max_items ) || $max_items == 0 ) {
			wpcp_disable_keyword( $this->campaign_id, $this->keyword, '_feed_links' );
			$msg = __( 'Could not find any post so disabling url', 'wp-content-pilot' );
			wpcp_log( $msg, 'critical' );

			return new \WP_Error( 'fetch-links-failed', $msg );
		}


		$links = [];
		foreach ( $rss_items as $rss_item ) {
			$url = esc_url( $rss_item->get_permalink() );

			if ( stristr( $url, 'news.google' ) ) {
				$urlParts   = explode( 'url=', $url );
				$correctUrl = $urlParts[1];
				$url        = $correctUrl;

			}

			//Google alerts links correction
			if ( stristr( $this->keyword, 'alerts/feeds' ) && stristr( $this->keyword, 'google' ) ) {
				preg_match( '{url\=(.*?)[&]}', $url, $urlMatches );
				$correctUrl = $urlMatches[1];

				if ( trim( $correctUrl ) != '' ) {
					$url = $correctUrl;
				}
			}

			$host    = wpcp_get_host( $url );
			$content = wpcp_fix_html_links( $rss_item->get_content(), $host );

			$link = array(
				'title'       => $rss_item->get_title(),
				'content'     => $content,
				'url'         => $url,
				'image'       => '',
				'raw_content' => $content,
				'score'       => '0',
				'status'      => 'fetched',
			);

			$link = apply_filters( 'wpcp_before_insert_feed_link', $link, $this->campaign_id );

			$links[] = $link;
		}

		return $links;

	}


	public function get_post( $link ) {
		$article = array(
			'title'       => $link->title,
			'raw_title'   => $link->title,
			'content'     => $link->content,
			'raw_content' => $link->raw_content,
			'image_url'   => $link->image,
			'source_url'  => $link->url,
			'date'        => $link->gmt_date ? get_date_from_gmt( $link->gmt_date ) : current_time( 'mysql' ),
			'score'       => $link->score,
		);

		return $article;
	}


}
