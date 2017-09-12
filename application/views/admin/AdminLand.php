<div class="panel-group" role="tablist">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
  		<h4 class="panel-title">
  			<span><span class="glyphicon glyphicon-modal-window text-warning"></span> <?php echo $title; ?> </span>
  		</h4>
  	</div>
    <div id="collapseOne" class="panel-collapse"
  		role="tabpanel" aria-labelledby="headingOne">
  		<div class="panel-body">
        <?php

        $header = array ("Tiêu đề","Địa chỉ","Phone","Giá","Ngày đăng", "Người đăng");

        echo $this->mt->createNormalTable($header, $datas,"AdminLand", true, true, true, "Cập nhật", "capnhat","edit", "AdminLand/doAdd","AdminLand");

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
