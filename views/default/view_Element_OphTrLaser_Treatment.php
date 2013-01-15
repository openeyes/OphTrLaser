<div class="element <?php echo $element->elementType->class_name ?>">
<h4 class="elementTypeName"><?php  echo $element->elementType->name ?></h4>
<div class="cols2 clearfix">
	<div class="left eventDetail">
		<?php if($element->hasRight()) {
			if (!$element->right_procedures) {
				echo "None";
			}
			else {
				foreach ($element->right_procedures as $proc) {
					echo $proc->term . "<br />";
				}
			}
		} else { ?>
		Not recorded
		<?php } ?>
	</div>
	<div class="right eventDetail">
		<?php if($element->hasLeft()) {
			if (!$element->left_procedures) {
				echo "None";
			}
			else {
				foreach ($element->left_procedures as $proc) {
					echo $proc->term . "<br />";
				}
			}
		} else { ?>
		Not recorded
		<?php } ?>
	</div>
</div>
<?php $this->renderChildDefaultElements($element, $this->action->id, $form, $data); ?>
</div>