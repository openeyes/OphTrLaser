<?php

class m140516_130624_version_table_discrepencies extends CDbMigration
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
