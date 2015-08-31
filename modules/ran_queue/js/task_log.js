(function ($) {
  if ( $( ".view-task-log" ).length ) {
    // Add a form element to control scrolling and refreshing behaviour.
    $('.view-task-log').parent().prepend('<div id="task_log_controls"><form><input type="checkbox" name="refresh_task_log" checked="checked">Auto-refresh task log.<br /><input type="checkbox" name="follow_task_log" checked="checked">Follow task log.</form></div>');

    // Put controls at the upper right of the task log.
    $( "#task_log_controls" ).position({
      my: "right-10 top+10",
      at: "right top",
      of: ".view-task-log",
    });

    // Make controls scroll to stay on screen.
    var offsetPixels = 300;
    $(window).scroll(function() {
      if ($(window).scrollTop() > offsetPixels) {
        $( "#task_log_controls" ).position({
          my: "right-62 top+152",
          at: "right top",
          of: window,
        });
      } else {
        $( "#task_log_controls" ).position({
          my: "right-10 top+10",
          at: "right top",
          of: ".view-task-log",
        });
      }
    });

    // Schedule a refresh for every few seconds.
    var refresh_log;
    function autorefresh_log() {
      if ($('input[name=refresh_task_log]').prop('checked')) {
        refresh_log = setInterval(function() {
          // Stop scrolling to the top of the view.
          delete Drupal.AjaxCommands.prototype.viewsScrollTop;
          if ($('input[name=follow_task_log]').prop('checked')) {
            $("html, body").animate({ scrollTop: $(document).height() }, 1000);
          }
          $('.view-task-log').trigger('RefreshView');
        }, 2000);
      }
      else {
        clearTimeout(refresh_log);
      }
    }
    $('input[name=refresh_task_log]').bind("click", autorefresh_log);
    autorefresh_log();

  }
})(jQuery);

