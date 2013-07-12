<?php

class m130712_113449_site_laser_table_isnt_element extends CDbMigration
{
	public function up()
	{
		$this->renameTable('et_ophtrlaser_site_laser','ophtrlaser_site_laser');

		$this->dropForeignKey('et_ophtrlaser_site_laser_lmui_fk','ophtrlaser_site_laser');
		$this->dropIndex('et_ophtrlaser_site_laser_lmui_fk','ophtrlaser_site_laser');
		$this->createIndex('ophtrlaser_site_laser_lmui_fk','ophtrlaser_site_laser','last_modified_user_id');
		$this->addForeignKey('ophtrlaser_site_laser_lmui_fk','ophtrlaser_site_laser','last_modified_user_id','user','id');

		$this->dropForeignKey('et_ophtrlaser_site_laser_cui_fk','ophtrlaser_site_laser');
		$this->dropIndex('et_ophtrlaser_site_laser_cui_fk','ophtrlaser_site_laser');
		$this->createIndex('ophtrlaser_site_laser_cui_fk','ophtrlaser_site_laser','created_user_id');
		$this->addForeignKey('ophtrlaser_site_laser_cui_fk','ophtrlaser_site_laser','created_user_id','user','id');

		$this->dropForeignKey('et_ophtrlaser_site_laser_site_fk','ophtrlaser_site_laser');
		$this->dropIndex('et_ophtrlaser_site_laser_site_fk','ophtrlaser_site_laser');
		$this->createIndex('ophtrlaser_site_laser_site_fk','ophtrlaser_site_laser','site_id');
		$this->addForeignKey('ophtrlaser_site_laser_site_fk','ophtrlaser_site_laser','site_id','site','id');
	}

	public function down()
	{
		$this->dropForeignKey('ophtrlaser_site_laser_lmui_fk','ophtrlaser_site_laser');
		$this->dropIndex('ophtrlaser_site_laser_lmui_fk','ophtrlaser_site_laser');
		$this->createIndex('et_ophtrlaser_site_laser_lmui_fk','ophtrlaser_site_laser','last_modified_user_id');
		$this->addForeignKey('et_ophtrlaser_site_laser_lmui_fk','ophtrlaser_site_laser','last_modified_user_id','user','id');

		$this->dropForeignKey('ophtrlaser_site_laser_cui_fk','ophtrlaser_site_laser');
		$this->dropIndex('ophtrlaser_site_laser_cui_fk','ophtrlaser_site_laser');
		$this->createIndex('et_ophtrlaser_site_laser_cui_fk','ophtrlaser_site_laser','created_user_id');
		$this->addForeignKey('et_ophtrlaser_site_laser_cui_fk','ophtrlaser_site_laser','created_user_id','user','id');

		$this->dropForeignKey('ophtrlaser_site_laser_site_fk','ophtrlaser_site_laser');
		$this->dropIndex('ophtrlaser_site_laser_site_fk','ophtrlaser_site_laser');
		$this->createIndex('et_ophtrlaser_site_laser_site_fk','ophtrlaser_site_laser','site_id');
		$this->addForeignKey('et_ophtrlaser_site_laser_site_fk','ophtrlaser_site_laser','site_id','site','id');

		$this->renameTable('ophtrlaser_site_laser','et_ophtrlaser_site_laser');
	}
}
