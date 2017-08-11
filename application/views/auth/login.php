<div class="div-container col-md-12">
<span class="head_title"><?php echo lang('login_heading');?></span>

<div class="col-md-6">
<p><?php echo lang('login_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>
<?php echo $this->mf->openForm("", "leftform");?>
<?php echo $this->mf->createTextBox(
              "identity",
              isset($data)&&(!$isposted)?"":set_value("identity"),
              lang('login_identity_label', 'identity'),
              true,
              true,
              '',
              30)?>
<?php echo $this->mf->createPasswordBox(
              "password",
              isset($data)&&(!$isposted)?"":set_value("password"),
              lang('login_password_label', 'password'),
              true,
              true,
              '',
              30)?>

  <div class="form-group">
    <label class="col-sm-3 control-label" for="remember">
      <label for="password"><?=lang('login_remember_label', 'remember')?></label>:
    </label>
    <div class="col-sm-9">
      <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
    </div>
  </div>

  <?php echo $this->mf->createButtons("","",lang('login_submit_btn'))?>
  <div class="form-group">
    <label class="col-sm-3 control-label" for="remember">
    </label>
    <div class="col-sm-9">
      <a href="forgot_password"><?php echo lang('login_forgot_password');?></a>
    </div>
  </div>
<?php echo $this->mf->closeForm();?>
</div>

</div>
