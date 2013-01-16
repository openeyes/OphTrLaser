<?php 	$this->breadcrumbs=array($this->module->id);
	$this->header();
?>
<h3 class="withEventIcon" style="background:transparent url(<?php echo $this->assetPath?>/img/medium.png) center left no-repeat;"><?php  echo $this->event_type->name ?></h3>

<div>
	<?php  $this->renderDefaultElements($this->action->id); ?>	
	<div class="cleartall"></div>
</div>


<div class="metaData">
	<span class="info">Laser Treatment created by <span class="user"><?php echo $this->event->user->fullname ?></span>
		on <?php echo $this->event->NHSDate('created_date') ?>
		at <?php echo date('H:i', strtotime($this->event->created_date)) ?></span>
	<span class="info">Laser Treatment last modified by <span class="user"><?php echo $this->event->usermodified->fullname ?></span>
		on <?php echo $this->event->NHSDate('last_modified_date') ?>
		at <?php echo date('H:i', strtotime($this->event->last_modified_date)) ?></span>
</div>

<?php  $this->footer();?>