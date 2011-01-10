// This file requires jQuery to be loaded

$(document).ready(function() {

  // This function is useful for showing or hiding the filter table
  $('#filter_showhide').click(function() {
    $('.sf_admin_filter tbody, .sf_admin_filter tfoot').toggle();
  });
});


