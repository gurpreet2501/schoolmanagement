<ul class="nav navbar-nav">
    <li class="">
      <a href='<?php echo site_url('/dashboard/index')?>'>Dashboard</a> 
    </li>
    <?php if(canAccess('gate_entry')):?>
    <li class="" id="gate-entry-menu">
      <a href='<?= site_url('/gate_pass/index')?>'>Gate Entry</a> 
    </li>
  <?php endif;?>
         <li class="dropdown" id="manager-dashboard-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Manager Dashboard<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="dropdown-submenu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cash Transaction</a>
              <ul class="dropdown-menu">
                  <?php foreach (cashTransactionMenuItems() as $item): ?>
                    <li><a href="<?=site_url('manager_dashboard/add_cash_transaction/' . $item->id )?>" ><?= $item->name ?></a></li>
                  <?php endforeach; ?>
              </ul>
            </li>

            <li><a href="<?=site_url('manager_dashboard/view_rate_contracts')?>">Rate Contracts</a></li>
            <li><a href="<?=site_url('manager_dashboard/cmr_rice_quality_report')?>">CMR Rice Quality Report</a></li>
            <li><a href="<?=site_url('manager_dashboard/bran_quality_report')?>">Bran Quality Report</a></li>
             <li><a href="<?=site_url('manager_dashboard/transactions_report_generator')?>">Transactions Report</a></li>
             <li><a href="<?=site_url('manager_dashboard/profit_loss_report_generator')?>">Profit Loss Report</a></li>

          </ul>
        </li>

<?php /*
        <li class="dropdown-submenu"  id="settings-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings</a>
            <ul class="dropdown-menu">
                <li class="dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Gate Entry</a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu">
                            <a href="<?=site_url('settings/gate_entry/material/IN')?>" class="dropdown-toggle" >Material In</a>
                            <a href="<?=site_url('settings/gate_entry/material/OUT')?>" class="dropdown-toggle">Material Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            </li>
  */?>
    </ul>