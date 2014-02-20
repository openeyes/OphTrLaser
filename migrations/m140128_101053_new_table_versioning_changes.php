<?php

class m140128_101053_new_table_versioning_changes extends OEMigration
{
	public function up()
	{
		$this->addColumn('ophtrlaser_type','deleted','tinyint(1) unsigned not null');
		$this->createOETable("ophtrlaser_type_version",
			array(
				'id' => 'tinyint unsigned not null',
				'name' => 'varchar(85) not null',
				'version_date' => "datetime NOT NULL DEFAULT '1900-01-01 00:00:00'",
				'version_id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT primary key',
				'deleted' => 'tinyint(1) unsigned not null',
			)
		);
		$this->renameColumn('ophtrlaser_site_laser_version','type','type_id');
		$this->alterColumn('ophtrlaser_site_laser_version','type_id','tinyint unsigned default 0 not null');

		$this->addForeignKey('acv_ophtrlaser_type_fk', 'ophtrlaser_site_laser_version', 'type_id', 'ophtrlaser_type', 'id');

		$this->addForeignKey('ophtrlaser_type_aid_fk', 'ophtrlaser_type_version', 'id', 'ophtrlaser_type', 'id');
	}

	public function down()
	{
		$this->dropForeignKey('ophtrlaser_type_aid_fk','ophtrlaser_type_version');
		$this->dropForeignKey('acv_ophtrlaser_type_fk', 'ophtrlaser_site_laser_version');
		$this->dropTable("ophtrlaser_type_version");
		$this->alterColumn('ophtrlaser_site_laser_version','type_id','varchar(128) DEFAULT NULL');
		$this->renameColumn('ophtrlaser_site_laser_version','type_id','type');
		$this->dropColumn('ophtrlaser_type','deleted');
	}
}
