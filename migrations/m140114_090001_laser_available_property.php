<?php

class m140114_090001_laser_available_property extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophtrlaser_site_laser','available','boolean default true');
	}

	public function down()
	{
		$this->dropColumn('ophtrlaser_site_laser','available');
	}
}