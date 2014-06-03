<?php

class m140128_095036_table_versioning extends OEMigration
{
	public function up()
	{
		$this->addColumn('ophtrlaser_site_laser', 'active', 'boolean not null default true');
		$this->update('ophtrlaser_site_laser', array('active' => new CDbExpression('not(deleted)')));
		$this->dropColumn('ophtrlaser_site_laser', 'deleted');
	}

	public function down()
	{
		$this->addColumn('ophtrlaser_site_laser', 'deleted', "tinyint(1) DEFAULT '0'");
		$this->update('ophtrlaser_site_laser', array('deleted' => new CDbExpression('not(active)')));
		$this->dropColumn('ophtrlaser_site_laser', 'active');
	}
}
