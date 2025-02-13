<?php
/**
 * @author  DevOfWP
 * @since   1.0
 * @version 1.0
 */

namespace RT\RadiusDocs\Framework\Customize\Controls;

use WP_Customize_Control;

/**
 * Gallery Control
 * Reference: https://wordpress.stackexchange.com/questions/265603/extend-wp-customizer-to-make-multiple-image-selection-possible
 */

	class GalleryControl extends WP_Customize_Control {

		/**
		 * Button labels
		 */
		public $button_labels = [];

		public $type = 'custom_heading';

		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = [] ) {
			parent::__construct( $manager, $id, $args );
			// Merge the passed button labels with our default labels
			$this->button_labels = wp_parse_args(
				$this->button_labels,
				[
					'add' => esc_html__( 'Add', 'radius-docs-core' ),
				]
			);
		}

		public function enqueue() {
			wp_enqueue_script( 'radius-docs-custom-controls-js', radius_docs_get_assets('customize/js/customizer.js'), [ 'jquery' ], '1.0', true );
			wp_enqueue_style( 'radius-docs-custom-controls-css', radius_docs_get_assets('customize/css/customizer.css'), [], '1.0', 'all' );
		}

		public function render_content() {
			?>
			<?php if ( ! empty( $this->label ) ) { ?>
				<label>
					<span class='customize-control-title'><?php echo esc_html( $this->label ); ?></span>
				</label>
			<?php } ?>
			<div>
				<ul class='images'></ul>
			</div>
			<div class='actions'>
				<a class="button-secondary upload"><?php echo esc_html( $this->button_labels['add'] ); ?></a>
			</div>

			<?php // echo $this->value(); ?>

			<input class="wp-editor-area"
				   name="<?php echo esc_attr( $this->id ); ?>"
				   id="<?php echo esc_attr( $this->id ); ?>"
				   type="text" <?php $this->link(); ?>
				   value="<?php echo esc_attr( $this->value() ); ?>">
			<?php
		}
	}

