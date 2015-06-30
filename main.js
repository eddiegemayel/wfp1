//wait for document to load and be ready before executing any code
$(document).ready(function() {

  //prevents special characters being entered
	$('input').bind('keypress', function (event) {
    var regex = new RegExp("^[a-zA-Z0-9]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
  });

  //if deleting multiple photos select input is clicked on
  $( "#deleteMultiple" ).bind({
    //if it's clicked on, show the delete button
    click: function() {
      $("#delete").removeClass("hidden").addClass("visible");
    },
    //if user clicks out of select input field, hide button again
    focusout: function(){
      $("#delete").removeClass("visible").addClass("hidden");
    }
  });

});