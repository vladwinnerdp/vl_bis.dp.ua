if(jQuery(function(e){function t(t){return body=parseInt(e("body").css(t)||0),html=parseInt(e("html").css(t)||0),body+html}e(document).on("eboxInit",function(){$mats=e(".rstboxes .welcomemat"),$mats.length&&($mats.each(function(t,o){$mat=e(o),$mat.css({height:$mat.css("height")}),$mat.on("beforeOpen",function(){window.scrollTo(0,0)}),$mat.on("afterOpen",function(){e("html").addClass("eboxWelcomeMat")}).on("afterClose",function(){e("html").removeClass("eboxWelcomeMat")})}),e("<div>").addClass("rstboxes eboxWelcomeMats").prependTo("body").css({margin:[-(t("padding-top")+t("margin-top")+t("border-top-width")),-(t("padding-right")+t("margin-right")+t("border-right-width")),0,-(t("padding-left")+t("margin-left")+t("border-left-width"))].join("px ")+"px"}),$mats.appendTo(e("body .eboxWelcomeMats")))})}),void 0===rstbox)var rstbox={};void 0===rstbox.jQuery&&(rstbox.jQuery=jQuery.noConflict()),function(e){e(document).ready(function(){var t="[RSTBox]",o=e(".rstboxes").last();if(o.children().length){var n="rstbox_"+o.data("site")+"_",i=(e(window).height(),e(document).height(),o.data("debug"));e("*[data-ebox], *[data-ebox-cmd]").on("click",function(t){if(boxID=parseInt(e(this).data("ebox")),box=boxID?e(".rstboxes > #rstbox_"+boxID).first():e(this).closest("div.rstbox"),box){switch(e(this).data("ebox-cmd")){case"open":box.trigger("open");break;case"close":box.trigger("close");break;case"closeKeep":box.trigger("closeKeep");break;default:box.is(":visible")?box.trigger("close"):box.trigger("open")}"0"!=e(this).data("ebox-prevent")&&t.preventDefault()}}),e("*[data-rstbox], *[data-rstbox-command], *[data-rstbox-cmd]").on("click",function(t){if(boxID=parseInt(e(this).data("rstbox")),boxID?box=e(".rstboxes > #rstbox_"+boxID).first():box=e(this).closest("div.rstbox"),box){var o=e(this).data("rstbox-cmd");switch(boxCommand=void 0!==o&&!1!==o?o:e(this).data("rstbox-command"),boxCommand){case"open":box.trigger("open");break;case"close":box.trigger("close");break;case"closeKeep":box.trigger("closeKeep");break;default:box.is(":visible")?box.trigger("close"):box.trigger("open")}"0"!=e(this).data("rstbox-prevent")&&t.preventDefault()}}),o.find("> .rstbox").each(function(){var t=e(this),o=t.attr("id").replace("rstbox_",""),n=0,d=t.data("trigger").split(":")[0],u="pageload"!=d&&t.data("trigger").split(":")[1],f=l(o),g="1"==r(t,"testmode",0);if(t.on("open",function(){c(t,!0)}),t.on("close",function(){c(t,!1)}),t.on("closeKeep",function(){var e;c(e=t,!1),g||(cookieType=e.data("cookietype"),"session"==cookieType&&(s(o,"session"),a("Box "+o+" Session cookie set")),"ever"==cookieType&&(s(o,"ever"),a("Box "+o+" Cookie set for ever")),"seconds"!=cookieType&&"minutes"!=cookieType&&"days"!=cookieType&&"hours"!=cookieType||(cook=parseInt(e.data("cookie")),cook>0&&(s(o,e.data("cookietype"),cook),a("Box "+o+" Cookie set for "+cook+" "+e.data("cookietype")))))}),t.on("setCookie",function(e,t,n){s(o,t,n)}),t.on("beforeOpen",function(){ovrl=r(t,"overlay"),ovrl&&(e("#overlay_rstbox_"+o).length||(overlay=ovrl.split(":"),overlayObject=e("<div/>",{id:"overlay_"+t.attr("id"),class:"rstbox_overlay",css:{"background-color":overlay[0]}}).insertAfter(t),overlayClick=parseInt(overlay[1]),overlayClick&&overlayObject.on("click",function(){t.trigger("closeKeep")}),t.on("beforeClose",function(){t.next(".rstbox_overlay").remove()})))}),t.on("beforeOpen",function(){parseInt(r(t,"preventpagescroll",0))&&e("html").addClass("eboxPageNoScroll")}),t.on("afterOpen",function(){t.addClass("rstbox_visible"),e("body").addClass(t.attr("id")),a("Box "+o+" opened")}),t.on("afterClose",function(){t.removeClass("rstbox_visible"),e("body").removeClass(t.attr("id")),e("html").removeClass("eboxPageNoScroll"),a("Box "+o+" closed")}),g&&a("Box "+o+" is on test mode"),!f||g){if("element"==d){if(0==(h=e(u).filter(":first")).length)return void a("Box "+o+" Can't find element \""+u+'". Not showing box.');var b="load resize scroll.box"+parseInt(o),p=0!=parseInt(r(t,"autohide",0));(x=function(){l(o)||(n&&clearTimeout(n),n=window.setTimeout(function(){!function(e){"function"==typeof jQuery&&e instanceof jQuery&&(e=e[0]);var t=e.getBoundingClientRect();return t.top>=0&&t.left>=0&&t.bottom<=(window.innerHeight||document.documentElement.clientHeight)&&t.right<=(window.innerWidth||document.documentElement.clientWidth)}(h)?c(t,!1):(p||e(window).off(b,x),c(t,!0))},50))})(),e(window).on(b,x),t.on("afterClose",function(){l(o)&&(a("Box "+o+" Unbinding Scroll Check"),e(window).off(b,x))})}if("pageheight"==d){b="load resize scroll.box"+parseInt(o),p=0!=parseInt(r(t,"autohide",0));var x,m=parseInt(u);a("Box "+o+" is going to be triggered on "+m+"% of page height."),(x=function(){l(o)||(n&&clearTimeout(n),n=window.setTimeout(function(){e(window).scrollTop()/(e(document).height()-e(window).height())*100>m?(p||e(window).off(b,x),t.is(":visible")||c(t,!0)):t.is(":visible")&&p&&c(t,!1)},50))})(),e(window).on(b,x),t.on("afterClose",function(){l(o)&&e(window).off(b,x)})}if("userleave"==d&&(a("Box "+o+" is going to be triggered on user leave"),e(document).ExitIntent({timer:r(t,"exittimer",1e3),debug:i,callback:function(){l(o)||c(t,!0)}})),"pageready"==d){if(l(o))return;a("Box "+o+" is going to be triggered at page ready"),c(t,!0)}if("pageload"==d&&e(window).on("load",function(){l(o)||(a("Box "+o+" is going to be triggered at page load"),c(t,!0))}),"elementHover"==d){var h=e(u),v=r(t,"delay",30);0==h.length?a("Box "+o+" Can't find element \""+u+'". Not showing box.'):(a("Box "+o+" will be trigger at "+u+"hover"),h.on({mouseover:function(){n=setTimeout(function(){l(o)||c(t,!0)},v)},mouseout:function(){clearTimeout(n)}}),t.on("afterClose",function(){l(o)&&(a("Box "+o+" Unbinding MouseOver & MouseOut events"),h.off("mouseover mouseout"))}))}if("onclick"==d)0==!(h=e(r(t,"triggerelement"))).length&&(h.on("click",function(e){l(o)||(c(t,!0),parseInt(r(t,"triggerpreventdefault","1"))>0&&e.preventDefault())}),a("Box "+o+" will be triggered on click"));"ondemand"==d&&a("Box "+o+" will be triggered on demand"),function(e){if(e){if(location.hash.replace("#","")==e.replace("#",""))return a("hashtags match"),!0;a("hashtags does not match")}}(r(t,"triggerbyhash"))&&c(t,!0);var y=r(t,"autoclose",0);y>0&&(a("Box "+o+" will be auto-closed after "+y+" miliseconds"),t.on("afterOpen",function(){setTimeout(function(){t.trigger("closeKeep")},y)})),parseInt(r(t,"closeopened",0))>0&&t.on("beforeOpen",function(){e(".rstbox").trigger("close")})}else a("Box "+o+" is hidden by cookie")}),e(document).trigger("eboxInit",[o])}else console.log(t+" Can't find any boxes on this page. Exiting..");function a(e){e&&i&&(console=window.console||{log:function(){}},console.log(t+" "+e))}function r(e,t,o){if(t&&(obj=e.data("settings"),obj)){for(var n=t.split(".");n.length&&(obj=obj[n.shift()]););return"undefined"==typeof obj&&void 0!==o?o:obj}}function s(e,t,o){var i="";if("session"!=t){var a,r=new Date,s=r.getTime();switch(t){case"days":a=24*o*60*60;break;case"hours":a=60*o*60;break;case"minutes":a=60*o;break;case"seconds":a=o;break;case"ever":a=31536e4;break;case"remove":a=-1}r.setTime(s+1e3*a);i="; expires="+r.toGMTString()}document.cookie=n+e+"=true"+i+"; path=/"}function l(e){for(var t=n+e+"=",o=document.cookie.split(";"),i=0;i<o.length;i++){for(var a=o[i];" "==a.charAt(0);)a=a.substring(1,a.length);if(0==a.indexOf(t))return a.substring(t.length,a.length)}return null}function c(t,o){var n=(n=t.attr("id")).replace("rstbox_","");if(void 0!==t)if(t.hasClass("triggering"))a("Box "+n+" is already triggered");else if(o&&t.is(":visible"))a("Box "+n+" is already opened");else{if(o||!t.is(":hidden")){a("Box "+n+" is going to "+(o?"open":"close")+"!");var i=r(t,"transitionin","fadeIn"),s=r(t,"transitionout","fadeOut"),l=o?i:s,c=o?r(t,"delay",0):0,d=r(t,"duration","400");return t.addClass("triggering"),t.velocity(l,{delay:c,duration:d,begin:function(i){var a=o?"beforeOpen":"beforeClose";t.trigger(a),e(document).trigger("eboxBefore"+a.replace("before",""),[n,t]),o&&l.indexOf("callout.")>-1&&t.css({display:"block",opacity:"1"})},complete:function(i){var a=o?"afterOpen":"afterClose";t.trigger(a),e(document).trigger("eboxAfter"+a.replace("after",""),[n,t]),t.removeClass("triggering")}}),o}a("Box "+n+" is already closed")}else a("Box "+n+" is not present in the current page.")}})}(rstbox.jQuery),function(e,t,o,n){var i="ExitIntent",a={sensitivity:0,timer:1e3,delay:0,aggressive:!1,callback:null,debug:!1},r=!1,s=null;function l(t,o){this.options=e.extend({},a,o);var n=this;setTimeout(function(){n.init()},n.options.timer)}l.prototype.init=function(){this.options;var t=this;this.log("Init after "+this.options.timer),e(o).on("mouseout.exitintent",function(e){var o=!e.relatedTarget&&!e.toElement&&e.clientY<50;o&&(s=setTimeout(function(){t.fire()},t.options.delay)),t.log("Event: mouseout, Pass: "+o)}),this.options.sensitivity>0&&e(o).on("mousemove.exitintent",function(e){e.clientY<=t.options.sensitivity&&(t.log("Event: MouseMove"+e.clientY),s=setTimeout(function(){t.fire()},t.options.delay))}),e(o).on("mouseenter.exitintent",function(e){t.log("Event: mouseenter"),t.cleartimer()})},l.prototype.cleartimer=function(){s&&(this.log("Clearing Timer"),clearTimeout(s),s=null)},l.prototype.fire=function(){r||(this.log("Fire!"+s),"function"==typeof this.options.callback&&this.options.callback.call(this),this.options.aggressive||this.stop())},l.prototype.log=function(e){this.options.debug&&console.log("[Exit Intent] "+e)},l.prototype.stop=function(){this.log("Destroy"),e(o).off("mousemove.exitintent"),e(o).off("mouseout.exitintent"),e(o).off("mouseenter.exitintent"),r=!0},e.fn[i]=function(t){return this.each(function(){e.data(this,"plugin_"+i)||e.data(this,"plugin_"+i,new l(this,t))})}}(jQuery,window,document),function(e){var t,o,n,i={LOG_PREFIX:"EngageBox Google Analytics Tracking",LOAD_GA:"Loading Google Analytics library",INVALID_GA_ID:"Please provide a valid Google Analytics ID",INVALID_CAT:"Please provide a valid Event category"};function a(e){t.data("debug")&&console.log(i.LOG_PREFIX+": "+e)}e(document).on("eboxInit",function(r,s){t=s,track=s.data("tracking"),track&&(trackingInfo=track.split(":"),(o=trackingInfo[0])?(n=trackingInfo[1])?e(document).on("eboxAfterOpen eboxAfterClose",function(e,t,r){var s,l,c,d,u,f,g,b,p,x=e.type.replace("eboxAfter","");g=x,b=t,p=r,s=function(){var e="Box #"+b+" - "+p.data("title");gaBox("send","event",{eventCategory:n,eventAction:g,eventLabel:e,hitCallback:function(){a(g+" "+e)}})},"undefined"==typeof gaBox?(a(i.LOAD_GA),l=window,c=document,d="gaBox",l.GoogleAnalyticsObject=d,l[d]=l[d]||function(){(l[d].q=l[d].q||[]).push(arguments)},l[d].l=1*new Date,u=c.createElement("script"),f=c.getElementsByTagName("script")[0],u.async=1,u.src="//www.google-analytics.com/analytics.js",f.parentNode.insertBefore(u,f),gaBox("create",o,"auto"),gaBox("require","displayfeatures"),gaBox(function(){s()})):gaBox(function(){s()})}):a(i.INVALID_CAT):a(i.INVALID_GA_ID))})}(jQuery),function(e){var t,o={LOG_PREFIX:"EngageBox Event Logging",NO_BOXES_FOUND:"No boxes found. Abort",SUCCESS:"Success",FAIL:"Fail",GENERAL_ERROR:"General Error - Make sure your browser accepts cookies!",DISABLED:"Is disabled",INITIALIZED:"Plugin initialized successfully"};function n(e){t.data("debug")&&console.log(o.LOG_PREFIX+": "+e)}e(document).on("eboxAfterOpen",function(i,a,r){boxSettings=r.data("settings"),disableLog=0==parseInt(boxSettings.log),testMode=1==parseInt(boxSettings.testmode),testMode||disableLog||function(i,a){t=e(".rstboxes").last();var r={plugin:"rstbox",task:"track"};r.box=a,r.event=i,r[t.data("t")]=1,e.ajax({type:"POST",url:t.data("baseurl")+"index.php?option=com_ajax&format=raw",data:r,async:!0,dataType:"json",success:function(e){var t=e.status,i="Event #"+e.eventid+" - Box #"+e.box;n(t?o.SUCCESS+":"+i:o.FAIL+":"+i)},error:function(){n(o.GENERAL_ERROR)}})}(1,a)})}(jQuery),function(e){"function"==typeof e.Velocity.RegisterEffect&&(e.Velocity.RegisterEffect("rstbox.slideUpIn",{defaultDuration:450,calls:[[{translateY:"100%",opacity:1},.05],[{translateY:0},.95]]}),e.Velocity.RegisterEffect("rstbox.slideUpOut",{defaultDuration:450,calls:[[{translateY:"100%"},.95],[{opacity:0},.05]]}),e.Velocity.RegisterEffect("rstbox.slideDownIn",{defaultDuration:450,calls:[[{translateY:"-100%",opacity:1},.05],[{translateY:0},.95]]}),e.Velocity.RegisterEffect("rstbox.slideDownOut",{defaultDuration:450,calls:[[{translateY:"-100%"},.95],[{opacity:0},.05]]}),e.Velocity.RegisterEffect("rstbox.slideLeftIn",{defaultDuration:450,calls:[[{translateX:"-100%",opacity:1},.05],[{translateX:0},.95]]}),e.Velocity.RegisterEffect("rstbox.slideLeftOut",{defaultDuration:450,calls:[[{translateX:"-100%"},.95],[{opacity:0},.05]]}),e.Velocity.RegisterEffect("rstbox.slideRightIn",{defaultDuration:450,calls:[[{translateX:"100%",opacity:1},.05],[{translateX:0},.95]]}),e.Velocity.RegisterEffect("rstbox.slideRightOut",{defaultDuration:450,calls:[[{translateX:"100%"},.95],[{opacity:0},.05]]}))}(jQuery);
