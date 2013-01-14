<?php

class DefaultController extends NestedElementsEventTypeController {
	
	protected function setPOSTManyToMany($element) {
		if (get_class($element) == 'Element_OphTrLaser_Treatment') {
			if (isset($_POST['treatment_right_procedures'])) {
				foreach ($_POST['treatment_right_procedures'] as $proc_id) {
					$right_procedures[] = Procedure::model()->findByPk($proc_id);
				}
				$element->right_procedures = $right_procedures;
			}
			if (isset($_POST['treatment_left_procedures'])) {
				foreach ($_POST['treatment_left_procedures'] as $proc_id) {
					$left_procedures[] = Procedure::model()->findByPk($proc_id);
				}
				$element->left_procedures = $left_procedures;
			}
		}
	}
	
	public function updateElements($elements, $data, $event) {
		if (parent::updateElements($elements, $data, $event)) {
			// update has been successful, now need to deal with many to many changes
			foreach ($elements as $el) {
				if (get_class($el) == 'Element_OphTrLaser_Treatment') {
					$el->updateRightProcedures(isset($_POST['treatment_right_procedures']) ? $_POST['treatment_right_procedures'] : array());
					$el->updateLeftProcedures(isset($_POST['treatment_left_procedures']) ? $_POST['treatment_left_procedures'] : array());
				} 
			}
		}
		return true;
	}
	
}
