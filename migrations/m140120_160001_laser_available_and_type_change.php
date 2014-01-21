<?php

class m140120_160001_laser_available_and_type_change extends OEMigration
{
	public function up()
	{
		$this->addColumn('ophtrlaser_site_laser','deleted','boolean default false');
		$this->createOETable("ophtrlaser_type",
			array(
				'id' => 'tinyint unsigned not null auto_increment primary key',
				'name' => 'varchar(85) not null',
				'unique (name)'
			)
		);
		$this->alterColumn('ophtrlaser_site_laser','type','tinyint unsigned default 1 not null');
		$this->addForeignKey('ophtrlaser_type_fk', 'ophtrlaser_site_laser', 'type', 'ophtrlaser_type', 'id');

		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down()
	{
		$this->dropColumn('ophtrlaser_site_laser','deleted');
		$this->dropForeignKey('laseritem_type_fk' , 'ophtrlaser_site_laser');
		$this->dropTable("ophtrlaser_type");
		$this->alterColumn('ophtrlaser_site_laser','type','varchar(128) DEFAULT NULL');
	}
}