
<h4 class="elementTypeName"><?php  echo $element->elementType->name ?></h4>

<table class="subtleWhite normalText">
	<tbody>
		<tr>
			<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('eye_id'))?></td>
			<td><span class="big"><?php echo $element->eye ? $element->eye->name : 'None'?></span></td>
		</tr>
		<tr>
			<td colspan="2">
				<?php
					$this->widget('application.modules.eyedraw.OEEyeDrawWidgetPosteriorSegment', array(
						'side'=>$element->eye->getShortName(),
						'mode'=>'view',
						'size'=>300,
						'model'=>$element,
						'attribute'=>'left_eyedraw',
					));
				?>
			</td>
		</tr>
		
		<tr>
			<td colspan="2">
				<?php
					$this->widget('application.modules.eyedraw.OEEyeDrawWidgetPosteriorSegment', array(
						'side'=>$element->eye->getShortName(),
						'mode'=>'view',
						'size'=>300,
						'model'=>$element,
						'attribute'=>'right_eyedraw',
					));
				?>
			</td>
		</tr>
		
	</tbody>
</table>
