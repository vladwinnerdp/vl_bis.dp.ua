<?php

/**
 * @package         Convert Forms
 * @version         2.0.10 Pro
 * 
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2018 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

defined('_JEXEC') or die('Restricted access');

extract($displayData);

?>

<div <?php echo trim($boxattributes) ?>>
	<form name="cf<?php echo $id; ?>" id="cf<?php echo $id; ?>" method="post" action="#">
		<?php if ($hascontent) { ?>
		<div class="cf-content-wrap cf-col-16 <?php echo $contentclasses ?>">
			<div class="cf-content cf-col-16">
				<?php if (isset($image)) { ?>
					<div class="cf-content-img cf-col-16 cf-text-center <?php echo $imagecontainerclasses; ?>">
						<img 
							alt="<?php echo $params->get("imagealt"); ?>"
							class="<?php echo implode(" ", $imageclasses) ?>" 
							style="<?php echo implode(";", $imagestyles) ?>"
							src="<?php echo $image ?>"
						/>
					</div>
				<?php } ?>
				<?php if (!$textIsEmpty) { ?>
				<div class="cf-content-text cf-col <?php echo $textcontainerclasses; ?>" >
					<?php echo $params->get("text"); ?>
				</div>
				<?php } ?>
			</div>
		</div>
		<?php } ?>
		<div class="cf-form-wrap cf-col-16 <?php echo implode(" ", $formclasses) ?>" style="<?php echo implode(";", $formstyles) ?>">
			<div class="cf-response"></div>
			
			<?php if (isset($fields)) { ?>
				<div class="cf-fields">
					<?php echo $fields; ?>
				</div>
			<?php } ?>

			<?php if (!$footerIsEmpty) { ?>
			<div class="cf-footer">
				<?php echo $params->get("footer"); ?>
			</div>
			<?php } ?>
		</div>

		<input type="hidden" name="cf[form_id]" value="<?php echo $id ?>">	

		<?php 
			echo JHtml::_('form.token'); 
			echo $params->get('customcode', '');
		?>
	</form>
</div>

<?php 
    if (isset($styles))
    {
    	echo '<style>' . implode('\n', $styles) . '</style>';
    }
?>