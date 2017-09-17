
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="panel-group" role="tablist">
            <div class="panel panel-success">
              <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                  <span class="glyphicon glyphicon-star-empty"></span> Tin nổi bật
                  <a class="btn btn-default btn-detail" href=""><i class="fa fa-cloud-download"></i> Xem tất cả</a>
                </h4>
              </div>
              <div id="collapseOne" class="panel-collapse"
                role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                  <?php
                  foreach ($news as $item) {
                    ?>
                    <div class="media">
                      <a class="pull-left" href="#">
                        <img class="media-object img-responsive img-thumbnail" src="<?php echo base_url().FILE_IMAGE_URL_NEWS.'/'.$item->avatar; ?>" style="width:150px" alt="Image">
                      </a>
                      <div class="media-body">
                        <h4 class="media-heading"><a href="<?php echo site_url('tin_tuc/i/'.$item->id.'/'.$item->link_name) ?>"><?php echo $item->title;?></a></h4>
                        <p><?php echo $this->mu->cutString($item->content, 150); ?> <cite><?php echo $this->mu->showVNDate($item->public_date); ?></cite></p>
                      </div>
                    </div>
                    <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


    </div>
    <div class="col-md-3 top-td-center">
      <div class="panel-group" role="tablist">
        <div class="panel panel-success">
          <div class="panel-heading" role="tab" id="headingOne">
        		<h4 class="panel-title">
        			<span class="glyphicon glyphicon-star-empty"></span> Tuyển dụng
              <a class="btn btn-default btn-detail" href="<?php echo site_url('tuyendung') ?>"><i class="fa fa-cloud-download"></i> Xem tất cả</a>
        		</h4>
        	</div>
          <div id="collapseJob" class="panel-collapse"
        		role="tabpanel" aria-labelledby="headingOne">
        		<div class="panel-body">
              <?php
              foreach ($jobs as $item) {
                ?>
                <div class="card">
                  <img class="card-img-top img-responsive img-thumbnail" src="<?php echo base_url().FILE_IMAGE_URL_JOBS."/".$item["avatar"]; ?>" style="width: 100%; height: 150px" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title text-danger"><b><?php echo $item["title"];?></b></h5>
                    <p class="card-text"></p>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-info"><?php echo $item["name"];?></li>
                    <li class="list-group-item">
                    <span class="glyphicon glyphicon-link" aria-hidden="true"></span>
                     <?php echo $this->mu->formatMoney($item["salary_from"], false, "trieu",1)." - ".$this->mu->formatMoney($item["salary_to"], true,"trieu",1);?>
                     <div class="text-right" style="float:right">
                        <span class="text-muted"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></span>
                        <?php echo $this->mu->showVNDate($item['end_date']); ?></div>
                    </li>
                  </ul>
                </div>
                <?php
              }
               ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 top-td-center">
      <div class="panel-group" role="tablist">
        <div class="panel panel-success">
          <div class="panel-heading" role="tab" id="headingOne">
        		<h4 class="panel-title">
        			<span class="glyphicon glyphicon-star-empty"></span> Bất động sản
              <a class="btn btn-default btn-detail" href=""><i class="fa fa-cloud-download"></i> Xem tất cả</a>
        		</h4>
        	</div>
          <div id="collapseOne" class="panel-collapse"
        		role="tabpanel" aria-labelledby="headingOne">
        		<div class="panel-body">
              <?php
              foreach ($lands as $item) {
                ?>
                <div class="card">
                  <img class="card-img-top img-responsive img-thumbnail" src="<?php echo base_url().FILE_IMAGE_URL_LANDS."/".$item["avatar"]; ?>" style="width: 100%; height: 150px" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title text-danger iffyTip"><b><?php echo $this->mu->cutString($item["title"],200);?></b></h5>
                    <p class="card-text"></p>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                      <span class="text-muted"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></span>
                      <?php echo $this->mu->formatMoney($item["price"], true);?>
                    </li>
                    <li class="list-group-item">
                      <span class="text-muted"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span></span>
                      <?php echo ($item["width"]/1).' x '.($item['long']/1);?> m<sup>2</sup>
                      <div class="text-right" style="float:right">
                        <span class="text-muted"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></span>
                        <?php echo $this->mu->showVNDate($item['public_to']); ?></div>
                    </li>
                  </ul>
                </div>
                <?php
              }
               ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<script lang="javascript">
$(document).ready(function() {

});
</script>
