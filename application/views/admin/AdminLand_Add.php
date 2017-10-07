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
  			<span><span class="glyphicon glyphicon-modal-window text-warning"></span> Cập nhật <?php echo isset($data)&&(!$isposted)?$data->title:"" ?></span>
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
      								150)?>
        <div class="col-md-3"></div>
        <div class="col-md-9"><span class="glyphicon glyphicon-arrow-down" id="ConvertLinkName"></span></div>

        <?php echo $this->mf->createTextBox(
      				        'link_name',
      				        isset($data)&&(!$isposted)?$data->link_name:set_value('link_name'),
      				        'Friendly URL',
      				        true,
      				        true,
      				        '',
      								150)?>
        <?php echo $this->mf->createTextBox(
      				        'address',
      				        isset($data)&&(!$isposted)?$data->address:set_value('address'),
      				        'Địa chỉ',
      				        true,
      				        true,
      				        '',
      								100)?>
        <?php echo $this->mf->createSelectFull("location_id", $locations,  isset($data)&&(!$isposted)?$data->location_id:set_value('location_id'), "Địa điểm", "--- Chọn địa điểm ---", true); ?>
        <?php echo $this->mf->createImageUpload(
      				        'avatar',
      				        'Hình ảnh đại diện (nếu có)',
      				        false,
      				        true,
      				        'Chọn file',
      				        isset($data)&&(!$isposted)?$data->avatar:'',FILE_IMAGE_URL_LANDS); ?>
        <?php echo $this->mf->createDatePicker(
				        'Ngày bắt đầu',
				        'public_from',
				        isset($data)&&(!$isposted)?$this->mu->showVNDate($data->public_from):set_value('public_from'),
				        'Ngày bắt đầu',
				        true,
				        true);?>
        <?php echo $this->mf->createDatePicker(
				        'Ngày kết thúc',
				        'public_to',
				        isset($data)&&(!$isposted)?$this->mu->showVNDate($data->public_to):set_value('public_to'),
				        'Ngày kết thúc',
				        true,
				        true);?>
        <?php echo $this->mf->createManyTextBox(
				        'Diện tích',
				        array('width', 'long'),
				        array(isset($data)&&(!$isposted)?$data->width:set_value('width'),
				                isset($data)&&(!$isposted)?$data->long:set_value('long')),
				        array('Dài', 'Rộng'),
				        array(true, true),
				        array(true, true),
				        array('', ''),
				        array('',''),
								array(10, 10),
								array(0,0),
                array('number', 'number'));?>
      <?php echo $this->mf->createTextBox(
    				        'livesize',
    				        isset($data)&&(!$isposted)?$data->livesize:set_value('livesize'),
    				        'Diện tích sử dụng (m2)',
    				        false,
    				        true,
    				        '',
    								12, 0,
                    'number')?>
        <?php echo $this->mf->createTextBox(
        'price',
        isset($data)&&(!$isposted)?$data->price:set_value('price'),
        'Giá',
        true,
        true,
        '',
				15)?>
        <?php echo $this->mf->createTextBox(
        'mapx',
        isset($data)&&(!$isposted)?$data->mapx:set_value('mapx'),
        'Google map X',
        false,
        true,
        '',
				20,0,
        'number')?>
        <?php echo $this->mf->createTextBox(
        'mapy',
        isset($data)&&(!$isposted)?$data->mapy:set_value('mapy'),
        'Google map Y',
        false,
        true,
        '',
				20,0,
        'number')?>
        <?php echo $this->mf->createTextBox(
        'contacter',
        isset($data)&&(!$isposted)?$data->contacter:set_value('contacter'),
        'Người liên hệ',
        false,
        true,
        '',
				150)?>
        <?php echo $this->mf->createTextBox(
        'phone',
        isset($data)&&(!$isposted)?$data->phone:set_value('phone'),
        'Điện thoại',
        false,
        true,
        '',
				150)?>
        <?php echo $this->mf->createSelectFull("display", DISPLAY_TYPES_NEWS,  isset($data)&&(!$isposted)?$data->display:set_value('display'), "Hiển thị", "--- Chọn trạng thái hiển thị ---", true); ?>
        <?php echo $this->mf->createSelectFull("type", $categories,  isset($data)&&(!$isposted)?$data->type:set_value('type'), "Danh mục", "--- Chọn nghề ---", true, true,true); ?>
        <?php echo $this->mf->createEditor(
      				        'description',
      				        isset($data)&&(!$isposted)?$data->description:set_value('description'),
      				        'Mô tả',
      				        true,
      				        true);?>
        <?php echo $this->mf->createButtons("back","AdminLand")?>

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

  $('#price').maskMoney({prefix:'', allowNegative: false, thousands:'.', decimal:',', affixesStay: false, precision: 0});
  //$('#mapx').maskMoney({prefix:'', allowNegative: false, thousands:'', decimal:'.', affixesStay: true, precision: 5});
  //$('#mapy').maskMoney({prefix:'', allowNegative: false, thousands:'', decimal:'.', affixesStay: false, precision: 5});
  <?php $this->mu->jsValidate("myform", array("content")); ?>
});
</script>
