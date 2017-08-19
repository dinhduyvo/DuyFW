<?php $this->mu->jsInclude("ckeditor");?>
<script>
        CKEDITOR.config.filebrowserUploadUrl = '<?=site_url("Home/upload")?>';
</script>
<div class="div-container col-md-12">
<span class="head_title"><span class="glyphicon glyphicon-modal-window text-warning"></span> Quản lý Tin tức</span>

<div class="col-md-12">
  <?php

  $header = array ("Tiêu đề","Ngày đăng", "Người đăng");

  echo $this->mt->createNormalTable($header, $datas,"AdminNew", true, true, true, "Cập nhật", "capnhat","edit", "AdminNew/doAdd","AdminNew");

  echo $this->mt->setDataTableJS("tbData");

  ?>
</div>
</div>
<form type="submit" action="" id="formDelete" name="formDelete">
  <input type="hidden" id="deleteid" value="" />
</form>
<script lang="javascript">
$(document).ready(function() {
  
});
</script>
