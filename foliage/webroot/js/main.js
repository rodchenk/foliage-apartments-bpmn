$(document).ready(function(){
	var nowDate = new Date();
	var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
	var picker = $('#daterangepicker1').daterangepicker({
	  "parentEl": "#daterangepicker1-container",
	  "autoApply": true,
	  minDate: new Date() 
	});
	// range update listener
	picker.on('apply.daterangepicker', function(ev, picker) {
	  $("#daterangepicker-result").html('Selected date range: ' + picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
	  $('#from-date').val(picker.startDate.format('YYYY-MM-DD'));
	  $('#to-date').val(picker.endDate.format('YYYY-MM-DD'));
	});
	// prevent hide after range selection
	picker.data('daterangepicker').hide = function () {};
	// show picker on load
	picker.data('daterangepicker').show();

	var hidden_date = $('.drp-selected').eq(0);
	$(hidden_date).on('change', function(){
		console.log('changed');
	});
});

