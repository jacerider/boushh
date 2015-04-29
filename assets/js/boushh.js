(function ($, Drupal) {

Drupal.behaviors.boushh = {
  attach: function(context, settings) {
    $('.form-item, .form-wrapper').addClass(function() {
      var $parent = $(this.parentNode).closest('fieldset, .fieldset-wrapper, .form-item, .form-wrapper');
      return $parent.hasClass('boushh-inset') ? 'boushh-outset' : 'boushh-inset';
    });
  }
};

})(jQuery, Drupal);
