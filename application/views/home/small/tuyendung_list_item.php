<li class="list-group-item itemListSmall needhover">
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
