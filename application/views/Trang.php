<div class="panel-group" role="tablist">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
  		<h4 class="panel-title">
  			<span><span class="glyphicon glyphicon-modal-window text-warning"></span> <?php echo isset($dcontents['title'])?$dcontents['title']:$dpages['title'] ?></span>
  		</h4>
  	</div>
    <div id="collapseOne" class="panel-collapse"
  		role="tabpanel" aria-labelledby="headingOne">
  		<div class="panel-body">
      <?php echo isset($dcontents['content'])?$dcontents['content']:'' ?>
      </div>
    </div>
  </div>
</div>
<script lang="javascript">
$(document).ready(function() {

});
</script>
