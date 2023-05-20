<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>

<?php 

if(isset($_GET['datebeet'])){
	
	$datebeet = mysqli_real_escape_string($con, $_GET['datebeet']);
	$date_ex = explode(" - ", $datebeet);
	$start_date = $date_ex[0];
	$end_date = $date_ex[1];

	if($start_date != $end_date){
		$query_date_range = " AND E.expenses_date BETWEEN '$start_date' AND '$end_date'";
	}else{
		$query_date_range = " AND E.expenses_date LIKE '$start_date%'";
	}

}

?>

  
  <div class="content-wrapper">    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ծախսեր</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			      <a href="/action_pr_expenses.php?action=add" class="btn btn-primary">Ավելացնել նորը</a>
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
                <form action="/pr_expenses.php" id="statistics_form"> 
                  <div class="form-row">				  
                    <div class="form-group col-md-3">
                      <label>Ժամանակահատված</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control float-right" id="reservation" value="<?php echo $datebeet; ?>" name="datebeet">
                      </div>                  
                    </div>
                    <div class="form-group col-md-1" style="display: flex;  flex-direction:column;  justify-content:flex-end;">
                        <button type="submit" class="btn btn-success">Ցուցադրել</button>
                    </div>
                  </div>
                </form>				  
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Հ\Հ</th>
                      <th class='select-filter'>Խումբ</th>
                      <th>Գումար</th>
                      <th class='select-filter'>Նպատակ</th>
                      <th>Ամսաթիվ</th>
                      <th class='select-filter'>Վճարման տիպ</th>
                      <th class='select-filter'>Բանկ</th>
                      <th class='select-filter'>Մեկնաբանություն</th>
                      <th>Խմբագրել</th>
                    </tr>
                  </thead>
                  <tbody>				  
                      <?php
                        $query="SELECT 
                                	E.id,
                                    E.expenses_date,
                                    E.expenses_summ,        
                                	D.id AS DIRECTION_ID,
                                	D.name AS DIRECTION_NAME,
                                    S.name AS SHOP_NAME,
                                    S.address AS SHOP_ADDRESS,
                                    M.name AS MANAGER_NAME,
                                    SP.supplier_name,
                                    T.text,
                                    E.expenses_comment,
                                	G.group_name, 
                                	P.payment_name, 
                                	B.bank_name 
                                FROM 
                                	pr_expenses E 
                                	LEFT JOIN pr_groups G ON E.expenses_group = G.id 
                                	LEFT JOIN pr_finance_type T ON E.expenses_type = T.id 
                                    
                                	LEFT JOIN pr_expense_directions D ON D.id = T.direction_id 
                                	LEFT JOIN shops S ON S.id = T.shop_id 
                                	LEFT JOIN manager M ON M.id = T.employee_id 
                                	LEFT JOIN pr_supplier SP ON SP.id = T.provider_id 
                                    
                                	LEFT JOIN pr_payment_type P on E.expenses_payment_type = P.id 
                                	LEFT JOIN pr_bank B ON E.expenses_bank = B.id 
                                WHERE 
                                	E.active=1
                                	$query_date_range  
                                ORDER BY 
                                	E.id DESC";
                             	
                        $result = mysqli_query($con, $query);
                        while ($array_expenses = mysqli_fetch_array($result)):
                            extract($array_expenses);
                            $row_value = '';
    					    if($DIRECTION_ID == 1){
    					        $row_value = $DIRECTION_NAME." - ".$MANAGER_NAME;
    					    }else if($DIRECTION_ID == 2){
    					        $row_value = $DIRECTION_NAME." - ".$supplier_name;
    					    }else if($DIRECTION_ID == 3){
    					        $row_value = $DIRECTION_NAME." - ".$SHOP_NAME." ($SHOP_ADDRESS)";
    					    }else{
    					        $row_value = $DIRECTION_NAME." - ".$text;
    					    }
                        
                      ?>				  
                    <tr>
                      <td><?php echo $id; ?></td>
                      <td><?php echo $group_name; ?></td>
                      <td><?php echo $expenses_summ; ?></td>
                      <td><?php echo $row_value; ?></td>
                      <td><?php echo $expenses_date; ?></td>
                      <td><?php echo $payment_name;  ?></td>
                      <td><?php echo $bank_name; ?></td>
                      <td><?php echo $expenses_comment; ?></td>				
                      <td style="width:150px;">
                        <a href="/action_pr_expenses.php?action=edit&expenses_id=<?php echo $id; ?>" class="btn btn-success btn-sm rounded-0" title="Խմբագրել"><i class="fa fa-edit"></i></a>
                        <a href="#" id="<?php echo $id; ?>" class="btn btn-danger btn-sm rounded-0 delete_client_button" data-toggle="modal" data-target="#deletemodal"  title="Ջնջել"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>                 
                      <?php endwhile; ?>                 
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Հ\Հ</th>
                      <th>Խումբ</th>
                      <th>Գումար</th>
                      <th>Նպատակ</th>
                      <th>Ամսաթիվ</th>
                      <th>Վճարման տիպ</th>
                      <th>Բանկ</th>
                      <th>Մեկնաբանություն</th>
                      <th>Խմբագրել</th>
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
        <b>Ջնջե՞լ  ծախսը N <span id="expense_num"></span></b>
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
    
  // Material Select Initialization
//   $(document).ready(function() {
//       $('.mdb-select').materialSelect();
//   });

  $('#reservation').daterangepicker({
      locale: {
          format: 'YYYY-MM-DD', 
          firstDay: 1
      }
  });


  jQuery(".delete_client_button").click(function() {
      var contentPanelId = jQuery(this).attr("id");
      $('#client_to_delete').val(contentPanelId);
      $('#expense_num').html(contentPanelId)
  });
    
    
  $("#click_delete").click(function() {
      var client_to_delete = $('#client_to_delete').val();
      $('#expense_num').html()
      $.ajax({
          type: "POST",
          url: "api/add_pr_expenses.php",
          data: {expenses_id:client_to_delete, action:'delete_cient'},
          success: function(data)
          {
              window.location.reload();
          }		   
      });
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
              var j = 2;
              while(j < 3){
                  var pageTotal = api
                      .column( j, { page: 'current'} )
                      .data()
                      .reduce( function (a, b) {
                          return Number(a) + Number(b);
                      }, 0 );

                  // Update footer
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