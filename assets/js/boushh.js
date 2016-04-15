(function ($, Drupal) {

// Drupal.behaviors.boushh = {
//   attach: function(context, settings) {
//   }
// };

Drupal.behaviors.boushhIef = {
  attach: function(context, settings) {
    $('.ief-form-wrapper', context).once(function(){
      var self = this;
      $('body').addClass('has-ief');

      $('.ief-form-actions button', self).on('mousedown', function(){
        $(self).removeClass('ief-animate');
        $('body').removeClass('has-ief');
      });

      $(self).click(function(e){
        if($(e.target).hasClass('ief-form-wrapper')){
          $('.ief-edit-cancel', self).first().trigger('mousedown');
        }
      });

      setTimeout(function(){
        $(self).addClass('ief-animate');
      });
    });
  }
};

})(jQuery, Drupal);
