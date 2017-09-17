<div class="panel-group" role="tablist">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
  		<h4 class="panel-title">
  			<span><span class="glyphicon glyphicon-modal-window text-warning"></span> Quản lý Nhà tuyển dụng</span>
  		</h4>
  	</div>
    <div id="collapseOne" class="panel-collapse"
  		role="tabpanel" aria-labelledby="headingOne">
  		<div class="panel-body">
        <div class="col-md-4">
          <?php echo $this->mf->openForm("", "leftform");?>
          <?php $buttons = array(
                              array('id' => 'btnAdd', 'url' => site_url('AdminJobCareer'),'type' => 'success', 'icon' => 'plus'),
                              array('id' => 'btnEdit', 'url' => '#','type' => 'warning', 'icon' => 'edit'),
                              array('id' => 'btnDelete', 'url' => '#','type' => 'danger', 'icon' => 'remove')
                            );
          echo $this->mf->createFunctionButtons($buttons) ?>
          <?php echo $this->mf->createSelectMultipleFull("datas", $datas,  $current, "Trang", "350px"); ?>
          <?php echo $this->mf->createHidden("pageaction", "add")?>
          <?php echo $this->mf->closeForm();?>
        </div>
        <div class="col-md-8">
          <?php echo $this->mf->openForm("", "rightform");?>
          <?php echo $this->mf->createTextBox(
        				        'name',
        				        isset($data)&&(!$isposted)?$data->name:set_value('name'),
        				        'Tên',
        				        true,
        				        true,
        				        '',
        								100)?>
          <div class="col-md-3"></div>
          <div class="col-md-9"><span class="glyphicon glyphicon-arrow-down" id="ConvertLinkName2"></span></div>
          <?php echo $this->mf->createTextBox(
        				        'link_name',
        				        isset($data)&&(!$isposted)?$data->link_name:set_value('link_name'),
        				        'Friendly URL',
        				        true,
        				        true,
        				        '',
        								50)?>
          <?php echo $this->mf->createRadio("Hiển thị","display", DISPLAY_TYPES, isset($data)&&(!$isposted)?$data->display:set_value('display'),  true, true);?>
          <?php echo $this->mf->createTextBox(
        				        'icon',
        				        isset($data)&&(!$isposted)?$data->icon:set_value('icon'),
        				        'Icon',
        				        false,
        				        true,
        				        '',
        								100)?>
          <?php echo $this->mf->createHidden("id", isset($data)?$data->id:"0")?>
          <?php echo $this->mf->createButtons("reset")?>

          <?php echo $this->mf->closeForm();?>
        </div>
      </div>
    </div>
  </div>
</div>
<script lang="javascript">
$(document).ready(function() {

  $("#datas").dblclick(function(event) {
    $("#pageaction").val("");
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
  $("#ConvertLinkName").click(function(event) {
    $("#link_name").val(ConvertLinkName($("#name").val()));
  });
});
</script>
