
  <div class="row">
    
    <div class="col-md-6">
        <div id="carousel-id" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php $i = 0;
                foreach ($noibats as $item) { ?>
                  <li data-target="#carousel-id" data-slide-to="<?php echo $i; ?>" class="<?php if($i==0) echo 'active'; ?>"></li>
                <?php $i++; } ?>
            </ol>
            <div class="carousel-inner">
                <?php $i = 0; foreach ($noibats as $item) { ?>
                  <div class="item <?php if($i==0) echo 'active'; ?>">
                      <img class="img-responsive img-thumbnail" style="width:100%; height: 300px" src="<?php echo base_url().($item['vtype']=='NEWS'?FILE_IMAGE_URL_NEWS:($item['vtype']=='JOBS'?FILE_IMAGE_URL_JOBS:FILE_IMAGE_URL_LANDS)).'/'.$item['avatar2']; ?>">
                      <div class="container">
                          <div class="carousel-caption">
                            <div style="background-color: rgba(255,255,255,0.7); padding:2px; border-radius: 5px;">
                              <h3 >
                                <?php echo $item['title'];?>
                              </h3>
                              <h5><?php echo $this->mu->cutString($item['description'], 150); ?></h5>
                            </div>
                          </div>
                      </div>
                  </div>
                <?php $i++; } ?>
            </div>
            <a class="left carousel-control" href="#carousel-id" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
            <a class="right carousel-control" href="#carousel-id" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
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
      
    </div>
    <div class="col-md-3 top-td-center">
      <div class="list-group">
        <li class="list-group-item list-group-item-warning"><b>Nhà tuyển dụng nổi bật</b></li>
        <?php $i = 0; foreach ($companies as $item) { ?>
        <a href="#" class="list-group-item">
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
  </div>

<script lang="javascript">
$(document).ready(function() {

});
</script>
