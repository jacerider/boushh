(function ($, Drupal) {

Drupal.behaviors.boushhAdmin = {
  attach: function(context, settings) {
    $('#boushh-theme-select a').click(function(e){
      var $this, value;
      e.preventDefault();
      $this = $(this);

      $('#boushh-theme-select a').removeClass('active');
      $this.addClass('active');

      value = $this.attr('data-bg');
      $('#edit-boushh-bg').val(value);
      $('.form-item-boushh-bg i').css({color:value});

      value = $this.attr('data-primary');
      $('#edit-boushh-primary').val(value);
      $('.form-item-boushh-primary i').css({color:value});

      value = $this.attr('data-secondary');
      $('#edit-boushh-secondary').val(value);
      $('.form-item-boushh-secondary i').css({color:value});
    });
  }
};

})(jQuery, Drupal);
