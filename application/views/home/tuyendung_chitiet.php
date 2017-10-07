
  <div class="row">

    <div class="col-md-6">
      <div class="row itemlist">

        <div class="col-md-12">
          <div class="panel panel-default needhover">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-4">
                  <img class="card-img-top img-responsive img-thumbnail" src="<?php if ($item["avatar"] != "") { echo base_url().FILE_IMAGE_URL_JOBS."/".$item["avatar"]; } else {echo base_url().FILE_IMAGE_URL_COMPANIES."/".$item["avatar2"];} ?>" style="width: 100%; height: 100px" alt="Card image cap">
                </div>
                <div class="col-md-8 top-td-center">
                  <div class="item_title"><a><?php echo $item["title"] ?></a>
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

                </div>
              </div>
              <div class="row top-buffer">
                <div class="col-md-12">
                  <table class="table table-striped">
                    <tbody>
                      <tr>
                        <td><b>Nơi làm việc</b></td>
                        <td><b>Mức lương</b></td>
                      </tr>
                      <tr>
                        <td class="item_location"><i class="fa fa-map-marker fa-fw"></i> <?php echo $item['locationname'] ?></td>
                        <td class="item_money">
                          <?php echo $this->mu->showSalary($item['salary_from'], $item['salary_to']) ?>
                        </td>
                      </tr>
                      <tr>
                        <td><b>Vị trí tuyển dụng</b></td>
                        <td><b>Ngành nghề</b></td>
                      </tr>
                      <tr>
                        <td><?php echo $item['position'] ?></td>
                        <td>
                          <?php echo $item['careername'] ?>
                        </td>
                      </tr>
                      <tr>
                        <td><b>Tuyển dụng từ ngày</b></td>
                        <td><b>Tuyển dụng đến ngày</b></td>
                      </tr>
                      <tr>
                        <td><?php echo $this->mu->showVNDate($item['start_date']) ?></td>
                        <td><?php echo $this->mu->showVNDate($item['end_date']) ?></td>
                      </tr>
                      <tr>
                        <td><b>Bằng cấp tối thiểu</b></td>
                        <td><b>Ngoại ngữ</b></td>
                      </tr>
                      <tr>
                        <td><?php echo $this->mu->showDataFromArray($item['education'], EDUCATION_LIST) ?></td>
                        <td><?php echo $this->mu->showDataFromArray($item['language'], LANGUAGE_LIST) ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-success">
                    <div class="panel-heading"><b>Mô tả công việc</b></div>
                    <div class="panel-body"><?php echo $item["description"]; ?></div>
                  </div>
                  <div class="panel panel-success">
                    <div class="panel-heading"><b>Yêu cầu công việc</b></div>
                    <div class="panel-body"><?php echo $item["requirement"]; ?></div>
                  </div>
                  <div class="panel panel-success">
                    <div class="panel-heading"><b>Chế độ công việc</b></div>
                    <div class="panel-body"><?php echo $item["benefit"]; ?></div>
                  </div>

                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 top-td-center">
      <div class="list-group">
        <li class="list-group-item">
          <div class="fb-like"
            data-href="http://www.your-domain.com/your-page.html"
            data-layout="standard"
            data-action="like"
            data-show-faces="true">
          </div>
        </li>
      </div>
      <div class="list-group">
        <li class="list-group-item list-group-item-info"><b><i class="fa fa-feed" aria-hidden="true"></i> Cùng ngành nghề</b></li>
        <?php if(count($cungchuyenmuc) > 0) {
          $i = 0;
          foreach ($cungchuyenmuc as $item) {
            $data['item'] = $item;
            $this->view('home/small/tuyendung_list_item', $data);
          }
        }
        else { echo '<li class="list-group-item itemListSmall text-muted">Chưa có</li>'; }
        ?>
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
  </div>

<script lang="javascript">
$(document).ready(function() {

});
</script>
