(function ($, Drupal) {

  Drupal.behaviors.verticalTabsHeight = {
    attach: function(context, settings) {
      var highestCol = Math.max($('.vertical-tabs-list').height(),$('.vertical-tabs-list').height());
	  jQuery('.vertical-tabs-panes').css("min-height",highestCol);
    }
  };

})(jQuery, Drupal);