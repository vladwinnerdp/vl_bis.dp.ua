/**
 *  @package         Convert Forms
 *  @version         2.0.10 Pro
 * 
 *  @author          Tassos Marinos <info@tassos.gr>
 *  @link            http://www.tassos.gr
 *  @copyright       Copyright © 2018 Tassos Marinos All Rights Reserved
 *  @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
 *  
 *  Each reCAPTCHA user response token should be used only once. 
 *  
 *  If a verification attempt has been made with a particular token, it cannot be used again
 *  and we need to reset the CAPTCHA widget and ask the end user to verify it again.
 */

jQuery(function($) {
	'use strict';
	$(window).on("convertFormsAfterSubmit", function(event, form) {
		var $form    = $(form),
			response = $form.find(".g-recaptcha-response").val(),
			widgetID = $form.find(".nr-recaptcha").attr("data-widgetid");

		if (widgetID) {
			grecaptcha.reset(widgetID);
		}
	})
})