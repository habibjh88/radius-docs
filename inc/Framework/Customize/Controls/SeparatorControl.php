<?php
/**
 * @author  DevOfWP
 * @since   1.0
 * @version 1.0
 */

namespace RT\RadiusDocs\Framework\Customize\Controls;

use WP_Customize_Control;

/**
 * Separator Custom Control
 */
class SeparatorControl extends WP_Customize_Control {

	public $type = 'separator';

	public function render_content() {
		?>
		<p>
		<hr/></p>
		<?php
	}
}
