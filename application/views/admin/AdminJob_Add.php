<?php $this->mu->jsInclude("ckeditor");?>
<?php $this->mu->jsInclude("validation");?>
<?php $this->mu->jsInclude("fileinput"); ?>
<?php $this->mu->jsInclude("datepicker"); ?>
<?php $this->mu->jsInclude("timepicker"); ?>
<?php $this->mu->jsInclude("maskmoney"); ?>
<script>
        CKEDITOR.config.filebrowserUploadUrl = '<?=site_url("Home/upload")?>';
</script>
<div class="panel-group" role="tablist">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
  		<h4 class="panel-title">
  			<span><span class="glyphicon glyphicon-modal-window text-warning"></span> Cập nhập Tuyển dụng</span>
  		</h4>
  	</div>
    <div id="collapseOne" class="panel-collapse"
  		role="tabpanel" aria-labelledby="headingOne">
  		<div class="panel-body">
        <?php echo $this->mf->openForm("", "myform");?>
        <?php echo $this->mf->createTextBox(
      				        'title',
      				        isset($data)&&(!$isposted)?$data->title:set_value('title'),
      				        'Tiêu đề',
      				        true,
      				        true,
      				        '',
      								255)?>
        <div class="col-md-3"></div>
        <div class="col-md-9"><span class="glyphicon glyphicon-arrow-down" id="ConvertLinkName"></span></div>

        <?php echo $this->mf->createTextBox(
      				        'link_name',
      				        isset($data)&&(!$isposted)?$data->link_name:set_value('link_name'),
      				        'Friendly URL',
      				        true,
      				        true,
      				        '',
      								255)?>
        <?php echo $this->mf->createTextBox(
      				        'position',
      				        isset($data)&&(!$isposted)?$data->position:set_value('position'),
      				        'Vị trí tuyển dụng',
      				        true,
      				        true,
      				        '',
      								255)?>
        <?php echo $this->mf->createImageUpload(
      				        'avatar',
      				        'Hình ảnh đại diện (nếu có)',
      				        false,
      				        true,
      				        'Chọn file',
      				        isset($data)&&(!$isposted)?$data->avatar:'',FILE_IMAGE_URL_JOBS); ?>
        <?php echo $this->mf->createDatePicker(
				        'Ngày bắt đầu',
				        'start_date',
				        isset($data)&&(!$isposted)?$this->mu->showVNDate($data->start_date):set_value('start_date'),
				        'Ngày bắt đầu',
				        true,
				        true);?>
        <?php echo $this->mf->createDatePicker(
				        'Ngày kết thúc',
				        'end_date',
				        isset($data)&&(!$isposted)?$this->mu->showVNDate($data->end_date):set_value('end_date'),
				        'Ngày kết thúc',
				        true,
				        true);?>
        <?php echo $this->mf->createManyTextBox(
				        'Mức lương',
				        array('salary_from', 'salary_to'),
				        array(isset($data)&&(!$isposted)?$data->salary_from:set_value('salary_from'),
				                isset($data)&&(!$isposted)?$data->salary_to:set_value('salary_to')),
				        array('Từ', 'Đến'),
				        array(true, true),
				        array(true, true),
				        array('', ''),
				        array('',''),
								array(10, 10),
								array(0,0))?>
        <?php echo $this->mf->createSelectFull("display", DISPLAY_TYPES_NEWS,  isset($data)&&(!$isposted)?$data->display:set_value('display'), "Hiển thị", "--- Chọn trạng thái hiển thị ---", true); ?>
        <?php echo $this->mf->createSelectFull("career_id", $careers,  isset($data)&&(!$isposted)?$data->career_id:set_value('career_id'), "Danh mục", "--- Chọn nghề ---", true); ?>
        <?php echo $this->mf->createSelectFull("company_id", $companies,  isset($data)&&(!$isposted)?$data->company_id:set_value('company_id'), "Công ty", "--- Chọn công ty ---", true); ?>
        <?php echo $this->mf->createSelectMultipleFull("language", LANGUAGE_LIST,  isset($data)&&(!$isposted)?$this->mu->stringToArray($data->language):set_value('language'), "Ngôn ngữ", "Chọn ngôn ngữ"); ?>
        <?php echo $this->mf->createEditor(
      				        'description',
      				        isset($data)&&(!$isposted)?$data->description:set_value('description'),
      				        'Mô tả công việc',
      				        true,
      				        true);?>
        <?php echo $this->mf->createEditor(
      				        'requirement',
      				        isset($data)&&(!$isposted)?$data->requirement:set_value('requirement'),
      				        'Yêu cầu công việc',
      				        true,
      				        true);?>
        <?php echo $this->mf->createEditor(
      				        'benefit',
      				        isset($data)&&(!$isposted)?$data->benefit:set_value('benefit'),
      				        'Phúc lợi',
      				        true,
      				        true);?>
        <?php echo $this->mf->createButtons("back","AdminJob")?>

        <?php echo $this->mf->closeForm();?>
      </div>
    </div>
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
  $("#ConvertLinkName").click(function(event) {
    $("#link_name").val(ConvertLinkName($("#title").val()));
  });

  $('#salary_from').maskMoney({prefix:'', allowNegative: false, thousands:'.', decimal:',', affixesStay: false, precision: 0});
  $('#salary_to').maskMoney({prefix:'', allowNegative: false, thousands:'.', decimal:',', affixesStay: false, precision: 0});
  <?php $this->mu->jsValidate("myform", array("content")); ?>
});
</script>
