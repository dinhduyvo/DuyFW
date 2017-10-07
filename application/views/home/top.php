
  <div class="row">
    <div class="col-md-6">
      <!-- Carousel start -->
      <div class="row" style="margin-bottom:15px">
        <div class="col-md-12">
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

      </div>
      <!-- Carousel end -->

      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 itemListSmall">
          <?php
          foreach ($news as $item) {
            ?>
          <div class="panel panel-default panel-news needhover">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-5">
                  <img class="card-img-top img-responsive img-thumbnail" src="<?php echo base_url().FILE_IMAGE_URL_NEWS.'/'.$item->avatar; ?> ?>" style="width: 100%; height: 150px" alt="Card image cap">
                </div>
                <div class="col-md-7 top-td-center">
                  <div class="item_title_news"><a href="<?php echo site_url('tin_tuc/i/'.$item->id.'/'.$item->link_name) ?>"><?php echo $item->title;?></a></a>
                    <?php
          					if ($this->ion_auth->is_admin())
          					{
          					 ?>
                     <a href="<?php echo site_url('AdminNew/update/'.$item['id']) ?>"><span class="fa fa-edit" aria-hidden="true"></span></a>
                   <?php } ?>
                 </div>
                   <div class="item_cat">
                     <p><?php echo $this->mu->cutString($item->content, 150); ?></p>
                   </div>
                   <div class="item_date"><i class="fa fa-calendar" aria-hidden="true"></i> Ngày đăng: <?php echo $this->mu->showVNDate($item->public_date) ?></div>
                </div>
              </div>

            </div>
          </div>
        <?php } ?>
        </div>
      </div>


    </div>
    <div class="col-md-3 top-td-center">
      <div class="list-group">
        <li class="list-group-item list-group-item-info">
          <b><i class="fa fa-feed" aria-hidden="true"></i> Tuyển dụng</b>
          <a class="btn btn-default btn-detail" href="<?php echo site_url('tuyendung') ?>"><i class="fa fa-cloud-download"></i> Xem tất cả</a>
        </li>


          <?php
          foreach ($jobs as $item) {
            ?>
            <li class="list-group-item itemListSmall needhover">
              <img class="card-img-top img-responsive img-thumbnail" src="<?php echo base_url().($item["avatar"]!=''?FILE_IMAGE_URL_JOBS."/".$item["avatar"]:FILE_IMAGE_URL_COMPANIES."/".$item["avatar2"]); ?>" style="width: 100%; height: 150px; margin-bottom: 10px;" alt="Card image cap">
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

               </div>
               <div class="item_date"><i class="fa fa-calendar" aria-hidden="true"></i> Hạn cuối: <?php echo $this->mu->showVNDate($item['end_date']) ?></div>
               <div class="item_money">
                 <?php echo $this->mu->showSalary($item['salary_from'], $item['salary_to']) ?>
               </div>
            </li>
            <?php
          }
           ?>

      </div>
    </div>
    <div class="col-md-3 top-td-center">
      <div class="list-group">
        <li class="list-group-item list-group-item-info">
          <b><i class="fa fa-feed" aria-hidden="true"></i> Bất động sản</b>
          <a class="btn btn-default btn-detail" href="<?php echo site_url('tuyendung') ?>"><i class="fa fa-cloud-download"></i> Xem tất cả</a>
        </li>


          <?php
          foreach ($lands as $item) {
            ?>
            <li class="list-group-item itemListSmall needhover">
              <img class="card-img-top img-responsive img-thumbnail" src="<?php echo base_url().FILE_IMAGE_URL_LANDS."/".$item["avatar"]; ?>" style="width: 100%; height: 150px; margin-bottom: 10px;" alt="Card image cap">
              <div class="item_title iffyTip"><a href="<?php echo site_url('tuyendung/chitiet/'.$item['id'].'/'.$item['link_name']) ?>"><?php echo $item["title"] ?></a>
                <?php
                if ($this->ion_auth->is_admin())
                {
                 ?>
                 <a href="<?php echo site_url('AdminJob/update/'.$item['id']) ?>"><span class="fa fa-edit" aria-hidden="true"></span></a>
               <?php } ?>
             </div>
               <div class="item_cat">
                 <span class="text-muted"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span></span>
                 <?php echo ($item["width"]/1).' x '.($item['long']/1);?> m<sup>2</sup>
               </div>
               <div class="item_location">
                 <i class="fa fa-map-marker fa-fw"></i> <?php echo $item['locationname'] ?>

               </div>
               <div class="item_date"><i class="fa fa-calendar" aria-hidden="true"></i> Hạn cuối:   <?php echo $this->mu->showVNDate($item['public_to']); ?></div>
               <div class="item_money">
                 <span class="text-muted"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></span>
                 <?php echo $this->mu->formatMoney($item["price"], true);?>
               </div>
            </li>
            <?php
          }
           ?>

      </div>


    </div>
  </div>

<script lang="javascript">
$(document).ready(function() {

});
</script>
