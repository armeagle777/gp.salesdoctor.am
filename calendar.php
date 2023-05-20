<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="../plugins/fullcalendar/main.min.css">
  <link rel="stylesheet" href="../plugins/fullcalendar-daygrid/main.min.css">
  <link rel="stylesheet" href="../plugins/fullcalendar-timegrid/main.min.css">
  <link rel="stylesheet" href="../plugins/fullcalendar-bootstrap/main.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-3">
            <h1>Օրացույց</h1> 
          </div>
          <div class="col-sm-3">
		  <a href="/action_tasks.php?action=add" class="btn btn-warning">Առաջադրանք</a>
		  
          </div><div class="col-sm-6">
		  <a href="/pr_finance.php" class="btn btn-primary">Ընդհանուր</a>
		  <a href="/pr_finance_networks.php" class="btn btn-primary">Ցանցեր</a>
		  <a href="/pr_finance_groups.php" class="btn btn-primary">Խմբեր</a>
		  <a href="/pr_open_orders.php" class="btn btn-primary">Չվճարված պատվերներ</a>
		  
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="sticky-top mb-3">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Նշումներ</h4>
                </div>
                <div class="card-body">
                  <!-- the events -->
                  <div class="row">
					<?php 
						$query_comments = mysqli_query($con, "SELECT * FROM calendar_comments WHERE area='1'");
						while($array_comments = mysqli_fetch_array($query_comments)):
					?>
				  
                    <div style="margin-bottom: 10px;">
					<input type="text" class="form-control comment_change" id="<?php echo $array_comments['id']; ?>" value="<?php echo $array_comments['calendar_comment']; ?>">
					
					<button id="<?php echo $array_comments['id']; ?>" class="btn btn-danger btn-sm rounded-0 delete_comment" style="float: right;
    margin-right: -33px;
    margin-top: -35px;"><i class="fa fa-trash"></i></button></div>
					
					<?php endwhile; ?>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
			  

              <!-- /.card -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Ավելացնել նշում</h3>
                </div>
                <div class="card-body">
                  <!-- /btn-group -->
                  <div class="">
				 Նշումներ <input type="radio" name="comment_area" class="comment_area" value='1'> <br>
				 Օրացույց <input type="radio" name="comment_area" class="comment_area" value='2'>
				  <br> <br>
				  
                    <input id="calendar_comment" type="text" class="form-control" placeholder="Նշում">
					<br>
                    <input id="comment_date" type="text" class="form-control" placeholder="Օր">
					<br>
                    <div class="input-group-append">
                      <button id="add_calendar" type="button" class="btn btn-primary">Ավելացնել</button>
                    </div>
                    <!-- /btn-group -->
                  </div>
                  <!-- /input-group -->
                </div>
              </div>
			  
			  			  <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Օրացույց</h4>
                </div>
                <div class="card-body">
                  <!-- the events -->
                  <div class="row">
					<?php 
						$query_comments = mysqli_query($con, "SELECT * FROM calendar_comments WHERE area='2'");
						while($array_comments = mysqli_fetch_array($query_comments)):
					?>
				  
                    <div style="margin-bottom: 10px;"><?php echo $array_comments['comment_date']; ?> <input type="text" class="form-control comment_change" value="<?php echo $array_comments['calendar_comment']; ?>" id="<?php echo $array_comments['id']; ?>"><button id="<?php echo $array_comments['id']; ?>" class="btn btn-danger btn-sm rounded-0 delete_comment" style="float: right;
    margin-right: -33px;
    margin-top: -35px;"><i class="fa fa-trash"></i></button></div>
					
					<?php endwhile; ?>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-primary">
              <div class="card-body p-0">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->






  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery UI -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- AdminLTE App -->
<script src="../../plugins/moment/moment.min.js"></script>

<script src="../../plugins/daterangepicker/daterangepicker.js"></script>

<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<!-- fullCalendar 2.2.5 -->
<script src="../plugins/fullcalendar/main.min.js"></script>
<script src="../plugins/fullcalendar-daygrid/main.min.js"></script>
<script src="../plugins/fullcalendar-timegrid/main.min.js"></script>
<script src="../plugins/fullcalendar-interaction/main.min.js"></script>
<script src="../plugins/fullcalendar-bootstrap/main.min.js"></script>

<!-- Page specific script -->

<?php 

$query_calendar = mysqli_query($con, "SELECT *, shops.name FROM pr_orders_document LEFT JOIN shops ON pr_orders_document.shop_id = shops.shop_id WHERE debt_date !='' AND order_pay_status != '3' AND pr_orders_document.order_type = '1' AND (pay_type = '3' or pay_type = '4') AND shops.network = '0' ");

?>


<script>
$('#comment_date').daterangepicker({
	  //autoUpdateInput: false,

	locale: {
		format: 'YYYY-MM-DD', 
		firstDay: 1,
		cancelLabel: 'Clear'
    },
    singleDatePicker: true,
    showDropdowns: true,
});


$( ".comment_change").change(function() {
	  var comment_id = $(this).attr('id');
	  var comment_text = $(this).val();
	  
	  var url = 'api/calendar.php';

      $.ajax({
           type: "POST",
           url: url,
           data: {comment_id: comment_id, comment_text: comment_text, action: 'edit_comment'}, 
           success: function(data)
           {
			   			  
				location.reload();

           }
		   
         });
});

$( ".delete_comment").click(function() {
	  var comment_id = $(this).attr('id');
	  var url = 'api/calendar.php';

      $.ajax({
           type: "POST",
           url: url,
           data: {comment_id: comment_id, action: 'delete'}, 
           success: function(data)
           {
			   			  
				location.reload();

           }
		   
         });
});

$( ".delete_comment").click(function() {
	  var comment_id = $(this).attr('id');
	  var url = 'api/calendar.php';

      $.ajax({
           type: "POST",
           url: url,
           data: {comment_id: comment_id, action: 'delete'}, 
           success: function(data)
           {
			   			  
				location.reload();

           }
		   
         });
});

$( "#add_calendar").click(function() {
	  var calendar_comment = $('#calendar_comment').val();
	  var comment_date = $('#comment_date').val();
	  var area = $('input[name="comment_area"]:checked').val();

	  if(calendar_comment == ""){
		  return false;
	  }

	  var url = 'api/calendar.php';

      $.ajax({
           type: "POST",
           url: url,
           data: {calendar_comment: calendar_comment, comment_date: comment_date, action: 'add_new', area: area}, 
           success: function(data)
           {
			   			  
			 location.reload();

           }
		   
         });
});





  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    ini_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendarInteraction.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------



    var calendar = new Calendar(calendarEl, {
      plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      'themeSystem': 'bootstrap',
      //Random default events
      events    : [
	 
		
		<?php while($calendar_array = mysqli_fetch_array($query_calendar)):
			$document_id = $calendar_array['document_id'];
			$debt_date = $calendar_array['debt_date'];
			$shop_name = $calendar_array['name'];
			$shop_id = $calendar_array['shop_id'];
			$order_summ = $calendar_array['order_last_summ'];
			
			$num_rows = mysqli_num_rows(mysqli_query($con, "SELECT * FROM group_to_shop WHERE shop_id = '$shop_id' "));
			if($num_rows < 1):
		
		?>

        {
          title          : '<?php echo $shop_name; ?> - <?php echo $order_summ; ?>',
          start          : '<?php echo $debt_date; ?>',
          end            : '<?php echo $debt_date; ?>',
          url            : '/pr_open_orders.php?datebeet=2020-01-14+-+2040-03-18&district_select=0&manager_select=0&debt=on&shop_id=<?php echo $shop_id; ?>',
          backgroundColor: '#6f983f', //Primary (light-blue)
          borderColor    : '#6f983f' //Primary (light-blue)
        },
		
		<?php
		endif;
		endwhile; ?>
		
		<?php
		$query_comment = mysqli_query($con, "SELECT * FROM calendar_comments WHERE area='2' ");
		while($comments_array = mysqli_fetch_array($query_comment)):
			$comment = $comments_array['calendar_comment'];
			$com_date = $comments_array['comment_date'];		
		?>

        {
          title          : '<?php echo $comment; ?>',
          start          : '<?php echo $com_date; ?>',
          end            : '<?php echo $com_date; ?>',
          url            : '#',
          backgroundColor: '#a1a2a5', //Primary (light-blue)
          borderColor    : '#a1a2a5' //Primary (light-blue)
        },
		
		<?php endwhile; ?>	
		
		<?php
		$query_tasks = mysqli_query($con, "SELECT * FROM tasks");
		while($tasks_array = mysqli_fetch_array($query_tasks)):
			$task = $tasks_array['task'];
			$created_date = $tasks_array['calendar_date'];		
		?>

        {
          title          : '<?php echo $task; ?>',
          start          : '<?php echo $created_date; ?>',
          end            : '<?php echo $created_date; ?>',
          url            : '/tasks.php',
          backgroundColor: '#ff9800', //Primary (light-blue)
          borderColor    : '#ff9800' //Primary (light-blue)
        },
		
		<?php endwhile; ?>
		
      ],
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function(info) {
        // is the "remove after drop" checkbox checked?
        if (checkbox.checked) {
          // if so, remove the element from the "Draggable Events" list
          info.draggedEl.parentNode.removeChild(info.draggedEl);
        }
      }    
    });

    calendar.render();
    // $('#calendar').fullCalendar()

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({
        'background-color': currColor,
        'border-color'    : currColor
      })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      ini_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
  })
</script>
</body>
</html>
</body>
</html>
