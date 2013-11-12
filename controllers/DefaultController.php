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

class DefaultController extends NestedElementsEventTypeController
{
	// This map defines which elements can import eyedraw data from the most recent element type in the current episode
	public static $IMPORT_ELEMENTS = array(
			'Element_OphTrLaser_PosteriorPole' => 'Element_OphCiExamination_PosteriorPole',
			'Element_OphTrLaser_AnteriorSegment' => 'Element_OphCiExamination_AnteriorSegment'
			);

	protected function _jsCreate()
	{
		$l_by_s = array();
		foreach (OphTrLaser_Site_Laser::model()->findAll() as $slaser) {
			$l_by_s[$slaser->site_id][] = array('id' => $slaser->id, 'name' => $slaser->name);
		}
		Yii::app()->getClientScript()->registerScript('OphTrLaserJS', 'var lasersBySite = ' . CJavaScript::encode($l_by_s) . ';', CClientScript::POS_HEAD);
	}

	protected function beforeAction($action)
	{
		if (!Yii::app()->getRequest()->getIsAjaxRequest() && !(in_array($action->id,$this->printActions())) ) {
			Yii::app()->getClientScript()->registerScriptFile(Yii::app()->createUrl('js/spliteventtype.js'));
		}

		return parent::beforeAction($action);
	}

	public function actionCreate()
	{
		$this->_jsCreate();
		return parent::actionCreate();
	}

	public function actionUpdate($id)
	{
		$this->_jsCreate();
		return parent::actionUpdate($id);
	}
	/*
	 * look for and import eyedraw values from most recent related element if available
	 */
	protected function importElementEyeDraw($element)
	{
		// because we only do import from examination at this point, we can simply check that the module is installed
		// before proceeding
		if ($this->episode && Yii::app()->hasModule('OphCiExamination') ) {
			if (array_key_exists(get_class($element), self::$IMPORT_ELEMENTS)) {
				$event_type_id = EventType::model()->find('class_name = :name', array(':name' => 'OphCiExamination'))->id;
				$criteria = new CDbCriteria;
				$criteria->compare('event.episode_id',$this->episode->id);
				$criteria->compare('event.event_type_id',$event_type_id);
				$criteria->order = 'event.created_date desc';
				$criteria->limit = 1;
				// try and find the element type we're suppposed to import from
				$import = ElementType::model(self::$IMPORT_ELEMENTS[get_class($element)])->with('event')->find($criteria);

				if ($import) {
					$element->left_eyedraw = $import->left_eyedraw;
					$element->right_eyedraw = $import->right_eyedraw;
					$element->eye_id = $import->eye_id;
				}
			}
		}

	}

	/*
	 * override to call the eyedraw import for loaded elements
	 */
	protected function getElementForElementForm($element_type, $previous_id = 0, $additional)
	{
		$element = parent::getElementForElementForm($element_type, $previous_id, $additional);

		// do eyedraw import
		$this->importElementEyeDraw($element);

		return $element;
	}

	/*
	 * override to call the eyedraw import for loaded elements
	 */
	protected function getCleanDefaultElements($event_type_id)
	{
		$elements = parent::getCleanDefaultElements($event_type_id);
		foreach ($elements as $el) {
			$this->importElementEyeDraw($el);
		}

		return $elements;
	}

	/*
	 * override to call the eyedraw import for loaded elements
	 */
	protected function getCleanChildDefaultElements($parent, $event_type_id)
	{
		$elements = parent::getCleanChildDefaultElements($parent, $event_type_id);
		foreach ($elements as $el) {
			$this->importElementEyeDraw($el);
		}
		return $elements;
	}

	/*
	 * sets values for the many many fields without touching the database (used prior to validation)
	 *
	 */
	protected function setPOSTManyToMany($element)
	{
		if (get_class($element) == 'Element_OphTrLaser_Treatment') {
			$right_procedures = array();
			if (isset($_POST['treatment_right_procedures'])) {
				foreach ($_POST['treatment_right_procedures'] as $proc_id) {
					$right_procedures[] = Procedure::model()->findByPk($proc_id);
				}
			}
			$element->right_procedures = $right_procedures;

			$left_procedures = array();
			if (isset($_POST['treatment_left_procedures'])) {
				foreach ($_POST['treatment_left_procedures'] as $proc_id) {
					$left_procedures[] = Procedure::model()->findByPk($proc_id);
				}
			}
			$element->left_procedures = $left_procedures;
		}
	}

	/*
	 * similar to setPOSTManyToMany, but will actually call methods on the elements that will create database entries
	 * should be called on create and update.
	 *
	 */
	protected function storePOSTManyToMany($elements)
	{
		foreach ($elements as $el) {
			if (get_class($el) == 'Element_OphTrLaser_Treatment') {
				$rprocs = array();
				$lprocs = array();
				if ($el->hasRight() && isset($_POST['treatment_right_procedures']) ) {
					$rprocs =  $_POST['treatment_right_procedures'];
				}
				$el->updateRightProcedures($rprocs);
				if ($el->hasLeft() && isset($_POST['treatment_left_procedures']) ) {
					$lprocs =  $_POST['treatment_left_procedures'];
				}
				$el->updateLeftProcedures($lprocs);
			}
		}
	}

	/*
	 * ensures Many Many fields processed for elements
	 */
	public function createElements($elements, $data, $firm, $patientId, $userId, $eventTypeId)
	{
		if ($id = parent::createElements($elements, $data, $firm, $patientId, $userId, $eventTypeId)) {
			// create has been successful, store many to many values
			$this->storePOSTManyToMany($elements);
		}
		return $id;
	}

	/*
	 * ensures Many Many fields processed for elements
	 */
	public function updateElements($elements, $data, $event)
	{
		if (parent::updateElements($elements, $data, $event)) {
			// update has been successful, now need to deal with many to many changes
			$this->storePOSTManyToMany($elements);
		}
		return true;
	}

}
