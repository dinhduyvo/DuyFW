
  <div class="row">
    <div class="col-md-6">
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
              foreach ($noibats as $item) {
                ?>
                <div class="card card-default">
                  <img class="card-img-top" src="<?php echo base_url().FILE_IMAGE_URL_NEWS."/".$item->avatar; ?>" style="width: 100%; height: 150px" alt="Card image cap">
                  <div class="card-body">
                    <h4 class="card-title"><em class="glyphicon glyphicon-record text-muted"></em> <a href="<?php echo site_url('tin_tuc/i/'.$item->id.'/'.$item->link_name) ?>"><?php echo $item->title;?></a></h4>
                    <p class="card-text"><?php echo $this->mu->cutString($item->content, 150); ?> <cite><?php echo $this->mu->showVNDate($item->public_date); ?></cite></p>
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
    <div class="col-md-3 top-td-center">
      <div class="panel-group" role="tablist">
        <div class="panel panel-success">
          <div class="panel-heading" role="tab" id="headingOne">
        		<h4 class="panel-title">
        			<span class="glyphicon glyphicon-star-empty"></span> Tuyển dụng
              <a class="btn btn-default btn-detail" href=""><i class="fa fa-cloud-download"></i> Xem tất cả</a>
        		</h4>
        	</div>
          <div id="collapseJob" class="panel-collapse"
        		role="tabpanel" aria-labelledby="headingOne">
        		<div class="panel-body">
              <?php
              foreach ($jobs as $item) {
                ?>
                <div class="card">
                  <img class="card-img-top" src="<?php echo base_url().FILE_IMAGE_URL_JOBS."/".$item["avatar"]; ?>" style="width: 100%; height: 150px" alt="Card image cap">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $item["title"];?></h4>
                    <p class="card-text"></p>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-info"><?php echo $item["name"];?></li>
                    <li class="list-group-item">Mức lương: <?php echo $this->mu->formatMoney($item["salary_from"])." - ".$this->mu->formatMoney($item["salary_to"]);?></li>
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
              foreach ($noibats as $item) {
                ?>
                <div class="card">
                  <img class="card-img-top" src="<?php echo base_url().FILE_IMAGE_URL_NEWS."/".$item->avatar; ?>" style="width: 100%; height: 150px" alt="Card image cap">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $item->title;?></h4>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-info">Cras justo odio</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Vestibulum at eros</li>
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
