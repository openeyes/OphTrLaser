<?php

class m130412_093548_laser_options extends CDbMigration
{
	public function up()
	{
		$this->insert('et_ophtrlaser_site_laser',array('name'=>'Argon laser','site_id'=>21));
		$this->insert('et_ophtrlaser_site_laser',array('name'=>'YAG laser','site_id'=>21));
		$this->insert('et_ophtrlaser_site_laser',array('name'=>'Indirect laser','site_id'=>21));
		$this->insert('et_ophtrlaser_site_laser',array('name'=>'Argon laser','site_id'=>22));
		$this->insert('et_ophtrlaser_site_laser',array('name'=>'YAG laser','site_id'=>22));
		$this->insert('et_ophtrlaser_site_laser',array('name'=>'Indirect laser','site_id'=>22));
	}

	public function down()
	{
	}
}
