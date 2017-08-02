<?php $this->load->view('admin/partials/header') ;
$bookVal = $this->config->item('accepted_bookings');
?>
<div class="row">
  <div class="col-lg-12">
   <h2>Todays Booking Count Status of Employees</h2>
  	<div class="min-count"><h2 class="booking-count pull-right green-round" ><?php //$this->config->item('accepted_bookings')?></h2></div>
  	<table class="table table-boxed">
  	<tr>
  		<th>Name</th>
  		<th>Email</th>
  		<th>Phone</th>
  		<th>Designation</th>
  		<th>Block</th>
  		<th>Room</th>
  		<th>Dept.</th>
  		<th>Pending</th>
  		<th>Accepted</th>
  		<th>Canceled</th>
  		<th>Total</th>
  	</tr>
 <?php foreach($bookings as $val): 
 	
  ?> 	
  	<tr>
  	<td><?=$val['full_name']?></td>
  	<td><?=$val['email']?></td>
  	<td><?=$val['phone_number']?></td>
  	<td><?=$val['designation']?></td>
  	<td><?=$val['block']?></td>
  	<td><?=$val['room_no']?></td>
  	<td><?=$val['department']?></td>
  	<td><?=$val['pending']?></td>
  	<td><div class="green"><?=$val['accepted']?></div></td>
  	<td><div class="red"><?=$val['canceled']?></div></td>
  	<td><?=$val['totalBookings']?></td>
  	</tr>
 <?php endforeach; ?> 	
  	</table>
   
  </div>
</div>
<? $this->load->view('admin/partials/footer') ?>