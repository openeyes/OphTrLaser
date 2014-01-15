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
class OphTrLaser_Site_LaserTest extends CDbTestCase {

	/**
	 * @var OphTrLaser_Site_Laser
	 */
	protected $model;
	public $fixtures = array(
		'ophtrlaser_site_laser' => 'OphTrLaser_Site_Laser',
	);

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		parent::setUp();
		$this->model = new OphTrLaser_Site_Laser;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() {

	}

	/**
	 * @covers OphTrLaser_Site_Laser::model
	 */
	public function testModel() {
		$this->assertEquals('OphTrLaser_Site_Laser', get_class($this->model), 'Class name should match model.');
	}

	/**
	 * @covers OphTrLaser_Site_Laser::tableName
	 */
	public function testTableName() {
		$this->assertEquals('ophtrlaser_site_laser', $this->model->tableName());
	}

	/**
	 * @covers OphTrLaser_Site_Laser::availableScope
	 */
	public function testAvailableScope() {

		$result = $this->model->availableScope();
		$this->assertInstanceOf('OphTrLaser_Site_Laser',$result);
		$this->assertEquals( $this->model->getTableAlias(false) .'.available = true' , $result->getDbCriteria()->condition );
	}

	/**
	 * @covers OphTrLaser_Site_Laser::availableScope
	 */
	public function testFindAllLasers(){
		$lasers = $this->ophtrlaser_site_laser('laser1')->with(array('site'))->findAll();
		$this->assertGreaterThan(1 , count($lasers));
	}

	/**
	 * @covers OphTrLaser_Site_Laser::availableScope
	 */
	public function testFindAllAvailableLasers(){
		$lasers = $this->ophtrlaser_site_laser('laser1')->availableScope()->with(array('site'))->findAll();
		$expected = 1; // make sure all lasers are available, available == true true
		$this->assertEquals(1 , count($lasers));
		foreach($lasers as $laser){
			$this->assertEquals($expected , $laser->available);
		}
	}

	/**
	 * @covers OphTrLaser_Site_Laser::availableScope
	 */
	public function testFindAllAvailableLasersPrepopulated(){
		$lasers = $this->ophtrlaser_site_laser('laser1')->availableScope(3)->with(array('site'))->findAll();
		$this->assertEquals(2 , count($lasers));

		$lasers = $this->ophtrlaser_site_laser('laser1')->availableScope("3")->with(array('site'))->findAll();
		$this->assertEquals(2 , count($lasers));
	}

}
