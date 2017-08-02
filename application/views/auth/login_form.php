<?php 

$this->load->view('partials/header');
$form_action = site_url('auth/login');
$register_action = site_url('auth/register');?>
<div class="container">
  <div class="row">
    <div class="col-xs-3"></div>
    <div class="col-xs-6">
      <?php
      $login = array(
        'name'  => 'login',
        'id'  => 'login',
        'value' => set_value('login'),
        'maxlength' => 80,
        'size'  => 30,
      );

      $password = array(
        'name'  => 'password',
        'id'  => 'password',
        'size'  => 30,
      );
      $remember = array(
        'name'  => 'remember',
        'id'  => 'remember',
        'value' => 1,
        'checked' => set_value('remember'),
        'style' => 'margin:0;padding:0',
      );
      $captcha = array(
        'name'  => 'captcha',
        'id'  => 'captcha',
        'maxlength' => 8,
      );
      // echo form_open($this->uri->uri_string()); ?>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
          <div class="auth__forms_container">
           <div class="auth_forms">
            <div class="row">
              <div class="col-md-1"></div>
             <div class="col-md-10">
               <h2>Login</h2>
             </div>
             <div class="col-md-1"></div>
             </div>
            <div class="row">
              <div class="col-md-1"></div>
             <div class="col-md-10">
                <!--Bootstrap Form -->
                <? if(isset($errors) && !empty($errors)): ?>
                  <div class="alert alert-danger">
                    <? if(isset($errors['banned'])): ?>
                      This account is banned.
                    <? else: ?>
                      <?=implode('<br />',array_values($errors))?>          
                    <? endif; ?>
                  </div>
                <? endif; ?>
               
               <form action='<?=$form_action?>' method="post" accept-charset="utf-8">
                  <div class="form-group">
                    <label for="<?=$login['id']?>">Username</label>
                    <input type="text" class="form-control" id="login" name="login" value="<?=set_value('login')?>" maxlength="80" placeholder="Enter Email or Username">
                  </div>
                  <div class="form-group">
                    <label for="<?=$password['id']?>">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']]) ? $errors[$password['name']]:''; ?>
                  </div>
                  <div class="checkbox">
                    <label for="<?=$remember['id'];?>">
                      <input type="checkbox" name="remember" id="remember" value=1 checked="<?=set_value('remember');?>"> Remember Me
                      <!-- <span class="forgot_pass"><?php// echo anchor('/auth/forgot_password/', 'Forgot password', array('class' => 'underline')); ?></span> -->
                      
                     
                      <?php //echo anchor('/auth/register/', 'Register', array('class' => 'underline')); ?>
                    </label>
                  </div>
              <?/* <?php// echo form_submit('submit', 'Sign In'); ?> */?>
                 <input type="submit" name="submit" value="Sign In" class="btn btn-danger " />
              <?php echo form_close(); ?>
                <!--Bootstrap Form Ends-->
              </div>
              <div class="col-md-1"></div>
            </div>
        </div>
      </div> <!-- Container ends -->
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </div>
    <div class="col-xs-3"></div>
  </div>
</div>

<? $this->load->view('partials/footer'); ?>
	
