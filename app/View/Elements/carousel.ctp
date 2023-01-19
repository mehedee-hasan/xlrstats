<?php
/**
 * XLRstats : Real Time Player Stats (http://www.xlrstats.com)
 * (CC) BY-NC-SA 2005-2013, Mark Weirath, Özgür Uysal
 *
 * Licensed under the Creative Commons BY-NC-SA 3.0 License
 * Redistributions of files must retain the above copyright notice.
 *
 * @link          http://www.xlrstats.com
 * @license       Creative Commons BY-NC-SA 3.0 License (http://creativecommons.org/licenses/by-nc-sa/3.0/)
 * @package       app.View.Elements
 * @since         XLRstats v3.0
 * @version       0.1
 */

$files = $this->XlrFunctions->getCarouselImages();
//pr($files);

?>
<script type="text/javascript">
	$(function(){
		$('.carousel').carousel();
	});
</script>

<div class="row">
	<div class="span12 game-image">
		<div class="stretch">
			<div id="myCarousel" class="carousel slide">
				<!-- Carousel items -->

			</div>
		</div>
	</div>
</div>
