
<h4 class="elementTypeName"><?php  echo $element->elementType->name ?></h4>

<table class="subtleWhite normalText">
	<tbody>
		<tr>
			<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('eye_id'))?></td>
			<td><span class="big"><?php echo $element->eye ? $element->eye->name : 'None'?></span></td>
		</tr>
		<tr>
			<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('procedure_id'))?></td>
			<td><span class="big"><?php echo $element->procedure ? $element->procedure->term : 'None'?></span></td>
		</tr>
	</tbody>
</table>
