
  <div class="row">

    <div class="col-md-6">
      <div class="row itemlist">

      <?php
      $i = 1;
      foreach ($noibats as $item) { ?>
        <div class="col-md-12">
          <div class="panel panel-default needhover">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-4">
                  <img class="card-img-top img-responsive img-thumbnail" src="<?php if ($item["avatar"] != "") { echo base_url().FILE_IMAGE_URL_JOBS."/".$item["avatar"]; } else {echo base_url().FILE_IMAGE_URL_COMPANIES."/".$item["avatar2"];} ?>" style="width: 100%; height: 100px" alt="Card image cap">
                </div>
                <div class="col-md-8 top-td-center">
                  <div class="item_title"><a href="<?php echo site_url('tuyendung/chitiet/'.$item['id'].'/'.$item['link_name']) ?>"><?php echo $item["title"] ?></a>
                    <?php
          					if ($this->ion_auth->is_admin())
          					{
          					 ?>
                     <a href="<?php echo site_url('AdminJob/update/'.$item['id']) ?>"><span class="fa fa-edit" aria-hidden="true"></span></a>
                   <?php } ?>
                 </div>
                   <div class="item_cat">
                     <a href="<?php echo site_url('tuyendung/chitiet/'.$item['id'].'/'.$item['link_name']) ?>"><?php echo $item["comname"] ?></a>
                   </div>
                   <div class="item_location">
                     <i class="fa fa-map-marker fa-fw"></i> <?php echo $item['locationname'] ?>
                     <div class="text-right item_date">Hạn cuối: <?php echo $this->mu->showVNDate($item['end_date']) ?></div>
                   </div>
                   <div class="item_money">
                     <?php echo $this->mu->showSalary($item['salary_from'], $item['salary_to']) ?>
                   </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      <?php $i++; } ?>
      </div>
    </div>
    <div class="col-md-3 top-td-center">

      <div class="list-group">
        <li class="list-group-item list-group-item-warning"><b>Danh sách ngành nghề</b></li>
        <?php $i = 0; foreach ($careers as $item) { ?>
        <a href="#" class="list-group-item"><span class="text-muted <?php echo $item["icon"]; ?>"></span>&nbsp; <b><?php echo $item["name"]; ?></b> <span class="badge"><?php echo $item["countnew"]>0?$item["countnew"]:"" ?></span></a>
        <?php } ?>
      </div>

      <div class="list-group">
        <li class="list-group-item list-group-item-warning"><b>Danh sách địa điểm</b></li>
        <?php $i = 0; foreach ($locations as $item) { ?>
        <a href="#" class="list-group-item"><span class="text-muted glyphicon glyphicon-chevron-right"></span>&nbsp; <b><?php echo $item["name"]; ?></b> <span class="badge"><?php echo $item["countnew"]>0?$item["countnew"]:"" ?></span></a>
        <?php } ?>
      </div>

      <div class="list-group">
        <li class="list-group-item list-group-item-warning"><b>Nhà tuyển dụng nổi bật</b></li>
        <?php $i = 0; foreach ($companies as $item) { ?>
        <a href="#" class="list-group-item needhover">
          <div class="media">
            <div class="media-left">
              <img src="<?php echo FILE_IMAGE_URL_COMPANIES.'/'.$item['avatar'] ?>" class="media-object" style="width:80px">
            </div>
            <div class="media-body">
              <h4 class="media-heading" style="height: 50px;vertical-align: middle;display: table-cell;"><?php echo $item['name'] ?></h4>

            </div>
          </div>
        </a>
        <?php } ?>
      </div>
    </div>
    <div class="col-md-3 top-td-center">
      <?php if(count($noibats) > 0) {
      ?>
      <div class="list-group">
        <li class="list-group-item list-group-item-info"><b><i class="fa fa-feed" aria-hidden="true"></i> Tuyển dụng mới</b></li>

          <?php $i = 0; foreach ($noibats as $item) {
            $data['item'] = $item;
            $this->view('home/small/tuyendung_list_item', $data);
           } ?>

      </div>
      <?php
      }
      else { echo "Chưa có"; }
      ?>
    </div>
  </div>

<script lang="javascript">
$(document).ready(function() {

});
</script>
