(function($,sr){
    var debounce = function (func, threshold, execAsap) {
      var timeout;

        return function debounced () {
            var obj = this, args = arguments;
            function delayed () {
                if (!execAsap)
                    func.apply(obj, args);
                timeout = null;
            }

            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);

            timeout = setTimeout(delayed, threshold || 100);
        };
    };

    // smartresize
    jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');

var CURRENT_URL = window.location.href.split('#')[0].split('?')[0],
    $BODY = $('body'),
    $MENU_TOGGLE = $('#menu_toggle'),
    $SIDEBAR_MENU = $('#sidebar-menu'),
    $SIDEBAR_FOOTER = $('.sidebar-footer'),
    $LEFT_COL = $('.left_col'),
    $RIGHT_COL = $('.right_col'),
    $NAV_MENU = $('.nav_menu'),
    $FOOTER = $('footer');

var TOTAL_UPLOADS = 0,
	TOTAL_DOWNLOADS = 0,
	UPLOAD_REQUESTS = 0,
	TOTAL_USERS = 0,
	USERS_ONLINE = 0,
	ACCEPTED_REQUESTS = 0,
	REJECTED_REQUESTS = 0,
	UPLOAD_FOLDER_SIZE = 0,
	TV_SERIES = 0,
	MUSIC = 0,
	IMAGE = 0,
	TUTORIAL = 0,
	MOVIES = 0,
	SOFTWARE = 0,
	STUDIES = 0,
	TOTAL_SPACE = 0,
	FREE_SPACE = 0,
	CONSUMED = 0,
	FREE = 0;

keys = Array();
values = Array();

colors = Array('#E74C3C', 'purple', 'blue', 'aero', 'orange', 'orange', 'blue', 'yellow');
colorHex = Array('#BDC3C7', '#9B59B6', '#4285f4', '#26B99A', '#3498DB', 'orangered', 'aqua', 'skyblue');
colorHover = Array('#CFD4D8', '#B370CF', '#42A5FF', '#36CAAB', '#49A9EA', 'orangered', 'aqua', 'skyblue');

function init_sidebar() {
	// TODO: This is some kind of easy fix, maybe we can improve this
	var setContentHeight = function () {
		// reset height
		$RIGHT_COL.css('min-height', $(window).height());

		var bodyHeight = $BODY.outerHeight(),
			footerHeight = $BODY.hasClass('footer_fixed') ? -10 : $FOOTER.height(),
			leftColHeight = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
			contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;

		// normalize content
		contentHeight -= $NAV_MENU.height() + footerHeight;

		$RIGHT_COL.css('min-height', contentHeight);
	};

	$SIDEBAR_MENU.find('a').on('click', function(ev) {
		var $li = $(this).parent();

		if ($li.is('.active')) {
			$li.removeClass('active active-sm');
			$('ul:first', $li).slideUp(function() {
				setContentHeight();
			});
		} else {
			// prevent closing menu if we are on child menu
			if (!$li.parent().is('.child_menu')) {
				$SIDEBAR_MENU.find('li').removeClass('active active-sm');
				$SIDEBAR_MENU.find('li ul').slideUp();
			} else {
				if ( $BODY.is( ".nav-sm" ) ) {
					$SIDEBAR_MENU.find( "li" ).removeClass( "active active-sm" );
					$SIDEBAR_MENU.find( "li ul" ).slideUp();
				}
			}

			$li.addClass('active');
			$('ul:first', $li).slideDown(function() {
				setContentHeight();
			});
		}
	});

	// toggle small or large menu
	$MENU_TOGGLE.on('click', function() {


			if ($BODY.hasClass('nav-md')) {
				$SIDEBAR_MENU.find('li.active ul').hide();
				$SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
			} else {
				$SIDEBAR_MENU.find('li.active-sm ul').show();
				$SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
			}

		$BODY.toggleClass('nav-md nav-sm');

		setContentHeight();

		$('.dataTable').each ( function () { $(this).dataTable().fnDraw(); });
	});

	// check active menu
	$SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('current-page');

	$SIDEBAR_MENU.find('a').filter(function () {
			return this.href == CURRENT_URL;
		}).parent('li').addClass('current-page').parents('ul').slideDown(function() {
			setContentHeight();
		}).parent().addClass('active');

	// recompute content when resizing
	$(window).smartresize(function(){
		setContentHeight();
	});

	setContentHeight();

	// fixed sidebar
	if ($.fn.mCustomScrollbar) {
		$('.menu_fixed').mCustomScrollbar({
			autoHideScrollbar: true,
			theme: 'minimal',
			mouseWheel:{ preventDefault: true }
		});
	}
};

var randNum = function() {
	return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
};

$('table input').on('ifChecked', function () {
    checkState = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('table input').on('ifUnchecked', function () {
    checkState = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});

if (typeof NProgress != 'undefined') {
    $(document).ready(function () {
        NProgress.start();
    });

    $(window).load(function () {
        NProgress.done();
    });
}

function gd(year, month, day) {
	return new Date(year, month - 1, day).getTime();
}

function init_flot_chart(){
	if( typeof ($.plot) === 'undefined'){ return; }

	var arr_data1 = [
		[gd(2012, 1, 1), 17],
		[gd(2012, 1, 2), 74],
		[gd(2012, 1, 3), 6],
		[gd(2012, 1, 4), 39],
		[gd(2012, 1, 5), 20],
		[gd(2012, 1, 6), 85],
		[gd(2012, 1, 7), 7]
	];

	var arr_data2 = [
	  [gd(2012, 1, 1), 82],
	  [gd(2012, 1, 2), 23],
	  [gd(2012, 1, 3), 66],
	  [gd(2012, 1, 4), 9],
	  [gd(2012, 1, 5), 119],
	  [gd(2012, 1, 6), 6],
	  [gd(2012, 1, 7), 9]
	];

	var chart_plot_01_settings = {
	  series: {
		lines: {
		  show: false,
		  fill: true
		},
		splines: {
		  show: true,
		  tension: 0.4,
		  lineWidth: 1,
		  fill: 0.4
		},
		points: {
		  radius: 0,
		  show: true
		},
		shadowSize: 2
	  },
	  grid: {
		verticalLines: true,
		hoverable: true,
		clickable: true,
		tickColor: "#d5d5d5",
		borderWidth: 1,
		color: '#fff'
	  },
	  colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
	  xaxis: {
		tickColor: "rgba(51, 51, 51, 0.06)",
		mode: "time",
		tickSize: [1, "day"],
		//tickLength: 10,
		axisLabel: "Date",
		axisLabelUseCanvas: true,
		axisLabelFontSizePixels: 12,
		axisLabelFontFamily: 'Verdana, Arial',
		axisLabelPadding: 10
	  },
	  yaxis: {
		ticks: 8,
		tickColor: "rgba(51, 51, 51, 0.06)",
	  },
	  tooltip: false
	}

	if ($("#chart_plot_01").length){


		$.plot( $("#chart_plot_01"), [ arr_data1, arr_data2 ],  chart_plot_01_settings );
	}
}

function init_chart_doughnut(){

	if( typeof (Chart) === 'undefined'){ return; }

	if ($('.canvasDoughnut').length){

		var chart_doughnut_settings = {
			type: 'doughnut',
			tooltipFillColor: "rgba(51, 51, 51, 0.55)",
			data: {
				labels: keys,
				datasets: [{
					data: values,
					backgroundColor: colorHex,
					hoverBackgroundColor: colorHover
				}]
			},
			options: {
				legend: false,
				responsive: false
			}
		}

		$('.canvasDoughnut').each(function(){
			var chart_element = $(this);
			var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);
		});
	}

}

function init_gauge() {

	if( typeof (Gauge) === 'undefined'){ return; }

	var chart_gauge_settings = {
	  lines: 12,
	  angle: 0,
	  lineWidth: 0.4,
	  pointer: {
		  length: 0.75,
		  strokeWidth: 0.042,
		  color: '#1D212A'
	  },
	  limitMax: 'false',
	  colorStart: '#1ABC9C',
	  colorStop: '#1ABC9C',
	  strokeColor: '#F0F3F3',
	  generateGradient: true
  };

	if ($('#chart_gauge_01').length){

		var chart_gauge_01_elem = document.getElementById('chart_gauge_01');
		var chart_gauge_01 = new Gauge(chart_gauge_01_elem).setOptions(chart_gauge_settings);

	}

	if ($('#gauge-text').length){

		chart_gauge_01.maxValue = 6000;
		chart_gauge_01.animationSpeed = 32;
		chart_gauge_01.set(3200);
		chart_gauge_01.setTextField(document.getElementById("gauge-text"));

	}
}

function init_knob() {

	if( typeof ($.fn.knob) === 'undefined'){ return; }


	$(".knob").knob({
	  change: function(value) {
		//
	  },
	  release: function(value) {
		//

	  },
	  cancel: function() {

	  },
	  /*format : function (value) {
	   return value + '%';
	   },*/
	  draw: function() {

		// "tron" case
		if (this.$.data('skin') == 'tron') {

		  this.cursorExt = 0.3;

		  var a = this.arc(this.cv) // Arc
			,
			pa // Previous arc
			, r = 1;

		  this.g.lineWidth = this.lineWidth;

		  if (this.o.displayPrevious) {
			pa = this.arc(this.v);
			this.g.beginPath();
			this.g.strokeStyle = this.pColor;
			this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, pa.s, pa.e, pa.d);
			this.g.stroke();
		  }

		  this.g.beginPath();
		  this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
		  this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, a.s, a.e, a.d);
		  this.g.stroke();

		  this.g.lineWidth = 2;
		  this.g.beginPath();
		  this.g.strokeStyle = this.o.fgColor;
		  this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
		  this.g.stroke();

		  return false;
		}
	  }

	});

	// Example of infinite knob, iPod click wheel
	var v, up = 0,
	  down = 0,
	  i = 0,
	  $idir = $("div.idir"),
	  $ival = $("div.ival"),
	  incr = function() {
		i++;
		$idir.show().html("+").fadeOut();
		$ival.html(i);
	  },
	  decr = function() {
		i--;
		$idir.show().html("-").fadeOut();
		$ival.html(i);
	  };
	$("input.infinite").knob({
		  min: 0,
		  max: 20,
		  stopper: false,
		  change: function() {
			if (v > this.cv) {
			  if (up) {
				decr();
				up = 0;
			  } else {
				up = 1;
				down = 0;
			  }
			} else {
			  if (v < this.cv) {
				if (down) {
				  incr();
				  down = 0;
				} else {
				  down = 1;
				  up = 0;
				}
			  }
			}
			v = this.cv;
		  }
		});

};

$(document).ready(function() {
    if ($(".js-switch")[0]) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {
                color: '#26B99A'
            });
        });
    }
});

function init_InputMask() {
	if( typeof ($.fn.inputmask) === 'undefined'){ return; }

    $(":input").inputmask();
};

function init_daterangepicker() {

	if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }


	var cb = function(start, end, label) {

	  $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	};

	var optionSet1 = {
	  startDate: moment().subtract(29, 'days'),
	  endDate: moment(),
	  minDate: '01/01/2012',
	  maxDate: '12/31/2015',
	  dateLimit: {
		days: 60
	  },
	  showDropdowns: true,
	  showWeekNumbers: true,
	  timePicker: false,
	  timePickerIncrement: 1,
	  timePicker12Hour: true,
	  ranges: {
		'Today': [moment(), moment()],
		'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		'Last 7 Days': [moment().subtract(6, 'days'), moment()],
		'Last 30 Days': [moment().subtract(29, 'days'), moment()],
		'This Month': [moment().startOf('month'), moment().endOf('month')],
		'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	  },
	  opens: 'left',
	  buttonClasses: ['btn btn-default'],
	  applyClass: 'btn-small btn-primary',
	  cancelClass: 'btn-small',
	  format: 'MM/DD/YYYY',
	  separator: ' to ',
	  locale: {
		applyLabel: 'Submit',
		cancelLabel: 'Clear',
		fromLabel: 'From',
		toLabel: 'To',
		customRangeLabel: 'Custom',
		daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
		monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
		firstDay: 1
	  }
	};

	$('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
	$('#reportrange').daterangepicker(optionSet1, cb);
	$('#reportrange').on('show.daterangepicker', function() {

	});
	$('#reportrange').on('hide.daterangepicker', function() {

	});
	$('#reportrange').on('apply.daterangepicker', function(ev, picker) {

	});
	$('#reportrange').on('cancel.daterangepicker', function(ev, picker) {

	});
	$('#options1').click(function() {
	  $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
	});
	$('#options2').click(function() {
	  $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
	});
	$('#destroy').click(function() {
	  $('#reportrange').data('daterangepicker').remove();
	});

}

function init_daterangepicker_right() {

				if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }


				var cb = function(start, end, label) {

				  $('#reportrange_right span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				};

				var optionSet1 = {
				  startDate: moment().subtract(29, 'days'),
				  endDate: moment(),
				  minDate: '01/01/2012',
				  maxDate: '12/31/2020',
				  dateLimit: {
					days: 60
				  },
				  showDropdowns: true,
				  showWeekNumbers: true,
				  timePicker: false,
				  timePickerIncrement: 1,
				  timePicker12Hour: true,
				  ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				  },
				  opens: 'right',
				  buttonClasses: ['btn btn-default'],
				  applyClass: 'btn-small btn-primary',
				  cancelClass: 'btn-small',
				  format: 'MM/DD/YYYY',
				  separator: ' to ',
				  locale: {
					applyLabel: 'Submit',
					cancelLabel: 'Clear',
					fromLabel: 'From',
					toLabel: 'To',
					customRangeLabel: 'Custom',
					daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
					monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
					firstDay: 1
				  }
				};

				$('#reportrange_right span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

				$('#reportrange_right').daterangepicker(optionSet1, cb);

				$('#reportrange_right').on('show.daterangepicker', function() {

				});
				$('#reportrange_right').on('hide.daterangepicker', function() {

				});
				$('#reportrange_right').on('apply.daterangepicker', function(ev, picker) {

				});
				$('#reportrange_right').on('cancel.daterangepicker', function(ev, picker) {

				});

				$('#options1').click(function() {
				  $('#reportrange_right').data('daterangepicker').setOptions(optionSet1, cb);
				});

				$('#options2').click(function() {
				  $('#reportrange_right').data('daterangepicker').setOptions(optionSet2, cb);
				});

				$('#destroy').click(function() {
				  $('#reportrange_right').data('daterangepicker').remove();
				});

	   }

function init_daterangepicker_single_call() {

	if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }


	$('#single_cal1').daterangepicker({
	  singleDatePicker: true,
	  singleClasses: "picker_1"
	}, function(start, end, label) {

	});
	$('#single_cal2').daterangepicker({
	  singleDatePicker: true,
	  singleClasses: "picker_2"
	}, function(start, end, label) {

	});
	$('#single_cal3').daterangepicker({
	  singleDatePicker: true,
	  singleClasses: "picker_3"
	}, function(start, end, label) {

	});
	$('#single_cal4').daterangepicker({
	  singleDatePicker: true,
	  singleClasses: "picker_4"
	}, function(start, end, label) {

	});


}

function init_daterangepicker_reservation() {

	if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }


	$('#reservation').daterangepicker(null, function(start, end, label) {

	});

	$('#reservation-time').daterangepicker({
	  timePicker: true,
	  timePickerIncrement: 30,
	  locale: {
		format: 'MM/DD/YYYY h:mm A'
	  }
	});

}

function init_validator () {

		if( typeof (validator) === 'undefined'){ return; }


	  // initialize the validator function
      validator.message.date = 'not a real date';

      // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
      $('form')
        .on('blur', 'input[required], input.optional, select.required', validator.checkField)
        .on('change', 'select.required', validator.checkField)
        .on('keypress', 'input[required][pattern]', validator.keypress);

      $('.multi.required').on('keyup blur', 'input', function() {
        validator.checkField.apply($(this).siblings().last()[0]);
      });

      $('form').submit(function(e) {
        e.preventDefault();
        var submit = true;

        // evaluate the form using generic validaing
        if (!validator.checkAll($(this))) {
          submit = false;
        }

        if (submit)
          this.submit();

        return false;
		});

	  };

function  init_calendar() {

	if( typeof ($.fn.fullCalendar) === 'undefined'){ return; }

	var date = new Date(),
		d = date.getDate(),
		m = date.getMonth(),
		y = date.getFullYear(),
		started,
		categoryClass;

	var calendar = $('#calendar').fullCalendar({
	  header: {
		left: 'prev,next today',
		center: 'title',
		right: 'month,agendaWeek,agendaDay,listMonth'
	  },
	  selectable: true,
	  selectHelper: true,
	  select: function(start, end, allDay) {
		$('#fc_create').click();

		started = start;
		ended = end;

		$(".antosubmit").on("click", function() {
		  var title = $("#title").val();
		  if (end) {
			ended = end;
		  }

		  categoryClass = $("#event_type").val();

		  if (title) {
			calendar.fullCalendar('renderEvent', {
				title: title,
				start: started,
				end: end,
				allDay: allDay
			  },
			  true // make the event "stick"
			);
		  }

		  $('#title').val('');

		  calendar.fullCalendar('unselect');

		  $('.antoclose').click();

		  return false;
		});
	  },
	  eventClick: function(calEvent, jsEvent, view) {
		$('#fc_edit').click();
		$('#title2').val(calEvent.title);

		categoryClass = $("#event_type").val();

		$(".antosubmit2").on("click", function() {
		  calEvent.title = $("#title2").val();

		  calendar.fullCalendar('updateEvent', calEvent);
		  $('.antoclose2').click();
		});

		calendar.fullCalendar('unselect');
	  },
	  editable: true,
	  events: [{
		title: 'All Day Event',
		start: new Date(y, m, 1)
	  }, {
		title: 'Long Event',
		start: new Date(y, m, d - 5),
		end: new Date(y, m, d - 2)
	  }, {
		title: 'Meeting',
		start: new Date(y, m, d, 10, 30),
		allDay: false
	  }, {
		title: 'Lunch',
		start: new Date(y, m, d + 14, 12, 0),
		end: new Date(y, m, d, 14, 0),
		allDay: false
	  }, {
		title: 'Birthday Party',
		start: new Date(y, m, d + 1, 19, 0),
		end: new Date(y, m, d + 1, 22, 30),
		allDay: false
	  }, {
		title: 'Click for Google',
		start: new Date(y, m, 28),
		end: new Date(y, m, 29),
		url: 'http://google.com/'
	  }]
	});

};

function init_DataTables() {

	if( typeof ($.fn.DataTable) === 'undefined'){ return; }

	var handleDataTableButtons = function() {
	  if ($("#datatable-buttons").length) {
		$("#datatable-buttons").DataTable({
		  dom: "Bfrtip",
		  buttons: [
			{
			  extend: "copy",
			  className: "btn-sm"
			},
			{
			  extend: "csv",
			  className: "btn-sm"
			},
			{
			  extend: "excel",
			  className: "btn-sm"
			},
			{
			  extend: "pdfHtml5",
			  className: "btn-sm"
			},
			{
			  extend: "print",
			  className: "btn-sm"
			},
		  ],
		  responsive: true
		});
	  }
	};

	TableManageButtons = function() {
	  "use strict";
	  return {
		init: function() {
		  handleDataTableButtons();
		}
	  };
	}();

	$('#datatable').dataTable();

	$('#datatable-keytable').DataTable({
	  keys: true
	});

	$('#datatable-responsive').DataTable();

	$('#datatable-scroller').DataTable({
	  ajax: "js/datatables/json/scroller-demo.json",
	  deferRender: true,
	  scrollY: 380,
	  scrollCollapse: true,
	  scroller: true
	});

	$('#datatable-fixed-header').DataTable({
	  fixedHeader: true
	});

	var $datatable = $('#datatable-checkbox');

	$datatable.dataTable({
	  'order': [[ 1, 'asc' ]],
	  'columnDefs': [
		{ orderable: false, targets: [0] }
	  ]
	});
	$datatable.on('draw.dt', function() {
	  $('checkbox input').iCheck({
		checkboxClass: 'icheckbox_flat-green'
	  });
	});

	TableManageButtons.init();

};

function init_storage() {
	$('#storage_analysis_table').empty();
	for(var i=0; i<keys.length; i++) {
		var element = "<tr><td><p><i class='fa fa-square " + colors[i] + "'></i>" + keys[i] + "</p></td><td>" + values[i] + "%</td></tr>";
		$('#storage_analysis_table').append(element);
	}
}

function getNewData() {
	$.ajax({
        type: "post",
        url: "getData.php",
        statusCode: {
            500: function() {

            }
        },
        success: function(response) {
            response = JSON.parse(response);

			keys = [];
			values = [];
			if(response['storage']['free'] == '100.00') {
				keys.push('Free Space');
				values.push(100)
			} else {
				$.each(response['storage']['folders'], function(key, value) {
					keys.push(key);
					values.push(value);
				});
			}

			init_flot_chart();
			init_chart_doughnut();
			init_gauge();

			init_storage();
        },
        error: function(response) {

        }
    });
	setTimeout(getNewData, 10000);
}

$(document).ready(function() {
	init_sidebar();
	init_InputMask();
	init_knob();
	init_daterangepicker();
	init_daterangepicker_right();
	init_daterangepicker_single_call();
	init_daterangepicker_reservation();
	init_validator();
	init_DataTables();
	init_calendar();
	getNewData();
	init_storage();
});
