<?php
/**
 * @author  DevOfWP
 * @since   1.0
 * @version 1.0
 */

namespace RT\RadiusDocs\Framework\Customize\Controls;

use WP_Customize_Control;

/**
 * Text Radio Button Custom Control
 */
class TextRadioControl extends WP_Customize_Control {
	/**
	 * The type of control being rendered
	 */
	public $type = 'text_radio_button';

	/**
	 * Enqueue our scripts and styles
	 */
	public function enqueue() {
		wp_enqueue_style( 'radius-docs-custom-controls-css', radius_docs_get_assets('customize/css/customizer.css'), [], '1.0', 'all' );
	}

	/**
	 * Render the control in the customizer
	 */
	public function render_content() {
		?>
		<div class="text_radio_button_control">
			<?php if ( ! empty( $this->label ) ) { ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php } ?>
			<?php if ( ! empty( $this->description ) ) { ?>
				<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php } ?>

			<div class="radio-buttons">
				<?php foreach ( $this->choices as $key => $value ) { ?>
					<label class="radio-button-label">
						<input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
						<span><?php echo esc_html( $value ); ?></span>
					</label>
				<?php } ?>
			</div>
		</div>
		<?php
	}
}

