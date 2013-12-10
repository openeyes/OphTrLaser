<?php

class m131210_144550_soft_deletion extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophtrlaser_laserprocedure','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophtrlaser_laserprocedure_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophtrlaser_laserprocedure_assignment','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophtrlaser_laserprocedure_assignment_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophtrlaser_site_laser','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophtrlaser_site_laser_version','deleted','tinyint(1) unsigned not null');
	}

	public function down()
	{
		$this->dropColumn('ophtrlaser_laserprocedure','deleted');
		$this->dropColumn('ophtrlaser_laserprocedure_version','deleted');
		$this->dropColumn('ophtrlaser_laserprocedure_assignment','deleted');
		$this->dropColumn('ophtrlaser_laserprocedure_assignment_version','deleted');
		$this->dropColumn('ophtrlaser_site_laser','deleted');
		$this->dropColumn('ophtrlaser_site_laser_version','deleted');
	}
}
