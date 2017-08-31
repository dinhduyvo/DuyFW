<div class="panel-group" role="tablist">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
  		<h4 class="panel-title">
  			<span><span class="glyphicon glyphicon-modal-window text-warning"></span> Quản lý Tuyển dụng</span>
  		</h4>
  	</div>
    <div id="collapseOne" class="panel-collapse"
  		role="tabpanel" aria-labelledby="headingOne">
  		<div class="panel-body">
        <?php

        $header = array ("Tiêu đề","Công ty", "Vị trí", "Ngày đăng", "Trạng thái");

        echo $this->mt->createNormalTable($header, $datas,"AdminJob", true, true, true, "Cập nhật", "capnhat","edit", "AdminJob/doAdd","AdminJob");

        echo $this->mt->setDataTableJS("tbData");

        ?>
      </div>
    </div>
  </div>
</div>
<form type="submit" action="" id="formDelete" name="formDelete">
  <input type="hidden" id="deleteid" value="" />
</form>
<script lang="javascript">
$(document).ready(function() {

});
</script>
