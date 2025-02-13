<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RT\RadiusDocs\Framework\Customize\Controls;

use WP_Customize_Control;

/**
 * Customizer GoogleFontsControls Controls
 */

class GoogleFontsControls extends WP_Customize_Control {
	/**
	 * The type of control being rendered
	 */
	public $type = 'google_fonts';
	/**
	 * The list of Google Fonts
	 */
	private $fontList = false;
	/**
	 * The saved font values decoded from json
	 */
	private $fontValues = [];
	/**
	 * The index of the saved font within the list of Google fonts
	 */
	private $fontListIndex = 0;
	/**
	 * The number of fonts to display from the json file. Either positive integer or 'all'. Default = 'all'
	 */
	private $fontCount = 'all';

	/**
	 * Get our list of fonts from the json file
	 */
	public function __construct( $manager, $id, $args = [], $options = [] ) {
		parent::__construct( $manager, $id, $args );
		// Get the font sort order
		// Get the list of Google fonts
		if ( isset( $this->input_attrs['font_count'] ) ) {
			if ( 'all' != strtolower( $this->input_attrs['font_count'] ) ) {
				$this->fontCount = ( abs( (int) $this->input_attrs['font_count'] ) > 0 ? abs( (int) $this->input_attrs['font_count'] ) : 'all' );
			}
		}
		$this->fontList = $this->radius_docs_getGoogleFonts( 'all' );
		// Decode the default json font value
		$this->fontValues = json_decode( $this->value() );
		// Find the index of our default font within our list of Google fonts
		if ( ! empty( $this->fontList ) ) {
			$this->fontListIndex = $this->radius_docs_getFontIndex( $this->fontList, $this->fontValues->font );
		}
	}

	/**
	 * Enqueue our scripts and styles
	 */
	public function enqueue() {
		wp_enqueue_script( 'radius-docs-select2-js', radius_docs_get_assets( 'customize/js/select2.min.js' ), [ 'jquery' ], '4.0.6', true );
		wp_enqueue_script( 'radius-docs-typography-controls-js', radius_docs_get_assets('customize/js/typography.js'), [ 'radius-docs-select2-js' ], '1.2', true );
		wp_enqueue_style( 'radius-docs-select2-css', radius_docs_get_assets('customize/css/select2.min.css'), [], '4.0.6', 'all' );
	}

	/**
	 * Export our List of Google Fonts to JavaScript
	 */
	public function to_json() {
		parent::to_json();
		$this->json['neuzinfontslist'] = $this->fontList;
	}

	/**
	 * Render the control in the customizer
	 */
	public function render_content() {
		$fontCounter  = 0;
		$isFontInList = false;
		$fontListStr  = '';

		if ( ! empty( $this->fontList ) ) {
			?>
			<div class="google_fonts_select_control">
				<?php if ( ! empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if ( ! empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>"
				       name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>"
				       class="customize-control-google-font-selection" <?php $this->link(); ?> />
				<div class="google-fonts">
					<select class="google-fonts-list" control-name="<?php echo esc_attr( $this->id ); ?>">
						<?php
						foreach ( $this->fontList as $key => $value ) {
							$fontCounter ++;
							$fontListStr .= '<option value="' . $value->family . '" ' . selected( $this->fontValues->font, $value->family, false ) . '>' . $value->family . '</option>';
							if ( $this->fontValues->font === $value->family ) {
								$isFontInList = true;
							}
							if ( is_int( $this->fontCount ) && $fontCounter === $this->fontCount ) {
								break;
							}
						}
						if ( ! $isFontInList && $this->fontListIndex ) {
							// If the default or saved font value isn't in the list of displayed fonts, add it to the top of the list as the default font
							$fontListStr = '<option value="' . $this->fontList[ $this->fontListIndex ]->family . '" ' . selected( $this->fontValues->font, $this->fontList[ $this->fontListIndex ]->family, false ) . '>' . $this->fontList[ $this->fontListIndex ]->family . ' (default)</option>' . $fontListStr;
						}
						// Display our list of font options
						printf( '%s', $fontListStr );
						?>
					</select>
				</div>

				<div class="weight-style">
					<div class="google-font-style-wrap">
						<div class="customize-control-description"><?php echo esc_html__( 'Font weight', 'radius-docs-core' ); ?></div>
						<select class="google-fonts-regularweight-style">
							<?php
							foreach ( $this->fontList[ $this->fontListIndex ]->variants as $key => $value ) {
								if ( $value == 'regular' ) {
									$value = 'normal';
								}
								echo '<option value="' . $value . '" ' . selected( $this->fontValues->regularweight, $value, false ) . '>' . $value . '</option>';
							}
							?>
						</select>
					</div>

					<div class="google-font-style-wrap">
						<div class="customize-control-description"><?php echo esc_html__( 'Font Size', 'radius-docs-core' ); ?></div>
						<input type="number" class="google-font-size google-font-style" value="<?php echo $this->fontValues->size; ?>">
						<span><?php echo esc_html__( 'px', 'radius-docs-core' ); ?></span>
					</div>

					<div class="google-font-style-wrap">
						<div class="customize-control-description"><?php echo esc_html__( 'Line Height', 'radius-docs-core' ); ?></div>
						<input type="number" class="google-font-line-height google-font-style" value="<?php echo $this->fontValues->lineheight; ?>">
						<span><?php echo esc_html__( 'px', 'radius-docs-core' ); ?></span>
					</div>
				</div>
			</div>
			<?php
		}
	}

	/**
	 * Find the index of the saved font in our multidimensional array of Google Fonts
	 */
	public function radius_docs_getFontIndex( $haystack, $needle ) {
		foreach ( $haystack as $key => $value ) {
			if ( $value->family == $needle ) {
				return $key;
			}
		}

		return false;
	}

	/**
	 * Return the list of Google Fonts from our json file. Unless otherwise specfied, list will be limited to 30 fonts.
	 */
	public function radius_docs_getGoogleFonts( $count = 30 ) {
		// Google Fonts json generated from https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=YOUR-API-KEY

		$_font_path   = apply_filters( 'radius_docs_framework_customizer_fonts', 'url' );
		$body_content = '';

		if ( $_font_path === 'url' ) {
			$fontFile = radius_docs_get_assets('customize/google-fonts/google-fonts-popularity.json');
			$request  = wp_remote_get( $fontFile );
			if ( is_wp_error( $request ) ) {
				return '';
			}

			$body_content = wp_remote_retrieve_body( $request );
		}

		$content = json_decode( apply_filters( 'radius_docs_framework_customizer_fonts_change', $body_content ) );

		if ( $count == 'all' ) {
			return $content->items;
		} else {
			return array_slice( $content->items, 0, $count );
		}

		// TODO: IF wp_remote_get not working then below code should apply with code snippets
		// add_filter('radius_docs_framework_customizer_fonts', function (){	return "path"});
		// add_filter('radius_docs_framework_customizer_fonts_change', function (){ $fontFile = radius_docs_get_assets() . '/inc/customize/custom-controls/typography/google-fonts/google-fonts-alphabetical.json'; $get_content = file_get_contents($fontFile); return $get_content;});
	}
}

