(function ($, Drupal) {

  var initialized;

  function init() {
    if (!initialized) {
      $font_link = '"https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"';
      initialized = true;
      $('head').append('<link href=' + $font_link + '>');

      // Check if empty & add text if true
      $empty_check = $('.tasks').text().trim().length;

      if ($empty_check < 1) {
        $('.tasks').text('0 active tasks. Add a new task below');
        $('.clear').css("display", "none");
      }
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

      $('.clear', context).once('clickClear').click(function(){

        // Get the checked tasks
        $checked_tasks = $('i.checked').next();

        // For each checked task, format URL params
        $checked_tasks.each(function(){
          $taskText = $(this).text();
          $taskObj = $(this).parent();
          var taskString = "task=" + $taskText;

          // Send data to route defined in tasklist.routing.yml file
          $.ajax({
            type: "POST",
            data: taskString,
            url: "/admin/tasklist/actions/clear",
            success: function(response) {
              //alert(response);
            },
          });
          $taskObj.hide("1000");
        });

      });
    }
  };

}(jQuery, Drupal, drupalSettings));
