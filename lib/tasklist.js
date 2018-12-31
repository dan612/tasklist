(function ($, Drupal) {

  var initialized;

  function init() {
    if (!initialized) {
      $font_link = '"https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"';
      initialized = true;
      $('head').append('<link href=' + $font_link + '>');
    }
  }

  Drupal.behaviors.tasklistBehavior = {
    attach: function (context, settings) {
      init();
      $('.cust-checkbox', context).once('clickTask').click(function() {
        // $text = $(this).text();
        $box = $(this).find("i");
        if ($box.hasClass("checked")) {
          $box.text("check_box_outline_blank").removeClass("checked");
        } else {
          $box.text("check_box").addClass("checked");
        }
      });
    }
  };

}(jQuery, Drupal, drupalSettings));
