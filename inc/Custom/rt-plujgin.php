<?php
/**
 * Plugin Name:       Rt Plugin
 * Plugin URI:        https://radiustheme.com/docs
 * Description:       RadiusTheme Docs Helper Plugin.
 * Version:           1.0.0
 * Author:            RadiusTheme
 * Author URI:        https://radiustheme.com
 */

require_once "inc/functions.php";

class RtPlugin
{

	public function __construct() {

		/* hooks */
		register_activation_hook(__FILE__, [__CLASS__, 'remove_category_url_refresh_rules']);
		register_deactivation_hook(__FILE__, [__CLASS__, 'remove_category_url_deactivate']);

		add_action('registered_post_type', [$this, 'enable_hierarchy_fields'], 123, 2);
		add_filter('post_type_labels_post', [$this, 'enable_hierarchy_fields_for_js'], 11, 2);
		add_filter('pre_post_link', [$this, 'change_permalinks'], 8, 3);
		add_filter('pre_get_posts', [$this, 'method__query'], 888);
		add_action('registered_post_type', [$this, 'hierarchy_for_custom_post'], 90, 2);

		/**
		 * Category Remove
		 */
		/* actions */
		add_action('created_category', [__CLASS__, 'remove_category_url_refresh_rules']);
		add_action('delete_category', [__CLASS__, 'remove_category_url_refresh_rules']);
		add_action('edited_category', [__CLASS__, 'remove_category_url_refresh_rules']);
		add_action('init', [$this, 'remove_category_url_permastruct']);

		/* filters */
		add_filter('category_rewrite_rules', [$this, 'remove_category_url_rewrite_rules']);
		add_filter('query_vars', [$this, 'remove_category_url_query_vars']);    // Adds 'category_redirect' query variable
		add_filter('request', [$this, 'remove_category_url_request']);       // Redirects if 'category_redirect' is set
		add_action('init', [$this, 'add_post_attributes'], 500);
		add_filter('rest_pre_insert_post', [$this, 'pre_insert_post'], 12, 2);
		add_filter('rest_prepare_post', [$this, 'prepare_post'], 12, 3);
	}

	/**
	 * Add page attributes to post
	 */
	function add_post_attributes() {
		add_post_type_support('post', 'page-attributes');
	}

	/**
	 * Add the menu_order property to the post object being saved
	 *
	 * @param \WP_Post|\stdClass $post
	 * @param WP_REST_Request    $request
	 *
	 * @return \WP_Post
	 */
	function pre_insert_post($post, \WP_REST_Request $request) {
		$body = $request->get_body();
		if ($body) {
			$body = json_decode($body);
			if (isset($body->menu_order)) {
				$post->menu_order = $body->menu_order;
			}
		}

		return $post;
	}

	/**
	 * Load the menu_order property for frontend display in the admin
	 *
	 * @param \WP_REST_Response $response
	 * @param \WP_Post          $post
	 * @param \WP_REST_Request  $request
	 *
	 * @return \WP_REST_Response
	 */
	function prepare_post(\WP_REST_Response $response, $post, $request) {
		$response->data['menu_order'] = $post->menu_order;

		return $response;
	}

	static function remove_category_url_refresh_rules() {
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}

	static function remove_category_url_deactivate() {
		remove_filter('category_rewrite_rules', [__CLASS__, 'remove_category_url_rewrite_rules']); // We don't want to insert our custom rules again
		self::remove_category_url_refresh_rules();
	}

	/**
	 * Removes category base.
	 *
	 * @return void
	 */
	function remove_category_url_permastruct() {
		global $wp_rewrite, $wp_version;

		if (3.4 <= $wp_version) {
			$wp_rewrite->extra_permastructs['category']['struct'] = '%category%';
		} else {
			$wp_rewrite->extra_permastructs['category'][0] = '%category%';
		}
	}

	/**
	 * Adds our custom category rewrite rules.
	 *
	 * @param array $category_rewrite Category rewrite rules.
	 *
	 * @return array
	 */
	function remove_category_url_rewrite_rules($category_rewrite) {
		global $wp_rewrite;

		$category_rewrite = array();

		/* WPML is present: temporary disable terms_clauses filter to get all categories for rewrite */
		if (class_exists('Sitepress')) {
			global $sitepress;

			remove_filter('terms_clauses', array($sitepress, 'terms_clauses'), 10);
			$categories = get_categories(array('hide_empty' => false, '_icl_show_all_langs' => true));
			add_filter('terms_clauses', array($sitepress, 'terms_clauses'), 10, 4);
		} else {
			$categories = get_categories(array('hide_empty' => false));
		}

		foreach ($categories as $category) {
			$category_nicename = $category->slug;
			if ($category->parent == $category->cat_ID) {
				$category->parent = 0;
			} elseif (0 != $category->parent) {
				$category_nicename = get_category_parents($category->parent, false, '/', true) . $category_nicename;
			}
			$category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
			$category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
			$category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
		}

		// Redirect support from Old Category Base
		$old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
		$old_category_base = trim($old_category_base, '/');
		$category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';

		return $category_rewrite;
	}

	function remove_category_url_query_vars($public_query_vars) {
		$public_query_vars[] = 'category_redirect';

		return $public_query_vars;
	}

	/**
	 * Handles category redirects.
	 *
	 * @param $query_vars
	 *
	 * @return mixed
	 */
	function remove_category_url_request($query_vars) {
		if (isset($query_vars['category_redirect'])) {
			$catLink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
			status_header(301);
			header("Location: $catLink");
			exit;
		}

		return $query_vars;
	}

	/**
	 * @param $post_type
	 * @param $post_type_object
	 */
	public function enable_hierarchy_fields($post_type, $post_type_object) {
		if ($post_type == 'post') {
			$post_type_object->hierarchical = true;
		}
	}

	/**
	 * @param $labels
	 *
	 * @return mixed
	 */
	public function enable_hierarchy_fields_for_js($labels) {
		$labels->parent_item_colon = 'Parent Post';
		return $labels;
	}

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function method__query($query) {
		$q = $query;

		if ($q->is_main_query() && !is_admin()) {
			$possible_post_path = trailingslashit(preg_replace_callback('/(.*?)\/((page|feed|rdf|rss|rss2|atom)\/.*)/i', function ($matches) {
				return $matches[1];
			}, $this->path_after_blog_s()));
			if (substr_count($possible_post_path, "/") >= 2) {
				$post = get_page_by_path($possible_post_path, OBJECT, 'post');
				if ($post) {
					$q->parse_query(['post_type' => ['post']]);
					$q->is_home = false;
					$q->is_single = true;
					$q->is_singular = true;
					$q->queried_object_id = $post->ID;
					$q->set('page_id', $post->ID);
					return $q;
				}
			}
		}
		return $q;
	}

	/**
	 * @return false|string|string[]
	 */
	public function path_after_blog_s() {
		$prf = $this->get_blog_prefix_s();
		$path = substr($_SERVER["REQUEST_URI"], strlen(home_url('/', 'relative')));
		return (($prf == "/blog") ? str_replace('/blog/', '', '/' . $path) : $path);
	}

	/**
	 * @return string
	 */
	private function get_blog_prefix_s() {
		$blog_prefix = '';
		if (is_multisite() && !is_subdomain_install() && is_main_site() && 0 === strpos(get_option('permalink_structure'), '/blog/')) {
			$blog_prefix = '/blog';
		}
		return $blog_prefix;
	}

	/**
	 * @param $post_type
	 * @param $post_type_object
	 */
	public function hierarchy_for_custom_post($post_type, $post_type_object) {
		if ('post' == $post_type) {
			$post_type_object->hierarchical = true;
		}
	}

	/**
	 * @param      $permalink
	 * @param bool $post
	 * @param bool $leavename
	 *
	 * @return string|string[]
	 */
	public function change_permalinks($permalink, $post = false, $leavename = false) {
		if ($post->post_type == "post") {
			// return if %postname% tag is not present in the url:
			if (false === strpos($permalink, '%postname%')) {
				return $permalink;
			}
			$path = str_replace('%postname%', $this->get_parent_slugs($post) . '/' . '%postname%', $permalink);
			$permalink = str_replace('//', '/', $path);
		}
		return $permalink;
	}

	public function get_parent_slugs($post) {
		$final_SLUGG = '';
		if (!empty($post->post_parent)) {
			$parent_post = get_post($post->post_parent);
			while (!empty($parent_post)) {
				$final_SLUGG = $parent_post->post_name . '/' . $final_SLUGG;
				if (!empty($parent_post->post_parent)) {
					$parent_post = get_post($parent_post->post_parent);
				} else {
					break;
				}
			}
			$final_SLUGG = empty($final_SLUGG) ?: '/' . $final_SLUGG;
		}
		return $final_SLUGG;
	}

} // End Of Class

new RtPlugin();

