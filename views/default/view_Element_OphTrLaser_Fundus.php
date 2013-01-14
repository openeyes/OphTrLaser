
<h4 class="elementTypeName"><?php  echo $element->elementType->name ?></h4>

<table class="subtleWhite normalText">
	<tbody>
		<tr>
			<td colspan="2">
				<?php
				$this->widget('application.modules.eyedraw2.OEEyeDrawWidget', array(
						'idSuffix' => 'right_'.$element->elementType->id,
						'side' => 'R',
						'mode' => 'view',
						'width' => 200,
						'height' => 200,
						'model' => $element,
						'attribute' => 'right_eyedraw',
				));
				?>
			</td>
		</tr>
		
		<tr>
			<td colspan="2">
				<?php
				$this->widget('application.modules.eyedraw2.OEEyeDrawWidget', array(
						'idSuffix' => 'left_'.$element->elementType->id,
						'side' => 'L',
						'mode' => 'view',
						'width' => 200,
						'height' => 200,
						'model' => $element,
						'attribute' => 'left_eyedraw',
				));
				?>
			</td>
		</tr>
	</tbody>
</table>
