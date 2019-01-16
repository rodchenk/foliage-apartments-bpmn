$(document).ready(function(){
	var picker = $('#daterangepicker1').daterangepicker({
	  "parentEl": "#daterangepicker1-container",
	  "autoApply": true,
	});
	// range update listener
	picker.on('apply.daterangepicker', function(ev, picker) {
	  $("#daterangepicker-result").html('Selected date range: ' + picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
	});
	// prevent hide after range selection
	picker.data('daterangepicker').hide = function () {};
	// show picker on load
	picker.data('daterangepicker').show();
	});