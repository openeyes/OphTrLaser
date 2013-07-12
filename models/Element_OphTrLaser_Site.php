<?php /**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

/**
 * This is the model class for table "et_ophtrlaser_site".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property integer $site_id
 * @property integer $laser_id
 * @property integer $surgeon_id
 *
 * The followings are the available model relations:
 *
 * @property ElementType $element_type
 * @property EventType $eventType
 * @property Event $event
 * @property User $user
 * @property User $usermodified
 * @property Element_OphTrLaser_Site_Site $site
 * @property OphTrLaser_Site_Laser $laser
 * @property User $surgeon
 */

class Element_OphTrLaser_Site extends BaseEventTypeElement
{
	public $service;
	public $surgeonlist;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'et_ophtrlaser_site';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, site_id, laser_id, surgeon_id, ', 'safe'),
			array('site_id, laser_id, surgeon_id, ', 'required'),
			array('laser_id', 'laserBelongsToSite'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, event_id, site_id, laser_id, surgeon_id, ', 'safe', 'on' => 'search'),
		);
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'element_type' => array(self::HAS_ONE, 'ElementType', 'id','on' => "element_type.class_name='".get_class($this)."'"),
			'eventType' => array(self::BELONGS_TO, 'EventType', 'event_type_id'),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'site' => array(self::BELONGS_TO, 'Site', 'site_id'),
			'laser' => array(self::BELONGS_TO, 'OphTrLaser_Site_Laser', 'laser_id'),
			'surgeon' => array(self::BELONGS_TO, 'User', 'surgeon_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'event_id' => 'Event',
			'site_id' => 'Site',
			'laser_id' => 'Laser',
			'surgeon_id' => 'Surgeon',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('event_id', $this->event_id, true);

		$criteria->compare('site_id', $this->site_id);
		$criteria->compare('laser_id', $this->laser_id);
		$criteria->compare('surgeon_id', $this->surgeon_id);
				
		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
			));
	}

	/**
	 * Set default values for forms on create
	 */
	public function setDefaultOptions()
	{
		if (Yii::app()->getController()->getAction()->id == 'create') {
			$user = Yii::app()->session['user'];
			
			if ($user->is_doctor) {
				$this->surgeon_id = $user->id;
			}
		}
	}

	protected function beforeSave()
	{
		return parent::beforeSave();
	}

	protected function afterSave()
	{

		return parent::afterSave();
	}

	protected function beforeValidate()
	{
		return parent::beforeValidate();
	}
	
	public function getSurgeons() {
		if (!$this->surgeonlist) {
			$criteria = new CDbCriteria;
			$criteria->compare('is_doctor',1);
			$criteria->order = 'last_name,first_name asc';
	
			$this->surgeonlist = User::model()->findAll($criteria);
		}
	
		return $this->surgeonlist;
	}
	
	/*
	 * validation to ensure that the selected laser is on the selected site
	 */
	public function laserBelongsToSite($attribute) {
		if ($this->site_id && $this->laser && $this->site_id != $this->laser->site_id) {
			$this->addError($attribute, "Selected laser must be on the selected site");
		}
	}
}
?>
