<div class="element <?php echo $element->elementType->class_name ?>">
<h4 class="elementTypeName"><?php  echo $element->elementType->name ?></h4>
<div class="cols2 clearfix">
	<div class="left eventDetail">
		<h4>Right</h4>
		<?php if($element->hasRight()) {
			if (!$element->right_procedures) {
				echo "None";
			}
			else {
				echo "<ul>";
				foreach ($element->right_procedures as $proc) {
					echo "<li>" . $proc->term . "</li>";
				}
				echo "</ul>";
			}
		} else { ?>
		Not recorded
		<?php } ?>
	</div>
	<div class="right eventDetail">
		<h4>Left</h4>
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
		<p>Not recorded</p>
		<?php } ?>
	</div>
</div>
<?php $this->renderChildDefaultElements($element, $this->action->id, $form, $data); ?>
</div>