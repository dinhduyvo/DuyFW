<?php $this->mu->jsInclude("ckeditor");?>
<script>
        CKEDITOR.config.filebrowserUploadUrl = '<?=site_url("Home/upload")?>';
</script>
<div class="div-container col-md-12">
<span class="head_title"><span class="glyphicon glyphicon-modal-window text-warning"></span> Quản lý trang</span>

<div class="col-md-4">
  <?php echo $this->mf->openForm("", "leftform");?>
  <?php $buttons = array(
                      array('id' => 'btnAdd', 'url' => site_url('AdminCategory'),'type' => 'success', 'icon' => 'plus'),
                      array('id' => 'btnEdit', 'url' => '#','type' => 'warning', 'icon' => 'edit'),
                      array('id' => 'btnDelete', 'url' => '#','type' => 'danger', 'icon' => 'remove'),
                      array('id' => 'btnUp', 'url' => '#','type' => 'primary', 'icon' => 'arrow-up'),
                      array('id' => 'btnDown', 'url' => '#','type' => 'primary', 'icon' => 'arrow-down'),
                    );
  echo $this->mf->createFunctionButtons($buttons) ?>
  <?php echo $this->mf->createSelectMultipleFull("datas", $datas,  $current, "Trang", "350px"); ?>
  <?php echo $this->mf->createHidden("pageaction", "add")?>
  <?php echo $this->mf->closeForm();?>
</div>
<div class="col-md-8">
  <?php echo $this->mf->openForm("", "rightform");?>
  <?php echo $this->mf->createTextBox(
				        'title',
				        isset($data)&&(!$isposted)?$data->title:set_value('name'),
				        'Tên danh mục',
				        true,
				        true,
				        '',
								100)?>
  <?php echo $this->mf->createTextBox(
				        'link_name',
				        isset($data)&&(!$isposted)?$data->link_name:set_value('name'),
				        'Friendly URL',
				        true,
				        true,
				        '',
								50)?>
  <?php echo $this->mf->createTextBox(
				        'description',
				        isset($data)&&(!$isposted)?$data->link:set_value('description'),
				        'description',
				        false,
				        true,
				        '',
								50)?>
  <?php echo $this->mf->createSelectFull("parent", $parents,  isset($data)&&(!$isposted)?$data->parent:set_value('parent'), "Trang cha", "--- Chọn trang cha ---", false); ?>
  <?php echo $this->mf->createRadio("Hiển thị","display", DISPLAY_TYPES, isset($data)&&(!$isposted)?$data->display:set_value('display'),  true, true);?>
  <?php echo $this->mf->createHidden("id", isset($data)?$data["id"]:"0")?>
  <?php echo $this->mf->createButtons("reset")?>

  <?php echo $this->mf->closeForm();?>
</div>

</div>
<script lang="javascript">
$(document).ready(function() {

  $("#datas").dblclick(function(event) {
    $("#pageaction").val("");
    $('#leftform').submit();
  });

  $("#btnUp").click(function(event) {
    $("#pageaction").val("up");
    $('#leftform').submit();
  });

  $("#btnDown").click(function(event) {
    $("#pageaction").val("down");
    $('#leftform').submit();
  });

  $("#btnDelete").click(function(event) {
    var f = function() {
      $("#pageaction").val("delete");
      $("#leftform").submit();
    };
    confirmDelete(f);
  });

  if($("#type").val() == "static"){
    $("#staticdiv").attr('display', 'block');

  }
  else{
    $("#staticdiv").attr('style', 'display:none');
  }

  $("#type").change(function(event) {
    if($("#type").val() == "static"){
      $("#staticdiv").attr('style', 'display:block');

    }
    else{
      $("#staticdiv").attr('style', 'display:none');
    }
  });
});
</script>
