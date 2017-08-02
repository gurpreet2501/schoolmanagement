 <div class="row">
   <div class="col-xs-12"> 
   <?php if(!empty($all_orders)){ ?>
   	  <table class="table table-striped">
   	  	<tr> 
   	  		 <th>Order id</th>
   	  		 <th>Products</th>
   	  		 <th>Order Total</th>
           <th>Status</th>
   	  		 <th>Change Order Status To</th>
   	  	</tr>
   	  	<?php foreach ($all_orders as $key => $value) {?>
   	  		<tr>
   	  			<td><?=$value['id']?></td>
   	  			<td>
   	  				<?php $i=1; foreach ($value['order_items'] as $key => $products) { ?>

   	  				    <a href='<?=site_url("{$products['url']}")?>'>
   	  				   	 <?php echo lng_translate($products['product_name'], site_lang(),'ja');?>
   	  				    </a>
                     <?
                       if($i<count($value['order_items']))
                         echo ' , ';
                    $i++; 

   	  				}?>
   	  			</td>
               <td><?=$value['total_price']?></td>
               <td><?=$value['status']?></td>
   	  			<?php if($value['status']=='Pending'){?>
                      <a href="<?=site_url('')?>">
                       <td><a href="<?=site_url(site_lang().'/admin/process_order/?id='.$value['id'])?>"><button type="button" class="btn btn-success">Process</button></a></td>
                      </a> 
                <?php }else{?>
                      <a href="">
                       <td><a href="<?=site_url(site_lang().'/admin/pending_order/?id='.$value['id'])?>"><button type="button" class="btn btn-danger">Pending</button></a></td>
                      </a>      

               <? } ?>
   	  			 
   	  		    
   	  <?	 } ?>
      </table>
   <? }else{?>
      <h4 class="text-center"> No Orders to show </h4>

    <? }?>   
   </div>
 </div>
