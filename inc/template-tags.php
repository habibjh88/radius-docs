<?php
/**
 * Helpers methods
 * List all your static functions you wish to use globally on your theme
 *
 * @package RadiusDocs
 */

use RT\RadiusDocs\Modules\Breadcrumb;
use RT\RadiusDocs\Modules\PostMeta;
use RT\RadiusDocs\Modules\Svg;
use RT\RadiusDocs\Modules\Thumbnail;
use RT\RadiusDocs\Options\Opt;
use RT\RadiusDocs\Helpers\Fns;

/*Allow HTML for the kses post*/
function radius_docs_html( $html, $context = '', $echo = true ) {
	// Define reusable tag configurations
	$base_tags = [
		'a'      => [ 'href' => [], 'class' => [], 'rel' => [], 'title' => [], 'target' => [] ],
		'b'      => [],
		'img'    => [ 'src' => [], 'alt' => [], 'class' => [], 'width' => [], 'height' => [], 'srcset' => [] ],
		'p'      => [ 'class' => [] ],
		'span'   => [ 'class' => [], 'style' => [], 'title' => [] ],
		'strong' => [],
		'br'     => [],
	];

	// Context-specific tag adjustments
	$tags_by_context = [
		'plain'       => [ 'a' => [ 'href' => [] ], 'b' => [], 'span' => [ 'class' => [] ], 'p' => [ 'class' => [] ] ],
		'social'      => [ 'a' => [ 'href' => [] ], 'b' => [] ],
		'allow_link'  => array_merge( $base_tags, [ 'img' => $base_tags['img'] ] ),
		'allow_title' => array_merge( $base_tags, [ 'strong' => [], 'br' => [] ] ),
		'default'     => array_merge( $base_tags, [
			'abbr'       => [ 'title' => [] ],
			'blockquote' => [ 'cite' => [] ],
			'code'       => [],
			'del'        => [ 'datetime' => [], 'title' => [] ],
			'div'        => [ 'class' => [], 'style' => [], 'title' => [], 'id' => [] ],
			'h1'         => [ 'class' => [], 'style' => [], 'title' => [], 'id' => [] ],
			'h2'         => [ 'class' => [], 'style' => [], 'title' => [], 'id' => [] ],
			'h3'         => [ 'class' => [], 'style' => [], 'title' => [], 'id' => [] ],
			'h4'         => [ 'class' => [], 'style' => [], 'title' => [], 'id' => [] ],
			'h5'         => [ 'class' => [], 'style' => [], 'title' => [], 'id' => [] ],
			'h6'         => [ 'class' => [], 'style' => [], 'title' => [], 'id' => [] ],
			'i'          => [ 'class' => [] ],
			'li'         => [ 'class' => [] ],
			'ol'         => [ 'class' => [] ],
			'ul'         => [ 'class' => [] ],
			'iframe'     => [
				'class'                 => [],
				'id'                    => [],
				'name'                  => [],
				'src'                   => [],
				'title'                 => [],
				'frameBorder'           => [],
				'width'                 => [],
				'height'                => [],
				'scrolling'             => [],
				'allow'                 => [],
				'allowvr'               => [],
				'allowFullScreen'       => [],
				'webkitallowfullscreen' => [],
				'mozallowfullscreen'    => [],
				'loading'               => [],
			],
		] ),
	];

	// Determine tags for the given context
	$tags = $tags_by_context[ $context ] ?? $tags_by_context['default'];

	// If echo is false, return the sanitized HTML
	if ( ! $echo ) {
		return wp_kses( $html, $tags );
	}

	// Echo the sanitized HTML
	echo wp_kses( $html, $tags );
}

if ( ! function_exists( 'radius_docs_html_all' ) ) {
	/**
	 * Prints HTMl.
	 *
	 * @param $html
	 * @param $allHtml
	 * @param $echo
	 *
	 * @return mixed|string|void
	 */

	function radius_docs_html_all( $html, $all_html = false, $echo = true ) {
		if ( ! $html ) {
			return;
		}

		$html   = stripslashes_deep( $html );
		$output = $all_html ? $html : wp_kses_post( $html );

		if ( $echo ) {
			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $output;
		}
	}
}

if ( ! function_exists( 'radius_docs_custom_menu_cb' ) ) {
	/**
	 * Callback function for the main menu
	 *
	 * @param $args
	 *
	 * @return string|void
	 */
	function radius_docs_custom_menu_cb( $args ) {
		extract( $args );
		$add_menu_link = admin_url( 'nav-menus.php' );
		$menu_text     = sprintf( __( "Add %s Menu", "radius-docs" ), $theme_location );
		__( 'Add a menu', 'radius-docs' );
		if ( ! current_user_can( 'manage_options' ) ) {
			$add_menu_link = home_url();
			$menu_text     = __( 'Home', 'radius-docs' );
		}

		// see wp-includes/nav-menu-template.php for available arguments

		$link = $link_before . '<a href="' . $add_menu_link . '">' . $before . $menu_text . $after . '</a>' . $link_after;

		// We have a list
		if ( false !== stripos( $items_wrap, '<ul' ) || false !== stripos( $items_wrap, '<ol' ) ) {
			$link = "<li>$link</li>";
		}

		$output = sprintf( $items_wrap, $menu_id, $menu_class, $link );
		if ( ! empty ( $container ) ) {
			$output = "<$container class='$container_class' id='$container_id'>$output</$container>";
		}

		if ( $echo ) {
			echo wp_kses_post( $output );
		}

		return $output;
	}
}

if ( ! function_exists( 'radius_docs_hamburger' ) ) {
	/**
	 * Hamburger menu
	 *
	 * @param $style
	 *
	 * @return string
	 */
	function radius_docs_hamburger() {
		$style = radius_docs_option( 'radius_docs_hamburger_style', '3' );
		switch ( $style ) {
			case '1':
				$icon = '<div class="radius-docs-hamburger style1"><span></span><span></span><span></span></div>';
				break;
			case '2':
				$icon = '<div class="radius-docs-hamburger style2"><span></span><span></span><span></span><span></span><span></span><span></span></div>';
				break;
			case '3':
				$icon = '<div class="radius-docs-hamburger style3"><span></span><span></span><span></span><span></span></div>';
				break;
			case '4':
				$icon = '<div class="radius-docs-hamburger style4"><span></span><span></span><span></span></div>';
				break;
		}

		return $icon;
	}
}

if ( ! function_exists( 'radius_docs_menu_icons_group' ) ) {
	/**
	 * Get menu icon group
	 *
	 * @return void
	 */
	function radius_docs_menu_icons_group( $args = [] ) {
		$default_args = [
			'hamburg'       => radius_docs_option( 'radius_docs_header_bar' ),
			'search'        => radius_docs_option( 'radius_docs_header_search' ),
			'login'         => radius_docs_option( 'radius_docs_header_login_link' ),
			'button'        => radius_docs_option( 'radius_docs_get_started_button' ),
			'button_label'  => radius_docs_option( 'radius_docs_get_started_label' ),
			'button_link'   => radius_docs_option( 'radius_docs_get_started_button_url' ),
			'has_separator' => radius_docs_option( 'radius_docs_header_separator' ),
		];
		$args         = wp_parse_args( $args, $default_args );
		$has_button   = $args['button'] && $args['button_label'];
		$menu_classes = '';

		if ( $args['has_separator'] ) {
			$menu_classes .= 'has-separator ';
		}

		if ( $has_button ) {
			$menu_classes .= 'has-button ';
		}

		$has_hamburg = $args['hamburg'] ? 'has-hamburger' : 'no-hamburger';
		?>
        <div class="menu-icon-wrapper d-flex ml-auto align-items-center gap-15">
            <ul class="d-flex gap-20 align-items-center <?php echo esc_attr( $menu_classes ) ?>">
				<?php
				$icon_items = [];

				//No need the condition. Because it should show in the mobile by-default
				//$icon_items['hamburg'] = '<li class="' . $has_hamburg . '"><a class="menu-bar trigger-off-canvas" href="#"><svg class="ham_burger" viewBox="0 0 100 100" width="180"><path class="line top" d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"/><path class="line middle" d="m 30,50 h 40"/><path class="line bottom" d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"/></svg></a></li>';
				$icon_items['hamburg'] = '<li class="' . $has_hamburg . '"><a class="menu-bar trigger-off-canvas" href="#">' . radius_docs_hamburger() . '</a></li>';
				if ( $args['search'] ) {
					$icon_items['search'] = '<li class="radius-docs-search-popup"><a class="menu-search-bar radius-docs-search-trigger" href="#header-search" aria-label="search popup"><i class="raw-icon-search"></i></a></li>';
				}
				if ( $args['login'] ) {
					$login_icon          = radius_docs_option( 'radius_docs_get_login_label' ) ? "<i class='raw-icon-user'></i>" : radius_docs_option( 'radius_docs_get_login_label' );
					$login_url           = radius_docs_option( 'radius_docs_get_login_url' ) ? radius_docs_option( 'radius_docs_get_login_url' ) : wp_login_url();
					$icon_items['login'] = '<li class="radius-docs-user-login"><a href="' . esc_url( $login_url ) . '" aria-label="user login">' . $login_icon . '</a></li>';
				}
				if ( $has_button ) {
					$icon_items['button'] = '<li class="radius-docs-button"><a class="btn" href="' . $args['button_link'] . '">' . $args['button_label'] . '</a></li>';
				}
				$icon_order = explode( ',', radius_docs_option( 'radius_docs_menu_icon_order' ) );
				$icon_order = array_map( 'trim', $icon_order );
				$button_pos = array_search( 'button', $icon_order );

				foreach ( $icon_order as $index => $icon ) {
					if ( ! isset( $icon_items[ $icon ] ) ) {
						continue;
					}
					$icon = $icon_items[ $icon ];
					if ( ( $button_pos - 1 ) == $index ) {
						$icon = str_replace( 'class="', 'class="button-prev ', $icon );
					}
					radius_docs_html_all( $icon );
				}
				?>
            </ul>
        </div>
		<?php
	}
}

if ( ! function_exists( 'radius_docs_require' ) ) {
	/**
	 * Require any file. If the file will available in the child theme, the file will load from the child theme
	 *
	 * @param $filename
	 * @param string $dir
	 *
	 * @return false|void
	 */
	function radius_docs_require( $filename, string $dir = 'inc' ) {
		$dir        = trailingslashit( $dir );
		$child_file = get_stylesheet_directory() . DIRECTORY_SEPARATOR . $dir . $filename;

		if ( file_exists( $child_file ) ) {
			$file = $child_file;
		} else {
			$file = get_template_directory() . DIRECTORY_SEPARATOR . $dir . $filename;
		}

		if ( file_exists( $file ) ) {
			require_once $file;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'radius_docs_readmore_text' ) ) {
	/**
	 * Creates continue reading text.
	 *
	 * @return string
	 */
	function radius_docs_readmore_text() {
		$read_more_label = radius_docs_option( 'radius_docs_blog_read_more', 'Read More' );

		return sprintf(
			'%s <span class="screen-reader-text">%s</span>',
			esc_html( $read_more_label ),
			get_the_title()
		);
	}
}

if ( ! function_exists( 'radius_docs_get_file' ) ) {
	/**
	 * Get File Path
	 *
	 * @param $path
	 *
	 * @return string
	 */
	function radius_docs_get_file( $path, $return_path = false ): string {
		$file = ( $return_path ? get_stylesheet_directory() : get_stylesheet_directory_uri() ) . $path;
		if ( ! file_exists( $file ) ) {
			$file = ( $return_path ? get_template_directory() : get_template_directory_uri() ) . $path;
		}

		return $file;
	}
}

if ( ! function_exists( 'radius_docs_get_img' ) ) {
	/**
	 * Get Image Path
	 *
	 * @param $filename
	 * @param $echo
	 * @param $image_meta
	 *
	 * @return string|void
	 */
	function radius_docs_get_img( $filename, $echo = false, $image_meta = '' ) {
		$path      = '/assets/images/' . $filename;
		$image_url = radius_docs_get_file( $path );

		if ( $echo ) {
			if ( ! strpos( $filename, '.svg' ) ) {
				$getimagesize = wp_getimagesize( radius_docs_get_file( $path, true ) );
				$image_meta   = $getimagesize[3] ?? $image_meta;
			}
			echo '<img ' . $image_meta . ' src="' . esc_url( $image_url ) . '"/>';
		} else {
			return $image_url;
		}
	}
}

if ( ! function_exists( 'radius_docs_get_css' ) ) {
	/**
	 * Get CSS Path
	 *
	 * @param $filename
	 * @param bool $check_rtl
	 *
	 * @return string
	 */
	function radius_docs_get_css( $filename, $check_rtl = false ) {
		$min    = WP_DEBUG ? '.css' : '.min.css';
		$is_rtl = $check_rtl && is_rtl() ? 'css-rtl' : 'css';
		$path   = "/assets/$is_rtl/" . $filename . $min;

		return radius_docs_get_file( $path );
	}
}

if ( ! function_exists( 'radius_docs_get_js' ) ) {
	/**
	 * Get JS Path
	 *
	 * @param $filename
	 *
	 * @return string
	 */
	function radius_docs_get_js( $filename ) {
		$path = '/assets/js/' . $filename . '.js';

		return radius_docs_get_file( $path );
	}
}

if ( ! function_exists( 'radius_docs_get_assets' ) ) {
	/**
	 * Get JS Path
	 *
	 * @param $filename
	 *
	 * @return string
	 */
	function radius_docs_get_assets( $filename ) {
		$path = '/assets/' . $filename;

		return radius_docs_get_file( $path );
	}
}

if ( ! function_exists( 'radius_docs_option' ) ) {
	/**
	 * Get Customize Options value by key
	 *
	 * @param $key
	 * @param $default
	 * @param $return_array //make an array explode by ',' comma
	 *
	 * @return false|mixed|string|string[]
	 */
	function radius_docs_option( $key, $default = '', $return_array = false ) {
		if ( ! empty( Opt::$options[ $key ] ) ) {
			$opt_val = Opt::$options[ $key ];
			if ( $return_array && $opt_val ) {
				$opt_val = explode( ',', trim( $opt_val, ', ' ) );
			}

			return $opt_val;
		}

		if ( $default ) {
			return $default;
		}

		return false;
	}
}

if ( ! function_exists( 'radius_docs_get_social_html' ) ) {
	/**
	 * Get Social markup
	 *
	 * @return void
	 */

	function radius_docs_get_social_html() {
		ob_start();
		$icon_style = radius_docs_option( 'radius_docs_social_icon_style' );
		foreach ( Fns::get_socials() as $id => $item ) {
			if ( empty( $item['url'] ) ) {
				continue;
			}
			$icon = $id === 'twitter' ? 'twitter-x' : $id;
			?>
            <a class="social-link" target="_blank" href="<?php echo esc_url( $item['url'] ) ?>"
               aria-label="social link">
                <i class="raw-icon-<?php echo esc_attr( $icon ) ?>"></i>
            </a>
			<?php
		}

		echo ob_get_clean();
	}
}

if ( ! function_exists( 'radius_docs_site_logo' ) ) {
	/**
	 * Newfit Site Logo
	 */
	function radius_docs_site_logo( $logo_type = '', $custom_title = '' ) {
		$main_logo   = radius_docs_option( 'radius_docs_logo' );
		$logo_light  = radius_docs_option( 'radius_docs_logo_light' );
		$logo_light  = $logo_light ?: $main_logo;
		$logo_mobile = radius_docs_option( 'radius_docs_logo_mobile' );
		$site_logo   = Opt::$has_tr_header ? $logo_light : $main_logo;

		$mobile_logo     = $logo_mobile ?? $site_logo;
		$has_mobile_logo = ! empty( $logo_mobile ) ? 'has-mobile-logo' : 'no-mobile-logo';
		$site_title      = $custom_title ?: get_bloginfo( 'name', 'display' );

		if ( ! $site_logo && $mobile_logo ) {
			$site_logo = $mobile_logo;
		}
		if ( $logo_type ) {
			if ( $logo_type == 'mobile' ) {
				$site_logo  = $mobile_logo;
				$logo_light = $main_logo = null;
			} elseif ( $logo_type == 'light' ) {
				$site_logo   = $logo_light;
				$mobile_logo = $main_logo = null;
			} else {
				$site_logo   = $main_logo;
				$mobile_logo = $logo_light = null;
			}
		}

		?>

        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"
           class="<?php echo esc_attr( $has_mobile_logo ); ?>">
			<?php
			if ( ! empty( $site_logo ) ) {
				echo wp_get_attachment_image( $site_logo, 'full', null, [ 'class' => 'site-logo site-main-logo' ] );
				if ( ! empty( $mobile_logo ) ) {
					echo wp_get_attachment_image( $mobile_logo, 'full', null, [ 'class' => 'site-mobile-logo site-main-logo' ] );
				}
			} else {
				echo esc_html( $site_title );
			}
			?>
        </a>

		<?php
	}
}

if ( ! function_exists( 'radius_docs_scroll_top' ) ) {
	/**
	 * Back-to-top button
	 *
	 * @return void
	 */
	function radius_docs_scroll_top() {
		if ( radius_docs_option( 'radius_docs_back_to_top' ) ) {
			?>
            <a href="#" class="scrollToTop"><i class="raw-icon-angle-small-up"></i></a>
			<?php
		}
	}
}

if ( ! function_exists( 'radius_docs_entry_footer' ) ) {
	/**
	 * RadiusDocs Entry Footer
	 *
	 * @return void
	 *
	 */
	function radius_docs_entry_footer( $label = '', $icon = 'raw-icon-arrow-right' ) {
		if ( empty( $label ) ) {
			$label = radius_docs_readmore_text();
		}
		?>
        <footer class="entry-footer radius-docs-button">
            <a class="btn post-read-more"
               href="<?php echo esc_url( get_permalink() ) ?>">
				<?php radius_docs_html( $label, 'plain' ) ?>
                <i class="<?php echo esc_attr( $icon ); ?>"></i>
            </a>
        </footer>
		<?php
	}
}
if ( ! function_exists( 'radius_docs_single_entry_footer' ) ) {
	/**
	 * RadiusDocs Single Entry Footer
	 *
	 * @return void
	 *
	 */
	function radius_docs_single_entry_footer() {
		if ( ( has_tag() && radius_docs_option( 'radius_docs_single_tag_visibility' ) ) || radius_docs_option( 'radius_docs_single_share_visibility' ) ) { ?>
            <footer class="entry-footer d-flex align-items-start justify-content-between">
				<?php
				$tags = PostMeta::posted_in( 'post_tag' );
				if ( radius_docs_option( 'radius_docs_single_tag_visibility' ) && $tags ) { ?>
                    <div class="post-tags">
						<?php if ( radius_docs_option( 'radius_docs_tags_label' ) ) {
							printf( "<span class='post-footer-label'>%s</span>", esc_html( radius_docs_option( 'radius_docs_tags_label' ) ) );
						} ?>

                        <div class="post-footer-meta">
							<?php Fns::print_html_all( $tags ); ?>
                        </div>
                    </div>
				<?php }
				if ( radius_docs_option( 'radius_docs_single_share_visibility' ) ) { ?>
                    <div class="post-share">
						<?php if ( radius_docs_option( 'radius_docs_social' ) ) {
							printf( "<span class='post-footer-label'>%s</span>", esc_html( radius_docs_option( 'radius_docs_social' ) ) );
						} ?>
						<?php radius_docs_post_share(); ?>
                    </div>
				<?php } ?>
            </footer>
			<?php
		}
	}
}

if ( ! function_exists( 'radius_docs_author_info' ) ) {
	/**
	 * RadiusDocs Entry Profile
	 *
	 * @return void
	 *
	 */
	function radius_docs_author_info() {
		if ( ! radius_docs_option( 'radius_docs_single_profile_visibility' ) ) {
			return;
		}
		$author             = get_current_user_id();
		$author_description = get_user_meta( $author, 'description', true );
		$author_designation = get_user_meta( $author, 'radius_docs_designation', true );
		$author_fb          = get_user_meta( $author, 'radius_docs_facebook', true );
		$author_tw          = get_user_meta( $author, 'radius_docs_twitter', true );
		$author_lk          = get_user_meta( $author, 'radius_docs_linkedin', true );
		$author_vim         = get_user_meta( $author, 'radius_docs_vimeo', true );
		$author_you         = get_user_meta( $author, 'radius_docs_youtube', true );
		$author_ins         = get_user_meta( $author, 'radius_docs_instagram', true );
		$author_pin         = get_user_meta( $author, 'radius_docs_pinterest', true );
		$author_wht         = get_user_meta( $author, 'radius_docs_whatsapp', true );
		?>

        <div class="author-info-wrapper">
            <div class="author-image">
				<?php echo get_avatar( $author, 150 ); ?>
            </div>
            <div class="author-description">
                <h3 class="author-name"><?php the_author_posts_link(); ?></h3>
                <div class="profile-info">

					<?php if ( ! empty ( $author_designation ) ) : ?>
                        <span class="profile-designation">
						<?php echo esc_html( $author_designation ); ?>
						</span>
					<?php endif; ?>

                </div>

				<?php if ( $author_description ) { ?>
                    <div class="author-bio"><?php echo esc_html( $author_description ); ?></div>
				<?php } ?>
                <ul class="author-socials">
					<?php if ( ! empty( $author_fb ) ) { ?>
                        <li><a href="<?php echo esc_attr( $author_fb ); ?>"><i class="raw-icon-facebook"></i></a>
                        </li><?php } ?>
					<?php if ( ! empty( $author_tw ) ) { ?>
                        <li><a href="<?php echo esc_attr( $author_tw ); ?>"><i class="raw-icon-twitter-x"></i></i></a>
                        </li><?php } ?>
					<?php if ( ! empty( $author_lk ) ) { ?>
                        <li><a href="<?php echo esc_attr( $author_lk ); ?>"><i class="raw-icon-linkedin"></a>
                        </li><?php } ?>
					<?php if ( ! empty( $author_vim ) ) { ?>
                        <li><a href="<?php echo esc_attr( $author_vim ); ?>"><i class="raw-icon-vimeo"></a>
                        </li><?php } ?>
					<?php if ( ! empty( $author_you ) ) { ?>
                        <li><a href="<?php echo esc_attr( $author_you ); ?>"><i class="raw-icon-youtube"></a>
                        </li><?php } ?>
					<?php if ( ! empty( $author_ins ) ) { ?>
                        <li><a href="<?php echo esc_attr( $author_ins ); ?>"><i class="raw-icon-instagram"></a>
                        </li><?php } ?>
					<?php if ( ! empty( $author_pin ) ) { ?>
                        <li><a href="<?php echo esc_attr( $author_pin ); ?>"><i class="raw-icon-pinterest"></a>
                        </li><?php } ?>
					<?php if ( ! empty( $author_wht ) ) { ?>
                        <li><a href="<?php echo esc_attr( $author_wht ); ?>"><i class="raw-icon-whatsapp"></a>
                        </li><?php } ?>
                </ul>
            </div>
        </div>

		<?php
	}
}

if ( ! function_exists( 'radius_docs_entry_content' ) ) {
	/**
	 * Entry Content
	 *
	 * @return void
	 */
	function radius_docs_entry_content( $limit = '' ) {
		$length = $limit ?: radius_docs_option( 'radius_docs_excerpt_limit' );
		echo wp_trim_words( get_the_excerpt(), $length );
	}
}

function radius_docs_separate_meta( $post_type = 'post', $includes = [ 'category' ] ) {
	?>
    <div class="separate-meta">
		<?php
		PostMeta::get_meta( $post_type, [
			'with_list' => false,
			'with_icon' => false,
			'include'   => $includes,
		] );
		?>
    </div>
	<?php
}

if ( ! function_exists( 'radius_docs_sidebar' ) ) {
	/**
	 * Get Sidebar conditionally
	 *
	 * @param $sidebar_id
	 *
	 * @return false|void
	 */
	function radius_docs_sidebar( $sidebar_id ) {
		$sidebar_from_layout = Opt::$sidebar;

		if ( 'default' !== $sidebar_from_layout && is_active_sidebar( $sidebar_from_layout ) ) {
			$sidebar_id = $sidebar_from_layout;
		}
		if ( ! is_active_sidebar( $sidebar_id ) ) {
			return false;
		}

		if ( Opt::$layout == 'full-width' || Opt::$single_style == '4' ) {
			return false;
		}

		$sidebar_cols = Fns::sidebar_columns();
		?>
        <aside id="sidebar" class="radius-docs-widget-area sidebar-sticky <?php echo esc_attr( $sidebar_cols ) ?>"
               role="complementary">
            <div class="sidebar-inner-wrapper">
				<?php dynamic_sidebar( $sidebar_id ); ?>
            </div>
        </aside><!-- #sidebar -->
		<?php
	}
}

if ( ! function_exists( 'radius_docs_post_class' ) ) {
	/**
	 * Get dynamic article classes
	 *
	 * @return string
	 */
	function radius_docs_post_class( $classes = '', $is_single = false, $check_blog_cols = true ) {
		$blog_style                   = radius_docs_option( 'radius_docs_blog_style' );
		$blog_column                  = radius_docs_option( 'radius_docs_blog_column' );
		$blog_above_meta_visibility   = radius_docs_option( 'radius_docs_blog_above_meta_visibility' );
		$blog_meta_style              = radius_docs_option( 'radius_docs_blog_meta_style' );
		$blog_masonry                 = radius_docs_option( 'radius_docs_blog_masonry', false );
		$single_above_meta_visibility = radius_docs_option( 'radius_docs_single_above_meta_visibility' );
		$single_meta_style            = radius_docs_option( 'radius_docs_single_meta_style' );
		$different_cat_color          = radius_docs_option( 'radius_docs_different_category_color' );
		$cat_class                    = $different_cat_color ? 'cat-different-color' : '';
		$common_class                 = 'blog-post-card blog-post-card ' . $cat_class;

		$is_grid_or_list = strpos( $blog_style, "list" ) !== false ? 'blog-list' : 'blog-grid';

		$blog_style = isset( $_GET['style'] ) ? sanitize_text_field( $_GET['style'] ) : $blog_style;

		//Set default column
		if ( 'default' === $blog_column ) {
			$is_fullwidth = 'col-12' === Fns::content_columns(); //check is the layout full width
			if ( 'blog-list' == $is_grid_or_list ) {
				$blog_column = 'col-12';
			} else {
				$blog_column = $is_fullwidth ? 'col-md-4' : 'col-md-6';
			}
		}

		if ( $is_single ) {
			$blog_style   = 's-blog-' . $blog_style;
			$common_class .= $single_above_meta_visibility ? ' is-above-meta' : ' no-above-meta';
			$meta_style   = $single_meta_style;
			$post_classes = Fns::class_list( [ 'single-article-content', $common_class, $meta_style, $blog_style ] );
		} else {
			$common_class .= $blog_above_meta_visibility ? ' is-above-meta' : ' no-above-meta';
			$meta_style   = $blog_meta_style;
			$blog_style   = 'blog-' . $blog_style;
			$masonry      = $blog_masonry ? 'masonry-item' : '';
			$post_classes = Fns::class_list( [
				$common_class,
				$meta_style,
				$blog_style,
				$is_grid_or_list,
				$masonry,
				$check_blog_cols ? Fns::archive_column( $blog_column, $blog_style ) : '',
			] );
		}

		if ( $classes ) {
			return $post_classes . ' ' . $classes;
		}

		return $post_classes;
	}
}

if ( ! function_exists( 'radius_docs_cpt_class' ) ) {
	/**
	 * Get dynamic article classes
	 *
	 * @return string
	 */
	function radius_docs_cpt_class( $opt_prefix, $is_single = false, $check_blog_cols = true ) {
		$blog_style                 = radius_docs_option( "radius_docs_{$opt_prefix}_style" );
		$blog_column                = radius_docs_option( "radius_docs_{$opt_prefix}_column" );
		$blog_above_meta_visibility = radius_docs_option( "radius_docs_{$opt_prefix}_above_meta_visibility" );
		$blog_meta_style            = radius_docs_option( "radius_docs_{$opt_prefix}_meta_style" );
		$blog_masonry               = radius_docs_option( "radius_docs_{$opt_prefix}_masonry" );

		$common_class = "blog-post-card radius-docs-{$opt_prefix}-item";
		$blog_style   = isset( $_GET['style'] ) ? sanitize_text_field( $_GET['style'] ) : $blog_style;

		if ( $is_single ) {
			$blog_style   = 's-blog-' . $blog_style;
			$post_classes = Fns::class_list( [ 'single-article-content', $common_class, $blog_style ] );
		} else {
			$common_class .= $blog_above_meta_visibility ? 'is-above-meta' : 'no-above-meta';
			$meta_style   = $blog_meta_style;
			$blog_style   = 'blog-' . $blog_style;
			$masonry      = $blog_masonry ? 'masonry-item' : '';
			$post_classes = Fns::class_list( [
				$common_class,
				$meta_style,
				$blog_style,
				$masonry,
				$check_blog_cols ? Fns::archive_column( $blog_column, $blog_style ) : '',
			] );
		}

		return $post_classes;
	}
}

if ( ! function_exists( 'radius_docs_separate_meta' ) ) {
	/**
	 * Get above title meta
	 *
	 * @return string
	 */
	function separate_meta( $post_type = 'post', $includes = [ 'category' ] ) {
		?>
        <div class="separate-meta">
			<?php
			PostMeta::get_meta( $post_type, [
				'with_list' => false,
				'with_icon' => false,
				'include'   => $includes,
			] );
			?>
        </div>
		<?php
	}
}

if ( ! function_exists( 'radius_docs_single_separate_meta' ) ) {
	/**
	 * Get above title meta
	 *
	 * @return string
	 */
	function radius_docs_single_separate_meta( $post_type = 'post', $includes = [ 'category' ] ) {
		?>
        <div class="separate-meta">
		<?php
		PostMeta::get_meta( $post_type, [
			'with_list' => false,
			'with_icon' => false,
			'include'   => $includes,
		] );
		?>
        </div><?php
	}
}

if ( ! function_exists( 'radius_docs_single_entry_header' ) ) {
	/**
	 * Get above title meta
	 *
	 * @return string
	 */
	function radius_docs_single_entry_header() {
		?>
        <header class="entry-header">
			<?php
			if ( radius_docs_option( 'radius_docs_single_above_meta_visibility' ) ) {
				radius_docs_single_separate_meta();
			}

			the_title( '<h1 class="entry-title default-max-width">', '</h1>' );

			if ( ! empty( Fns::single_meta_lists() ) && radius_docs_option( 'radius_docs_single_meta_visibility' ) ) {
				PostMeta::get_meta( 'post', [
					'include' => Fns::single_meta_lists(),
				] );
			}
			?>
        </header>
		<?php
	}
}

if ( ! function_exists( 'radius_docs_get_avatar_url' ) ) :
	function radius_docs_get_avatar_url( $get_avatar ) {
		preg_match( "/src='(.*?)'/i", $get_avatar, $matches );

		return $matches[1];
	}
endif;

function radius_docs_comments_cbf( $comment, $args, $depth ) {
	// Get correct tag used for the comments
	if ( 'div' === $args['style'] ) {
		$tag       = 'div ';
		$add_below = 'comment';
	} else {
		$tag       = 'li ';
		$add_below = 'div-comment';
	} ?>

    <<?php echo esc_attr( $tag ); ?><?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>">

	<?php
	// Switch between different comment types
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' : ?>
            <div class="pingback-entry"><span
                    class="pingback-heading"><?php esc_html_e( 'Pingback:', 'radius-docs' ); ?></span> <?php comment_author_link(); ?>
            </div>
			<?php
			break;
		default :

			if ( 'div' != $args['style'] ) { ?>
                <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
			<?php } ?>
            <div class="comment-author">
                <div class="vcard">
					<?php
					// Display avatar unless size is set to 0
					if ( $args['avatar_size'] != 0 ) {
						$avatar_size = ! empty( $args['avatar_size'] ) ? $args['avatar_size'] : 70; // set default avatar size
						echo get_avatar( $comment, $avatar_size );
					} ?>
                </div>
                <div class="author-info">
					<?php
					// Display author name
					printf( __( '<cite class="fn">%s</cite>', 'radius-docs' ), get_comment_author_link() ); ?>

                    <div class="comment-meta commentmetadata">
                        <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php
							/* translators: 1: date, 2: time */
							printf(
								__( '%1$s at %2$s', 'radius-docs' ),
								get_comment_date(),
								get_comment_time()
							); ?>
                        </a><?php
						edit_comment_link( __( 'Edit', 'radius-docs' ), '  ', '' ); ?>
                    </div><!-- .comment-meta -->
                    <div class="comment-details">

                        <div class="comment-text"><?php comment_text(); ?></div><!-- .comment-text -->
						<?php
						// Display comment moderation text
						if ( $comment->comment_approved == '0' ) { ?>
                            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'radius-docs' ); ?></em>
                            <br/><?php
						} ?>

						<?php
						$icon = "<i class='raw-icon-share'></i>";
						// Display comment reply link
						comment_reply_link( array_merge( $args, [
							'add_below'  => $add_below,
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
							'reply_text' => $icon . __( 'Reply', 'radius-docs' ),
						] ) ); ?>

                    </div><!-- .comment-details -->
                </div>

            </div><!-- .comment-author -->

			<?php
			if ( 'div' != $args['style'] ) { ?>
                </div>
			<?php }
			// IMPORTANT: Note that we do NOT close the opening tag, WordPress does this for us
			break;
	endswitch; // End comment_type check.
}

if ( ! function_exists( 'radius_docs_contact_info' ) ) {
	/**
	 * Get Contact Info from Customize
	 *
	 * @param $address
	 * @param $phone
	 * @param $email
	 *
	 * @return void
	 */
	function radius_docs_contact_info( $address, $phone, $email ) {
		if ( $address && radius_docs_option( 'radius_docs_contact_address' ) ) { ?>
            <div class="address">
                <i class="raw-icon-marker"></i>
                <span><?php radius_docs_html( radius_docs_option( 'radius_docs_contact_address' ), false ); ?></span>
            </div>
		<?php }
		if ( $phone && radius_docs_option( 'radius_docs_phone' ) ) { ?>
            <div class="phone">
                <i class="raw-icon-phone-flip"></i>
                <a href="tel:<?php echo esc_attr( radius_docs_option( 'radius_docs_phone' ) ); ?>">
					<?php radius_docs_html( radius_docs_option( 'radius_docs_phone' ), false ); ?>
                </a>
            </div>
		<?php }
		if ( $email && radius_docs_option( 'radius_docs_email' ) ) { ?>
            <div class="email">
                <i class="raw-icon-envelope"></i>
                <a href="mailto:<?php echo esc_attr( radius_docs_option( 'radius_docs_email' ) ); ?>">
					<?php radius_docs_html( radius_docs_option( 'radius_docs_email' ), false ); ?>
                </a>
            </div>
		<?php }
	}
}

if ( ! function_exists( 'radius_docs_post_share' ) ) {
	/**
	 * Post Share
	 *
	 * @return void
	 */
	function radius_docs_post_share() {
		$url       = urlencode( get_permalink() );
		$title     = urlencode( get_the_title() );
		$meta_list = explode( ',', radius_docs_option( 'radius_docs_post_share' ) );
		// Your $defaults array
		$defaults       = [
			'facebook'  => [
				'url'  => "http://www.facebook.com/sharer.php?u=$url",
				'icon' => 'facebook',
			],
			'twitter'   => [
				'url'  => "https://twitter.com/intent/tweet?source=$url&text=$title:$url",
				'icon' => 'twitter',
			],
			'linkedin'  => [
				'url'  => "http://www.linkedin.com/shareArticle?mini=true&url=$url&title=$title",
				'icon' => 'linkedin',
			],
			'pinterest' => [
				'url'  => "http://pinterest.com/pin/create/button/?url=$url&description=$title",
				'icon' => 'pinterest',
			],
			'whatsapp'  => [
				'url'  => 'https://api.whatsapp.com/send?text=' . $title . ' – ' . $url,
				'icon' => 'whatsapp',
			],
			'youtube'   => [
				'url'  => "https://www.youtube.com?text='. $title .'&amp;url='. $url",
				'icon' => 'youtube',
			],
		];
		$category_index = array_intersect_key( $defaults, array_flip( $meta_list ) );
		$sharers        = apply_filters( 'radius_docs_social_sharing_icons', $category_index );
		?>

        <ul class="social-share-list">
			<?php foreach ( $sharers as $key => $sharer ): ?>
                <li class="social-<?php echo esc_attr( $key ); ?>">
                    <a href="<?php echo esc_url( $sharer['url'] ); ?>" target="_blank">
                        <i class="raw-icon-<?php echo esc_attr( $sharer['icon'] ); ?>"></i>
                    </a>
                </li>
			<?php endforeach; ?>
        </ul>
		<?php
	}
}

if ( ! function_exists( 'is_radius_docs_project' ) ) {
	/**
	 * Check is project archive
	 *
	 * @return bool
	 */
	function is_radius_docs_project() {
		return is_post_type_archive( 'radius-docs-project' );
	}
}

if ( ! function_exists( 'is_radius_docs_project_category' ) ) {
	/**
	 * Check is project Category
	 *
	 * @return bool
	 */
	function is_radius_docs_project_category( $term = '' ) {
		return is_tax( 'radius-docs-project-category', $term );
	}
}

if ( ! function_exists( 'is_radius_docs_service' ) ) {
	/**
	 * Check is service archive
	 *
	 * @return bool
	 */
	function is_radius_docs_service() {
		return is_post_type_archive( 'radius-docs-service' );
	}
}

if ( ! function_exists( 'is_radius_docs_service_category' ) ) {
	/**
	 * Check is service category
	 *
	 * @return bool
	 */
	function is_radius_docs_service_category( $term = '' ) {
		return is_tax( 'radius-docs-service-category', $term );
	}
}

