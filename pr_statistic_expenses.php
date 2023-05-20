<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 
$year_selected = mysqli_real_escape_string($con, $_GET['year']);
$payment_type= mysqli_real_escape_string($con, $_GET['payment_type']);
$expense_direction= mysqli_real_escape_string($con, $_GET['direction']);

$payment_type_where_condition ='';
if($payment_type === '1'){
    $payment_type_where_condition=" AND E.expenses_payment_type='1'";
}else if($payment_type === '2'){
    $payment_type_where_condition=" AND E.expenses_payment_type='2'";
}

$direction_condition="";
if($expense_direction != '0'){
  $direction_condition =" AND T.direction_id = $expense_direction";  
}


$average_months_count = $year_selected === date('Y') ? date('m') : 12;



?>

  
  <div class="content-wrapper">    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ծախսեր</h1>
          </div>
        </div>
      </div>
    </section>    
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">			  
              </div>              
              <div class="card-body">			  
                <form action="/pr_statistic_expenses.php" id="statistics_form"> 
                  <div class="form-row">
                    <div class="form-group col-md-2">
						<label for="login">Տարի</label>
						<select name="year" id="year" class="form-control">
						    <option value="0"> Ընտրել </option>
							<?php 
								$query_year = mysqli_query($con, "SELECT YEAR(expenses_date) as years FROM pr_expenses GROUP by years ORDER BY years DESC");
								while($year_array = mysqli_fetch_array($query_year)):
								$year = $year_array['years'];
							    if(!empty($year)):
							?> 
						                <option value="<?php echo $year; ?>"  <?php if($year_selected == $year ) {echo "selected"; } ?> > <?php echo $year; ?></option>
							<?php
							        endif;
							    endwhile; 
							?>
						</select>
				    </div>
                    <div class="form-group col-md-2">
						<label for="payment_type">Վճարման տեսակ</label>
						<select name="payment_type" id="payment_type" class="form-control">
						    <option value="0"> Բոլորը </option>
						    <option value="1" <?php if($payment_type == 1 ) {echo "selected"; } ?> > Կանխիկ </option>
						    <option value="2" <?php if($year_selected == 2 ) {echo "selected"; } ?> > Բանկ</option>
						</select>
				    </div>
                    <div class="form-group col-md-2">
						<label for="direction">Ուղղություն</label>
						<select name="direction" id="direction" class="form-control">
							<option  value="0">Բոլորը</option>
							<?php 
							    $query="SELECT id AS DIRECTION_ID, name AS DIRECTION_NAME  FROM pr_expense_directions WHERE active=1 AND id IN (SELECT direction_id FROM pr_finance_type WHERE active = 1)";
							    $result = mysqli_query($con, $query);
							    while($array_finance_type = mysqli_fetch_array($result)):
							        extract($array_finance_type);
					        ?>
							    <option <?php if($expense_direction == $DIRECTION_ID){ echo " selected";}  ?> value="<?php echo $DIRECTION_ID;  ?>"><?php echo  $DIRECTION_NAME; ?></option>
							<?php 
							    endwhile;
							?>
						</select>
				    </div>
                    <div class="form-group col-md-2 " style="max-width:150px;display: flex;  flex-direction:column;  justify-content:flex-end;">
                        <button type="submit" class="btn btn-success">Ցուցադրել</button>
                    </div>
                  </div>
                </form>				  
                <table id="expenses_table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th class='select-filter'>Նպատակ</th>
                      <th>Հունվար</th>
                      <th>Փետրվար</th>
                      <th>Մարտ </th>
                      <th>Ապրիլ</th>
                      <th>Մայիս </th>
                      <th>Հունիս</th>
                      <th>Հուլիս</th>
                      <th>Օգոստոս</th>
                      <th>Սեպտեմբեր</th>
                      <th>Հոկտեմբեր</th>
                      <th>Նոյեմբեր</th>
                      <th>Դեկտեմբեր</th>
                      <th>Ընդամենը </th>
                      <th>Միջին</th>
                    </tr>
                  </thead>
                  <tbody>				  
                        <?php
                        $query="SELECT 
                                	EXPENSES_STAT.DIRECTION_ID,
                                    EXPENSES_STAT.DIRECTION_NAME,
                                    EXPENSES_STAT.MANAGER_NAME,
                                    EXPENSES_STAT.SHOP_NAME,
                                    EXPENSES_STAT.SHOP_ADDRESS,
                                    EXPENSES_STAT.supplier_name,
                                    EXPENSES_STAT.text,
                                	SUM(EXPENSES_STAT.expenses_summ) AS TOTAL, 
                                	SUM(
                                		if(
                                			MONTH(EXPENSES_STAT.expenses_date) = '1', 
                                			EXPENSES_STAT.expenses_summ, 
                                			null
                                		)
                                	) AS JANUARY, 
                                	SUM(
                                		if(
                                			MONTH(EXPENSES_STAT.expenses_date) = '2', 
                                			EXPENSES_STAT.expenses_summ, 
                                			null
                                		)
                                	) AS FEBRUARY, 
                                	SUM(
                                		if(
                                			MONTH(EXPENSES_STAT.expenses_date) = '3', 
                                			EXPENSES_STAT.expenses_summ, 
                                			null
                                		)
                                	) AS MARCH, 
                                	SUM(
                                		if(
                                			MONTH(EXPENSES_STAT.expenses_date) = '4', 
                                			EXPENSES_STAT.expenses_summ, 
                                			null
                                		)
                                	) AS APRIL, 
                                	SUM(
                                		if(
                                			MONTH(EXPENSES_STAT.expenses_date) = '5', 
                                			EXPENSES_STAT.expenses_summ, 
                                			null
                                		)
                                	) AS MAY, 
                                	SUM(
                                		if(
                                			MONTH(EXPENSES_STAT.expenses_date) = '6', 
                                			EXPENSES_STAT.expenses_summ, 
                                			null
                                		)
                                	) AS JUNE, 
                                	SUM(
                                		if(
                                			MONTH(EXPENSES_STAT.expenses_date) = '7', 
                                			EXPENSES_STAT.expenses_summ, 
                                			null
                                		)
                                	) AS JULY, 
                                	SUM(
                                		if(
                                			MONTH(EXPENSES_STAT.expenses_date) = '8', 
                                			EXPENSES_STAT.expenses_summ, 
                                			null
                                		)
                                	) AS AUGUST, 
                                	SUM(
                                		if(
                                			MONTH(EXPENSES_STAT.expenses_date) = '9', 
                                			EXPENSES_STAT.expenses_summ, 
                                			null
                                		)
                                	) AS SEPTEMBER, 
                                	SUM(
                                		if(
                                			MONTH(EXPENSES_STAT.expenses_date) = '10', 
                                			EXPENSES_STAT.expenses_summ, 
                                			null
                                		)
                                	) AS OCTOBER, 
                                	SUM(
                                		if(
                                			MONTH(EXPENSES_STAT.expenses_date) = '11', 
                                			EXPENSES_STAT.expenses_summ, 
                                			null
                                		)
                                	) AS NOVEMBER, 
                                	SUM(
                                		if(
                                			MONTH(EXPENSES_STAT.expenses_date) = '12', 
                                			EXPENSES_STAT.expenses_summ, 
                                			null
                                		)
                                	) AS DECEMBER 
                                FROM 
                                	(
                                		SELECT 
                                			E.expenses_date, 
                                			E.expenses_type, 
                                			E.expenses_summ,
                                			D.id AS DIRECTION_ID,
                                            D.name AS DIRECTION_NAME,
                                            M.name AS MANAGER_NAME,
                                            S.name AS SHOP_NAME,
                                            S.address AS SHOP_ADDRESS,
                                            SP.supplier_name,
                                            T.text
                                		FROM 
                                			pr_expenses E 
                                			LEFT JOIN pr_finance_type T ON E.expenses_type = T.id
                                			LEFT JOIN pr_expense_directions D ON D.id=T.direction_id
                                            LEFT JOIN shops S ON S.id=T.shop_id
                                            LEFT JOIN manager M ON M.id = T.employee_id
                                        	LEFT JOIN pr_supplier SP ON SP.id = T.provider_id
                                		WHERE 
                                			YEAR(expenses_date)= '$year_selected'
                                			$payment_type_where_condition
                                			$direction_condition
                                	) AS EXPENSES_STAT 
                                GROUP BY 
                                	EXPENSES_STAT.expenses_type";
                        
                        $query_result = mysqli_query($con, $query);
                        while ($array_expenses = mysqli_fetch_array($query_result)):
                            extract($array_expenses);
                            $row_value = '';
                    	    if($DIRECTION_ID == 1){
                    	        $row_value = $DIRECTION_NAME." ֊ ".$MANAGER_NAME;
                    	    }else if($DIRECTION_ID == 2){
                    	        $row_value = $DIRECTION_NAME." ֊ ".$supplier_name;
                    	    }else if($DIRECTION_ID == 3){
                    	        $row_value = $DIRECTION_NAME." ֊ ".$SHOP_NAME." ($SHOP_ADDRESS)";
                    	    }else{
                    	        $row_value = $DIRECTION_NAME." ֊ ".$text;
                    	    }
                    ?>				  
                    <tr>
                      <td><?php echo $row_value; ?></td>
                      <td><?php echo $JANUARY; ?></td>
                      <td><?php echo $FEBRUARY; ?></td>
                      <td><?php echo $MARCH; ?></td>
                      <td><?php echo $APRIL; ?></td>
                      <td><?php echo $MAY; ?></td>
                      <td><?php echo $JUNE; ?></td>
                      <td><?php echo $JULY; ?></td>
                      <td><?php echo $AUGUST; ?></td>
                      <td><?php echo $SEPTEMBER; ?></td>
                      <td><?php echo $OCTOBER; ?></td>
                      <td><?php echo $NOVEMBER; ?></td>
                      <td><?php echo $DECEMBER; ?></td>
                      <td><?php echo $TOTAL; ?></td>
                      <td><?php echo $TOTAL / $average_months_count; ?></td>
                    </tr>                 
                      <?php endwhile; ?>                 
                  </tbody>
                  <tfoot>
                    <tr>
                        <th>Նպատակ</th>
                        <th> </th>
    					<th> </th>
    					<th> </th>
    					<th> </th>
    					<th> </th>
    					<th> </th>
    					<th> </th>
    					<th> </th>
    					<th> </th>
    					<th> </th>
    					<th> </th>
    					<th> </th>
    					<th> </th>
    					<th> </th>
                    </tr>
                  </tfoot>
                </table>
              </div>              
            </div>            
          </div>          
        </div>        
      </div>      
    </section>    
  </div>
  
<?php
  include 'footer.php';
?>  
  <aside class="control-sidebar control-sidebar-dark">    
  </aside>
  
<!-- </div> -->



<script src="../../plugins/jquery/jquery.min.js"></script>

<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>


<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>


<script src="../../plugins/daterangepicker/daterangepicker.js"></script>


<script src="../../dist/js/adminlte.min.js"></script>

<script src="../../dist/js/demo.js"></script>



<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <b>Ջնջե՞լ մատակարարը</b>
	      <input type="hidden" value="" name="client_to_delete" id="client_to_delete">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
        <button type="button" class="btn btn-danger" id="click_delete">Այո</button>
      </div>
    </div>
  </div>
</div>


<script>


  $('#reservation').daterangepicker({
      locale: {
          format: 'YYYY-MM-DD', 
          firstDay: 1
      }
  });


  jQuery(".delete_client_button").click(function() {
      var contentPanelId = jQuery(this).attr("id");
      $('#client_to_delete').val(contentPanelId);
  });
    

    
    
  $(function () {
      var table = $("#expenses_table").DataTable({
          dom: 'Bfrtip',
          paging: false,
          scrollX: true,
      autoWidth: false,
          footerCallback: function ( row, data, start, end, display ) {
              var api = this.api();
              nb_cols = api.columns().nodes().length;
              var j = 1;
              while(j < 15){
                  var pageTotal = api
                      .column( j, { page: 'current'} )
                      .data()
                      .reduce( function (a, b) {
                        let columnValue= Number(a) + Number(b)
                        return columnValue ;
                      }, 0 );

                  // Update footer
                  pageTotal = j === 14 ? parseInt(pageTotal).toLocaleString() : pageTotal.toLocaleString()
                  $( api.column( j ).footer() ).html(pageTotal);
                  j++;
              } 
          },		
          initComplete: function () {
              this.api().columns( '.select-filter' ).every( function (index) {                    
                  //    var column = table.column( index );    
                  var column = this;
                  var select = $('<select style="max-width: 100px;"><option value=""></option></select>')
                      .appendTo( $(column.footer()).empty() )
                      .on( 'change', function () {
                          var val = $.fn.dataTable.util.escapeRegex(
                              $(this).val()
                          ); 
                          column
                              .search( val ? '^'+val+'$' : '', true, false )
                              .draw();
                      });

                  column.data().unique().sort().each( function ( d, j ) {
                      select.append( '<option value="'+d+'">'+d+'</option>' )
                  });
              });
          },
          columnDefs:
        [
            {
                targets: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                render: $.fn.dataTable.render.number(' ', '.', 0, '','')
            }
        ],
        lengthMenu: [
              [ 10, 25, 50, -1 ],
              [ '10 rows', '25 rows', '50 rows', 'Show all' ]
          ],  
          buttons: [			
              {
                  extend: 'print',
                  exportOptions: {
                      columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ] //Your Colume value those you want
                  }
              },
              {
                  extend: 'excel',
                  exportOptions: {
                      columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ] //Your Colume value those you want
                  }
              },					   
              'copy', 'pageLength',			
          ],
      language:{
              "sEmptyTable": "Տվյալները բացակայում են",
              "sProcessing": "Կատարվում է...",
              "sInfoThousands":  ",",
              "sLengthMenu": "Ցուցադրել արդյունքներ մեկ էջում _MENU_ ",
              "sLoadingRecords": "Բեռնվում է ...",
              "sZeroRecords": "Հարցմանը համապատասխանող արդյունքներ չկան",
              "sInfo": "Ցուցադրված են _START_-ից _END_ արդյունքները ընդհանուր _TOTAL_-ից",
              "sInfoEmpty": "Արդյունքներ գտնված չեն",
              "sInfoFiltered": "(ֆիլտրվել է ընդհանուր _MAX_ արդյունքներից)",
              "sInfoPostFix":  "",
              "sSearch": "Փնտրել",
              "oPaginate": {
                  "sFirst": "Առաջին էջ",
                  "sPrevious": "Նախորդ էջ",
                  "sNext": "Հաջորդ էջ",
                  "sLast": "Վերջին էջ"
              },
              "oAria": {
                  "sSortAscending":  ": ակտիվացրեք աճման կարգով դասավորելու համար",
                  "sSortDescending": ": ակտիվացրեք նվազման կարգով դասավորելու համար"
              }
          }		
      });
  });
</script>
</body>
</html>