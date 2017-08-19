<?php $this->mu->jsInclude("ckeditor");?>
<?php $this->mu->jsInclude("validation");?>
<?php $this->mu->jsInclude("fileinput"); ?>
<script>
        CKEDITOR.config.filebrowserUploadUrl = '<?=site_url("Home/upload")?>';
</script>
<div class="div-container col-md-12">
<span class="head_title"><span class="glyphicon glyphicon-modal-window text-warning"></span> Cập nhập tin</span>
<div class="col-md-12">
  <?php echo $this->mf->openForm("", "myform");?>
  <?php echo $this->mf->createTextBox(
				        'title',
				        isset($data)&&(!$isposted)?$data->title:set_value('title'),
				        'Tiêu đề',
				        true,
				        true,
				        '',
								100)?>
  <?php echo $this->mf->createTextBox(
				        'link_name',
				        isset($data)&&(!$isposted)?$data->link_name:set_value('link_name'),
				        'Friendly URL',
				        true,
				        true,
				        '',
								50)?>
  <?php echo $this->mf->createImageUpload(
				        'avatar',
				        'Hình ảnh đại diện (nếu có)',
				        false,
				        true,
				        'Chọn file',
				        isset($data)&&(!$isposted)?$data->avatar:''); ?>
  <?php echo $this->mf->createTextBox(
				        'author',
				        isset($data)&&(!$isposted)?$data->author:set_value('author'),
				        'Tác giả',
				        false,
				        true,
				        '',
								50)?>
  <?php echo $this->mf->createTextBox(
				        'source',
				        isset($data)&&(!$isposted)?$data->source:set_value('source'),
				        'Nguồn',
				        false,
				        true,
				        '',
								100)?>
  <?php echo $this->mf->createSelectFull("cat_id", $categories,  isset($data)&&(!$isposted)?$data->cat_id:set_value('cat_id'), "Danh mục", "--- Chọn danh mục ---", true); ?>
  <?php echo $this->mf->createRadio("Hiển thị","display", DISPLAY_TYPES, isset($data)&&(!$isposted)?$data->display:set_value('display'),  true, true);?>
  <?php echo $this->mf->createEditor(
				        'content',
				        isset($data)&&(!$isposted)?$data->content:set_value('content'),
				        'Nội dung',
				        true,
				        true);?>
  <?php echo $this->mf->createButtons("back","AdminNew")?>

  <?php echo $this->mf->closeForm();?>
</div>

</div>
<script lang="javascript">
$(document).ready(function() {

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
  <?php $this->mu->jsValidate("myform", array("content")); ?>
});
</script>
