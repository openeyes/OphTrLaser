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

class AdminController extends ModuleAdminController
{
	public function actionViewLaserOperators()
	{
		Audit::add('admin','list',null,false,array('module'=>'OphTrLaser','model'=>'OphTrLaser_Laser_Operator'));

		$pagination = $this->initPagination(OphTrLaser_Laser_Operator::model());

		$this->render('laser_operators',array(
			'operators' => $this->getItems(array(
				'model' => 'OphTrLaser_Laser_Operator',
				'page' => $pagination->currentPage,
			)),
			'pagination' => $pagination,
		));
	}

	public function getItems($params)
	{
		$model = $params['model']::model();
		$page = $params['page'];

		$criteria = new CDbCriteria;
		if (isset($params['order'])) {
			$criteria->order = $params['order'];
		} else {
			$criteria->order = 'id asc';
		}
		$criteria->offset = $page * $this->items_per_page;
		$criteria->limit = $this->items_per_page;


		if (!empty($_REQUEST['search'])) {
			$criteria->addSearchCondition("username",$_REQUEST['search'],true,'OR');
			$criteria->addSearchCondition("first_name",$_REQUEST['search'],true,'OR');
			$criteria->addSearchCondition("last_name",$_REQUEST['search'],true,'OR');
		}

		return array(
			'items' => $params['model']::model()->findAll($criteria),
		);
	}

	public function actionAddLaserOperator()
	{
		$errors = array();

		$laser_operator = new OphTrLaser_Laser_Operator;

		if (!empty($_POST)) {
			if (OphTrLaser_Laser_Operator::model()->find('user_id = ?',array($_POST['OphTrLaser_Laser_Operator']['user_id']))) {
				$errors[] = array('This user is already in the list.');
			}

			if (empty($errors)) {
				$laser_operator->attributes = $_POST['OphTrLaser_Laser_Operator'];
				if (!$laser_operator->save()) {
					$errors = $laser_operator->getErrors();
				} else {
					Audit::add('admin','create',serialize($_POST),false,array('module'=>'OphTrLaser','model'=>'OphTrLaser_Laser_Operator'));
					$this->redirect(array('/OphTrLaser/admin/viewLaserOperators'));
				}
			}
		}

		$this->render('/admin/edit_laser_operator',array(
			'laser_operator' => $laser_operator,
			'errors' => $errors,
		));
	}

	public function actionEditLaserOperator($id)
	{
		if (!$laser_operator = OphTrLaser_Laser_Operator::model()->findByPk($id)) {
			throw new Exception("Laser operator not found: $id");
		}

		$errors = array();

		if (!empty($_POST)) {
			if ($laser_operator->id) {
				if (OphTrLaser_Laser_Operator::model()->find('id != ? and user_id = ?',array($laser_operator->id,$_POST['OphTrLaser_Laser_Operator']['user_id']))) {
					$errors[] = array('This user is already in the list.');
				}
			}

			if (empty($errors)) {
				$laser_operator->attributes = $_POST['OphTrLaser_Laser_Operator'];

				if (!$laser_operator->save()) {
					$errors = $laser_operator->getErrors();
				} else {
					Audit::add('admin','update',serialize(array_merge(array('id'=>$id),$_POST)),false,array('module'=>'OphTrLaser','model'=>'OphTrLaser_Laser_Operator'));

					$this->redirect(array('/OphTrLaser/admin/viewLaserOperators'));
				}
			}
		}

		Audit::add('admin','view',$id,false,array('module'=>'OphTrLaser','model'=>'OphTrLaser_Laser_Operator'));

		$this->render('/admin/edit_laser_operator',array(
			'laser_operator' => $laser_operator,
			'errors' => $errors,
		));
	}

	public function actionDeleteOperators()
	{
		$criteria = new CDbCriteria;
		$criteria->addInCondition('id',$_POST['operators']);

		OphTrLaser_Laser_Operator::model()->deleteAll($criteria);

		echo "1";
	}
}
