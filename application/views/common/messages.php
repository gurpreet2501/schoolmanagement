<?php if(!empty($this->session->flashdata('success_msgs'))):?>
  <div class="alert alert-success" role="alert"><?=$this->session->flashdata('success_msgs')?></div>
<?php endif; ?>
<?php if(!empty($this->session->flashdata('error_msgs'))):?>
  <div class="alert alert-danger" role="alert"><?=$this->session->flashdata('error_msgs')?></div>
<?php endif; ?>