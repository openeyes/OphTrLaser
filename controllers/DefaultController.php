<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

class DefaultController extends BaseEventTypeController
{
	// This map defines which elements can import eyedraw data from the most recent element type in the current episode
	public static $IMPORT_ELEMENTS = array(
			'Element_OphTrLaser_PosteriorPole' => 'Element_OphCiExamination_PosteriorPole',
			'Element_OphTrLaser_AnteriorSegment' => 'Element_OphCiExamination_AnteriorSegment'
			);

	/**
	 * sets up some javascript variables for use in the editing views
	 */
	protected function _jsCreate()
	{
		$l_by_s = array();
		foreach (OphTrLaser_Site_Laser::model()->findAll() as $slaser) {
			$l_by_s[$slaser->site_id][] = array('id' => $slaser->id, 'name' => $slaser->name);
		}
		Yii::app()->getClientScript()->registerScript('OphTrLaserJS', 'var lasersBySite = ' . CJavaScript::encode($l_by_s) . ';', CClientScript::POS_HEAD);
	}

	/**
	 * Loads the split event type javascript libraries
	 *
	 * @param CAction $action
	 * @return bool
	 */
	protected function beforeAction($action)
	{
		if (!Yii::app()->getRequest()->getIsAjaxRequest() && !(in_array($action->id,$this->printActions())) ) {
			Yii::app()->getClientScript()->registerScriptFile(Yii::app()->createUrl('js/spliteventtype.js'));
		}

		return parent::beforeAction($action);
	}

	/**
	 * need to ensure we load the required js
	 */
	public function initActionCreate()
	{
		parent::initActionCreate();
		$this->_jsCreate();
	}

	/**
	 * need to ensure we load the required js
	 *
	 */
	public function initActionUpdate()
	{

		parent::initActionUpdate();
		$this->_jsCreate();
	}

	/**
	 * Applies workflow and filtering to the element retrieval
	 *
	 * @return BaseEventTypeElement[]
	 */
	protected function getEventElements()
	{
		if ($this->event) {
			$elements = $this->event->getElements();
		}
		else {
			$elements = $this->event_type->getDefaultElements();
			foreach ($elements as $el) {
				$this->importElementEyeDraw($el);
			}
		}

		return $elements;
	}

	/**
	 * Look for and import eyedraw values from most recent related element if available
	 *
	 * @param BaseEventTypeElement $element
	 */
	protected function importElementEyeDraw($element)
	{
		if ($this->episode ) {
			$el_class = get_class($element);
			if (array_key_exists($el_class, self::$IMPORT_ELEMENTS)) {
				$import_model = self::$IMPORT_ELEMENTS[$el_class];
				$previous = $this->episode->getElementsOfType($import_model::model()->getElementType());
				if (count($previous)) {
					$import = $previous[0];
				}

				if ($import) {
					$element->left_eyedraw = $import->left_eyedraw;
					$element->right_eyedraw = $import->right_eyedraw;
					$element->eye_id = $import->eye_id;
				}
			}
		}

	}

	/**
	 * Override to call the eyedraw import for loaded elements
	 *
	 */
	protected function getElementForElementForm($element_type, $previous_id = 0, $additional)
	{
		$element = parent::getElementForElementForm($element_type, $previous_id, $additional);

		// do eyedraw import
		$this->importElementEyeDraw($element);

		return $element;
	}

	/**
	 * Sets Laser Procedures
	 *
	 * @param BaseEventTypeElement $element
	 * @param array $data
	 * @param null $index
	 */
	protected function setElementComplexAttributesFromData($element, $data, $index=null)
	{
		if (get_class($element) == 'Element_OphTrLaser_Treatment') {
			$right_procedures = array();
			if (isset($data['treatment_right_procedures'])) {
				foreach ($data['treatment_right_procedures'] as $proc_id) {
					$right_procedures[] = Procedure::model()->findByPk($proc_id);
				}
			}
			$element->right_procedures = $right_procedures;

			$left_procedures = array();
			if (isset($data['treatment_left_procedures'])) {
				foreach ($data['treatment_left_procedures'] as $proc_id) {
					$left_procedures[] = Procedure::model()->findByPk($proc_id);
				}
			}
			$element->left_procedures = $left_procedures;
		}
	}

	/**
	 * Saves the Laser Procedures
	 *
	 * @param array $data
	 */
	protected function saveEventComplexAttributesFromData($data)
	{
		foreach ($this->open_elements as $el) {
			if (get_class($el) == 'Element_OphTrLaser_Treatment') {
				$rprocs = array();
				$lprocs = array();
				if ($el->hasRight() && isset($data['treatment_right_procedures']) ) {
					$rprocs =  $data['treatment_right_procedures'];
				}
				$el->updateRightProcedures($rprocs);
				if ($el->hasLeft() && isset($data['treatment_left_procedures']) ) {
					$lprocs =  $data['treatment_left_procedures'];
				}
				$el->updateLeftProcedures($lprocs);
			}
		}
	}

	public function canPrint()
	{
		return false;
	}
}
