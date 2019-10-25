(function($){
	$(function() {
	// Code goes here
		$('#social-share a').click(function(){
			var w=750;
			var h=450;
			var l = (screen.width/2)-(w/2);
			var t = (screen.height/2)-(h/2);
			window.open(this.href,"Share","location,resizable,scrollbars,width='+w+',height='+h+',top='+t+', left='+l");
			return false;
		});
	});
})(jQuery);