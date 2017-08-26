<div class="panel-group" role="tablist">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
  		<h4 class="panel-title">
  			<a data-toggle="collapse" data-parent="#accordion"
  				href="#collapseOne" aria-expanded="true"
  				aria-controls="collapseOne"><span class="glyphicon glyphicon-star-empty"></span> Tin nổi bật</a>
  		</h4>
  	</div>
    <div id="collapseOne" class="panel-collapse"
  		role="tabpanel" aria-labelledby="headingOne">
  		<div class="panel-body">
        <?php
        foreach ($noibats as $item) {
          ?>
          <div class="col-md-3">
            <div>
              <img src="<?php echo base_url().FILE_IMAGE_URL_NEWS."/".$item->avatar; ?>" style="width: 100%; height: 150px" />
            </div>
            <div>
              <?php echo $item->title;?>
            </div>
          </div>
          <?php
        }
         ?>
      </div>
    </div>
  </div>
</div>
<script lang="javascript">
$(document).ready(function() {

});
</script>
