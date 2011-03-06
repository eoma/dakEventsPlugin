<?php 
  use_javascript('fullcalendar/fullcalendar.min.js');
  use_stylesheet('fullcalendar/fullcalendar.css');
?>

<div id="calendar"></div>
<div id="veil" style="display: none"><span id="veilText" style="position: relative">Loading...</span></div>
<script type="text/javascript">
	function formatDate(date) {
		var year = date.getFullYear();
		var month = date.getMonth() + 1;
		var day = date.getDate();

		if (month < 10) {
			month = '0' + month;
		}

		if (day < 10) {
			day = '0' + day;
		}

		return year + '-' + month + '-' + day;
	}

	$(document).ready(function() {
	
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: false,
			timeFormat: 'HH:mm{ - HH:mm}',
			columnFormat: {
				month: 'ddd',
				week: 'ddd dd.MM',
				day: 'dddd dd.MM',
			},
			axisFormat: 'HH:mm',
			firstHour: 12,
			defaultView: 'agendaWeek',
			firstDay: 1,

			loading: function (isLoading) {
				if (isLoading) {
					$('#veil').css({
						display: 'block',
						position: 'absolute',
						opacity: 0.4,
						backgroundColor: '#fff',
						top: $('#calendar').offset().top,
						left: $('#calendar').offset().left,
						width: $('#calendar').width(),
						height: $('#calendar').height()
					});

					$('#veilText').css({
						top: ($('#calendar').height() / 2) - ($('#veilText').height() / 2),
						left: ($('#calendar').width() / 2) - ($('#veilText').width() / 2),
						fontSize: '3em'
					});
				} else {
					$('#veil').hide();
				}
			},

			events: function (start, end, callback) {
				$.ajax({
					url: '<?php echo url_for($url, true) . "?" . $extraUrlQuery ?>',
					dataType: 'json',
					data: {
						startDate: formatDate(start),
						endDate: formatDate(end),
						limit: 1000
					},
					success: function(doc) {

						var events = [];

						if (doc.data.length > 0) {
							for (var i in doc.data) {
								var e = doc.data[i];

								var startDate = e.startDate.split('-');
								var startTime = e.startTime.split(':');
								var endDate = e.endDate.split('-');
								var endTime = e.endTime.split(':');

								events.push({
									title: e.title,
									start: e.startDate + ' ' + e.startTime,
									end: e.endDate + ' ' + e.endTime,
									url: e.url,
									allDay: false,
								});
							}
						}

						callback(events);
					}
				});
			}
		});
		
	});
</script>
