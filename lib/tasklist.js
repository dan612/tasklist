(function ($, Drupal) {

  Drupal.behaviors.tasklistBehavior = {
    attach: function (context, settings) {
      
      $('.task', context).once('removeTask').click(function() {
        $text = $(this).text();
        console.log($text);
      });
    }
  };

}(jQuery, Drupal, drupalSettings));
