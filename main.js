$(document).ready(function() {

   //  $('.tabs .tab-links a').on('click', function(e)  {
   //      var currentAttrValue = $(this).attr('href');


 
   //      // Show/Hide Tabs
   //      // $('.tabs ' + currentAttrValue).show().siblings().hide();
   //      $('.tabs ' + currentAttrValue).fadeIn(400).siblings().hide();
 
   //      // Change/remove current tab to active
   //      $(this).parent('li').addClass('active').siblings().removeClass('active');
 		
 		// // console.log(this);

   //      e.preventDefault();
   //  });

    $('#searchForm').on('submit', function(e){
    	$(this).addClass('active');
    	// e.preventDefault(e);
    });

	// function test() {
 //  		// do stuff
 //  		$(this).addClass('active');
 //  		e.preventDefault(e);
	// }

	// $('#toggleFlip').click(function(){
	// 	$('#photo').flip();
	// });

	function flip(){
		$(this).toggleClass("active");
		// "#flip-toggle"
	};
	

});