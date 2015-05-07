/* custom js functions */

//show password
$('.show-password').mousedown(function(){
	$(this).prev().attr('type','text');
});

$('.show-password').mouseup(function(){
	$(this).prev().attr('type','password');
});

//init tooltip
$('.tooltips').tooltip({
	container:'body'
	});

//init popover
$('.popinfo').popover({
    html:true
});