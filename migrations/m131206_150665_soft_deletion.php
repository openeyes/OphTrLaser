<?php

class m131206_150665_soft_deletion extends CDbMigration
{
	public function up()
	{
		$this->addColumn('et_ophtrlaser_anteriorseg','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophtrlaser_anteriorseg_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophtrlaser_comments','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophtrlaser_comments_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophtrlaser_fundus','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophtrlaser_fundus_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophtrlaser_posteriorpo','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophtrlaser_posteriorpo_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophtrlaser_site','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophtrlaser_site_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophtrlaser_treatment','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophtrlaser_treatment_version','deleted','tinyint(1) unsigned not null');
	}

	public function down()
	{
		$this->dropColumn('et_ophtrlaser_anteriorseg','deleted');
		$this->dropColumn('et_ophtrlaser_anteriorseg_version','deleted');
		$this->dropColumn('et_ophtrlaser_comments','deleted');
		$this->dropColumn('et_ophtrlaser_comments_version','deleted');
		$this->dropColumn('et_ophtrlaser_fundus','deleted');
		$this->dropColumn('et_ophtrlaser_fundus_version','deleted');
		$this->dropColumn('et_ophtrlaser_posteriorpo','deleted');
		$this->dropColumn('et_ophtrlaser_posteriorpo_version','deleted');
		$this->dropColumn('et_ophtrlaser_site','deleted');
		$this->dropColumn('et_ophtrlaser_site_version','deleted');
		$this->dropColumn('et_ophtrlaser_treatment','deleted');
		$this->dropColumn('et_ophtrlaser_treatment_version','deleted');
	}
}
