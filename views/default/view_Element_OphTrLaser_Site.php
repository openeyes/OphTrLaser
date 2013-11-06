<?php /* DEPRECATED */ ?>

<h4 class="elementTypeName"><?php  echo $element->elementType->name ?></h4>

<table class="subtleWhite normalText">
	<tbody>
		<tr>
			<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('site_id'))?></td>
			<td><span class="big"><?php echo $element->site ? $element->site->name : 'None'?></span></td>
		</tr>
		<tr>
			<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('laser_id'))?></td>
			<td><span class="big"><?php echo $element->laser ? $element->laser->name : 'None'?></span></td>
		</tr>
		<tr>
			<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('surgeon_id'))?></td>
			<td><span class="big"><?php echo $element->surgeon ? $element->surgeon->ReversedFullName : 'None'?></span></td>
		</tr>
	</tbody>
</table>
