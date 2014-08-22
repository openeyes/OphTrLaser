<?php

class m140822_124050_version_table_discrepency extends CDbMigration
{
	public function up()
	{
		$this->renameColumn('et_ophtrlaser_site_version','surgeon_id','operator_id');
	}

	public function down()
	{
		$this->renameColumn('et_ophtrlaser_site_version','operator_id','surgeon_id');
	}
}
