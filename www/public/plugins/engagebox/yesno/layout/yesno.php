<?php

/**
 * @package         Engage Box
 * @version         3.2.2 Pro
 * 
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2016 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

defined('_JEXEC') or die('Restricted access');

use Joomla\Registry\Registry;

$box     = $displayData;
$yesno   = new Registry($box->params->get("yesno"));

$buttons = array(
	$yesno->get("yes"), 
	$yesno->get("no")
);

$headline = $yesno->get("headline");
$footer   = $yesno->get("footer");

JFactory::getDocument()->addStyleSheet(JURI::base(true) . "/plugins/engagebox/yesno/media/styles.css");

?>

<div class="ebox-yes-no">
	<div class="ebox-yn-text">
		<?php if (!empty($headline)) { ?>

		<?php 
			$headlineStyles = implode(";", array(
				"font-size:" . $yesno->get("headlinesize") . "px",
				"color:" 	 . $yesno->get("headlinecolor")
			));
		?>

		<div class="ebox-yn-headline" style="<?php echo $headlineStyles ?>">
			<?php echo $headline; ?>
		</div>
		<?php } ?>
	</div>
	
	<div class="ebox-ys-buttons">
		<?php 
			foreach ($buttons as $key => $button)
			{
				include(__DIR__ . "/button.php");
			}
		?>
	</div>

	<?php if (!empty($footer)) { 
		$footerStyles = implode(";", array(
			"font-size:" . $yesno->get("footersize", "11") . "px",
			"color:" 	 . $yesno->get("footercolor", "#ccc")
		));
	?>
	<div class="ebox-ys-footer" style="<?php echo $footerStyles ?>">
		<?php echo $footer; ?>
	</div>
	<?php } ?>
</div>
