<ul class="nav navbar-nav">
    <li class="">
      <a href='<?php echo site_url('/dashboard/index')?>'>Dashboard</a> 
    </li>
         <?php 
           $gateEntry = $this->config->item('menu_access')['gate_entry'];
           $ge = filterMenus($gateEntry); ?>  
    <?php if(count($ge)): ?>       
    <li class="" id="gate-entry-menu">
          <?php foreach($ge as $key => $url): ?>
            <li><a href="<?=site_url($url)?>"><?=ucwords(str_replace('_', ' ', $key))?></a></li>
          <?php endforeach;?>
    </li>
  <?php endif;?>
    <?php  $dataManagement = $this->config->item('menu_access')['data_management'];
       $dm = filterMenus($dataManagement); 
      if(count($dm)): ?>
        <li class="dropdown" id='data-management-menu'>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Data Management <span class="caret"></span></a>
          <ul class="dropdown-menu">
          <?php foreach($dm as $key => $url): ?>
            <li><a href="<?=site_url($url)?>"><?=ucwords(str_replace('_', ' ', $key))?></a></li>
          <?php endforeach;?>
          </ul>
        </li>
     <?php endif;?>
     <?php
      $managerDashboard = $this->config->item('menu_access')['manager_dashboard'];
      $md = filterMenus($managerDashboard); 
       if(count($md)):?>
        <li class="dropdown" id="manager-dashboard-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Manager Dashboard<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="dropdown-submenu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cash Transaction</a>
              <ul class="dropdown-menu">
                  <?php foreach (cashTransactionMenuItems() as $item): ?>
                    <li><a href="<?=site_url('manager_dashboard/add_cash_transaction/'. $item->id )?>" ><?=$item->name?></a></li>
                  <?php endforeach; ?>
              </ul>
            </li>
          <?php foreach($md as $key => $url): ?>
            <li><a href="<?=site_url($url)?>"><?=ucwords(str_replace('_', ' ', $key))?></a></li>
          <?php endforeach;?>
          </ul>
        </li>
        <?php endif; ?>  
       <?php 
       $manageUsers = $this->config->item('menu_access')['user_management'];
       $um = filterMenus($manageUsers); 
       if(count($um)): ?>
        <li class="dropdown" id='data-management-menu'>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">User Management <span class="caret"></span></a>
          <ul class="dropdown-menu">
          <?php 
           foreach($um as $key => $url): ?>
            <li><a href="<?=site_url($url)?>"><?=ucwords(str_replace('_', ' ', $key))?></a></li>
          <?php endforeach;?>
          </ul>
        </li>
      <?php endif; ?>  


    </ul>