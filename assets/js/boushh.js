(function ($, Drupal) {

//Change &amp;, &#039; and &quot; to &, ' and " in select list options
$('select option').each(function() {
  var text = $(this).text();
  var replaced = text.replace(/&amp;/g , "&").replace(/&#039;/g , "'").replace(/&quot;/g , '"');
  $(this).text(replaced);
});

Drupal.behaviors.boushh = {
  attach: function(context, settings) {
    $('.ief-form-wrapper', context).once(function(){
      var self = this;

      $('.ief-form-actions button', self).on('mousedown', function(){
        $(self).removeClass('ief-animate');
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
