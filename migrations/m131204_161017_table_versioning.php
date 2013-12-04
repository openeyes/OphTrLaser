<?php

class m131204_161017_table_versioning extends CDbMigration
{
	public function up()
	{
		$this->execute("
CREATE TABLE `et_ophtrlaser_anteriorseg_version` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `left_eyedraw` varchar(4096) COLLATE utf8_bin NOT NULL,
  `right_eyedraw` varchar(4096) COLLATE utf8_bin NOT NULL,
  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acv_et_ophtrlaser_anteriorseg_lmui_fk` (`last_modified_user_id`),
  KEY `acv_et_ophtrlaser_anteriorseg_cui_fk` (`created_user_id`),
  KEY `acv_et_ophtrlaser_anteriorseg_ev_fk` (`event_id`),
  KEY `acv_et_ophtrlaser_anteriorseg_eye_id_fk` (`eye_id`),
  CONSTRAINT `acv_et_ophtrlaser_anteriorseg_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_anteriorseg_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_anteriorseg_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_anteriorseg_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophtrlaser_anteriorseg_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophtrlaser_anteriorseg_version');

		$this->createIndex('et_ophtrlaser_anteriorseg_aid_fk','et_ophtrlaser_anteriorseg_version','id');
		$this->addForeignKey('et_ophtrlaser_anteriorseg_aid_fk','et_ophtrlaser_anteriorseg_version','id','et_ophtrlaser_anteriorseg','id');

		$this->addColumn('et_ophtrlaser_anteriorseg_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophtrlaser_anteriorseg_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophtrlaser_anteriorseg_version','version_id');
		$this->alterColumn('et_ophtrlaser_anteriorseg_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophtrlaser_comments_version` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `comments` text COLLATE utf8_bin,
  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acv_et_ophtrlaser_comments_lmui_fk` (`last_modified_user_id`),
  KEY `acv_et_ophtrlaser_comments_cui_fk` (`created_user_id`),
  KEY `acv_et_ophtrlaser_comments_ev_fk` (`event_id`),
  CONSTRAINT `acv_et_ophtrlaser_comments_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_comments_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_comments_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophtrlaser_comments_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophtrlaser_comments_version');

		$this->createIndex('et_ophtrlaser_comments_aid_fk','et_ophtrlaser_comments_version','id');
		$this->addForeignKey('et_ophtrlaser_comments_aid_fk','et_ophtrlaser_comments_version','id','et_ophtrlaser_comments','id');

		$this->addColumn('et_ophtrlaser_comments_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophtrlaser_comments_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophtrlaser_comments_version','version_id');
		$this->alterColumn('et_ophtrlaser_comments_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophtrlaser_fundus_version` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
  `left_eyedraw` varchar(4096) COLLATE utf8_bin NOT NULL,
  `right_eyedraw` varchar(4096) COLLATE utf8_bin NOT NULL,
  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acv_et_ophtrlaser_fundus_lmui_fk` (`last_modified_user_id`),
  KEY `acv_et_ophtrlaser_fundus_cui_fk` (`created_user_id`),
  KEY `acv_et_ophtrlaser_fundus_ev_fk` (`event_id`),
  KEY `acv_et_ophtrlaser_fundus_eye_id_fk` (`eye_id`),
  CONSTRAINT `acv_et_ophtrlaser_fundus_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_fundus_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_fundus_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_fundus_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophtrlaser_fundus_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophtrlaser_fundus_version');

		$this->createIndex('et_ophtrlaser_fundus_aid_fk','et_ophtrlaser_fundus_version','id');
		$this->addForeignKey('et_ophtrlaser_fundus_aid_fk','et_ophtrlaser_fundus_version','id','et_ophtrlaser_fundus','id');

		$this->addColumn('et_ophtrlaser_fundus_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophtrlaser_fundus_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophtrlaser_fundus_version','version_id');
		$this->alterColumn('et_ophtrlaser_fundus_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophtrlaser_posteriorpo_version` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
  `left_eyedraw` varchar(4096) COLLATE utf8_bin NOT NULL,
  `right_eyedraw` varchar(4096) COLLATE utf8_bin NOT NULL,
  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acv_et_ophtrlaser_posteriorpo_lmui_fk` (`last_modified_user_id`),
  KEY `acv_et_ophtrlaser_posteriorpo_cui_fk` (`created_user_id`),
  KEY `acv_et_ophtrlaser_posteriorpo_ev_fk` (`event_id`),
  KEY `acv_et_ophtrlaser_posteriorpo_eye_id_fk` (`eye_id`),
  CONSTRAINT `acv_et_ophtrlaser_posteriorpo_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_posteriorpo_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_posteriorpo_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_posteriorpo_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophtrlaser_posteriorpo_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophtrlaser_posteriorpo_version');

		$this->createIndex('et_ophtrlaser_posteriorpo_aid_fk','et_ophtrlaser_posteriorpo_version','id');
		$this->addForeignKey('et_ophtrlaser_posteriorpo_aid_fk','et_ophtrlaser_posteriorpo_version','id','et_ophtrlaser_posteriorpo','id');

		$this->addColumn('et_ophtrlaser_posteriorpo_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophtrlaser_posteriorpo_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophtrlaser_posteriorpo_version','version_id');
		$this->alterColumn('et_ophtrlaser_posteriorpo_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophtrlaser_site_version` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `site_id` int(10) unsigned NOT NULL,
  `laser_id` int(10) unsigned NOT NULL,
  `surgeon_id` int(10) unsigned NOT NULL,
  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acv_et_ophtrlaser_site_lmui_fk` (`last_modified_user_id`),
  KEY `acv_et_ophtrlaser_site_cui_fk` (`created_user_id`),
  KEY `acv_et_ophtrlaser_site_ev_fk` (`event_id`),
  KEY `acv_et_ophtrlaser_site_site_fk` (`site_id`),
  KEY `acv_et_ophtrlaser_site_laser_fk` (`laser_id`),
  KEY `acv_et_ophtrlaser_site_surgeon_id_fk` (`surgeon_id`),
  CONSTRAINT `acv_et_ophtrlaser_site_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_site_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_site_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_site_site_fk` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_site_laser_fk` FOREIGN KEY (`laser_id`) REFERENCES `ophtrlaser_site_laser` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_site_surgeon_id_fk` FOREIGN KEY (`surgeon_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophtrlaser_site_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophtrlaser_site_version');

		$this->createIndex('et_ophtrlaser_site_aid_fk','et_ophtrlaser_site_version','id');
		$this->addForeignKey('et_ophtrlaser_site_aid_fk','et_ophtrlaser_site_version','id','et_ophtrlaser_site','id');

		$this->addColumn('et_ophtrlaser_site_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophtrlaser_site_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophtrlaser_site_version','version_id');
		$this->alterColumn('et_ophtrlaser_site_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophtrlaser_treatment_version` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acv_et_ophtrlaser_treatment_lmui_fk` (`last_modified_user_id`),
  KEY `acv_et_ophtrlaser_treatment_cui_fk` (`created_user_id`),
  KEY `acv_et_ophtrlaser_treatment_ev_fk` (`event_id`),
  KEY `acv_et_ophtrlaser_treatment_eye_id_fk` (`eye_id`),
  CONSTRAINT `acv_et_ophtrlaser_treatment_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_treatment_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_treatment_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  CONSTRAINT `acv_et_ophtrlaser_treatment_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophtrlaser_treatment_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophtrlaser_treatment_version');

		$this->createIndex('et_ophtrlaser_treatment_aid_fk','et_ophtrlaser_treatment_version','id');
		$this->addForeignKey('et_ophtrlaser_treatment_aid_fk','et_ophtrlaser_treatment_version','id','et_ophtrlaser_treatment','id');

		$this->addColumn('et_ophtrlaser_treatment_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophtrlaser_treatment_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophtrlaser_treatment_version','version_id');
		$this->alterColumn('et_ophtrlaser_treatment_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophtrlaser_laserprocedure_version` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `procedure_id` int(10) unsigned NOT NULL,
  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acv_ophtrlaser_laserprocedure_lmui_fk` (`last_modified_user_id`),
  KEY `acv_ophtrlaser_laserprocedure_cui_fk` (`created_user_id`),
  KEY `acv_ophtrlaser_laserprocedure_proc_fk` (`procedure_id`),
  CONSTRAINT `acv_ophtrlaser_laserprocedure_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_ophtrlaser_laserprocedure_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_ophtrlaser_laserprocedure_proc_fk` FOREIGN KEY (`procedure_id`) REFERENCES `proc` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophtrlaser_laserprocedure_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophtrlaser_laserprocedure_version');

		$this->createIndex('ophtrlaser_laserprocedure_aid_fk','ophtrlaser_laserprocedure_version','id');
		$this->addForeignKey('ophtrlaser_laserprocedure_aid_fk','ophtrlaser_laserprocedure_version','id','ophtrlaser_laserprocedure','id');

		$this->addColumn('ophtrlaser_laserprocedure_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophtrlaser_laserprocedure_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophtrlaser_laserprocedure_version','version_id');
		$this->alterColumn('ophtrlaser_laserprocedure_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophtrlaser_laserprocedure_assignment_version` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `procedure_id` int(10) unsigned NOT NULL,
  `treatment_id` int(10) unsigned NOT NULL,
  `eye_id` int(10) unsigned NOT NULL,
  `display_order` tinyint(3) unsigned DEFAULT NULL,
  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acv_ophtrlaser_laserprocedure_assignment_lmui_fk` (`last_modified_user_id`),
  KEY `acv_ophtrlaser_laserprocedure_assignment_cui_fk` (`created_user_id`),
  KEY `acv_ophtrlaser_laserprocedure_assignment_proc_fk` (`procedure_id`),
  KEY `acv_ophtrlaser_laserprocedure_assignment_tr_fk` (`treatment_id`),
  KEY `acv_ophtrlaser_laserprocedure_assignment_eye_id_fk` (`eye_id`),
  CONSTRAINT `acv_ophtrlaser_laserprocedure_assignment_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_ophtrlaser_laserprocedure_assignment_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_ophtrlaser_laserprocedure_assignment_proc_fk` FOREIGN KEY (`procedure_id`) REFERENCES `proc` (`id`),
  CONSTRAINT `acv_ophtrlaser_laserprocedure_assignment_tr_fk` FOREIGN KEY (`treatment_id`) REFERENCES `et_ophtrlaser_treatment` (`id`),
  CONSTRAINT `acv_ophtrlaser_laserprocedure_assignment_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophtrlaser_laserprocedure_assignment_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophtrlaser_laserprocedure_assignment_version');

		$this->createIndex('ophtrlaser_laserprocedure_assignment_aid_fk','ophtrlaser_laserprocedure_assignment_version','id');
		$this->addForeignKey('ophtrlaser_laserprocedure_assignment_aid_fk','ophtrlaser_laserprocedure_assignment_version','id','ophtrlaser_laserprocedure_assignment','id');

		$this->addColumn('ophtrlaser_laserprocedure_assignment_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophtrlaser_laserprocedure_assignment_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophtrlaser_laserprocedure_assignment_version','version_id');
		$this->alterColumn('ophtrlaser_laserprocedure_assignment_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophtrlaser_site_laser_version` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `type` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `wavelength` int(10) unsigned DEFAULT NULL,
  `display_order` int(10) unsigned NOT NULL DEFAULT '1',
  `site_id` int(10) unsigned NOT NULL,
  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acv_ophtrlaser_site_laser_lmui_fk` (`last_modified_user_id`),
  KEY `acv_ophtrlaser_site_laser_cui_fk` (`created_user_id`),
  KEY `acv_ophtrlaser_site_laser_site_fk` (`site_id`),
  CONSTRAINT `acv_ophtrlaser_site_laser_site_fk` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`),
  CONSTRAINT `acv_ophtrlaser_site_laser_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `acv_ophtrlaser_site_laser_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophtrlaser_site_laser_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophtrlaser_site_laser_version');

		$this->createIndex('ophtrlaser_site_laser_aid_fk','ophtrlaser_site_laser_version','id');
		$this->addForeignKey('ophtrlaser_site_laser_aid_fk','ophtrlaser_site_laser_version','id','ophtrlaser_site_laser','id');

		$this->addColumn('ophtrlaser_site_laser_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophtrlaser_site_laser_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophtrlaser_site_laser_version','version_id');
		$this->alterColumn('ophtrlaser_site_laser_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');
	}

	public function down()
	{
		$this->dropTable('et_ophtrlaser_anteriorseg_version');
		$this->dropTable('et_ophtrlaser_comments_version');
		$this->dropTable('et_ophtrlaser_fundus_version');
		$this->dropTable('et_ophtrlaser_posteriorpo_version');
		$this->dropTable('et_ophtrlaser_site_version');
		$this->dropTable('et_ophtrlaser_treatment_version');
		$this->dropTable('ophtrlaser_laserprocedure_version');
		$this->dropTable('ophtrlaser_laserprocedure_assignment_version');
		$this->dropTable('ophtrlaser_site_laser_version');
	}
}
