<?php 
class m130110_154840_event_type_OphTrLaser extends CDbMigration
{
	// procedures not expected to be available when implemented
	private static $laser_proc_defs = array(
		array('Cycloablation', 'Cycloablation', 20, 397537003, 'Laser cycloablation'),
		array('Fill in panretinal photocoagulation', 'Fill in PRP', 20, 312713003, 'Panretinal photocoagulation'),
		array('Focal laser photocoagulation', 'Focal laser', '15', '397538008', 'Focal laser photocoagulation of retina'),
		array('Laser demarcation', 'Demarcation', 20, 85231002, 'Repair of retinal detachment by laser photocoagulation'),
		array('Laser gonioplasty', 'Laser gonioplasty', 10, 404638008, 'Laser gonioplasty'),
		array('Laser hyaloidotomy', 'Hyaloidotomy', 10, 82627009, 'Discission of vitreous strands by anterior approach'),
		array('Laser iridoplasty', 'Laser iridoplasty', 20, 424830006, 'Laser iridoplasty'),
		array('Laser to chorioretinal lesion', 'Laser to CR lesion', 30, 446107007, 'Focal photocoagulation of chorioretinal lesion using laser'),
		array('Laser vitreolysis', 'Vitreolysis', '15', '439522009', 'Lysis of adhesions of vitreous'),
		array('Macular grid', 'Grid', 10, 397539000, 'Grid retinal photocoagulation'),
		array('Selective laser trabeculoplasty', 'Selective laser trab', 20, 392028003, 'Selective laser trabeculoplasty'),
		array('Suture lysis', 'Lysis', 10, 35631009, 'Laser surgery')
	);
	
	// procedure snomeds relevant to laser module
	private static $laser_snomeds = array(
			172532006,397537003,312713003,397538008,85231002,404638008,
			82627009,424830006,371345007,446107007,287588003,172485001,
			439522009,397539000,312713003,392028003,35631009
			);
	
	public function up() {

		// --- EVENT TYPE ENTRIES ---
		
		// create an event_type entry for this event type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('event_type')->where('class_name=:class_name', array(':class_name'=>'OphTrLaser'))->queryRow()) {
			$group = $this->dbConnection->createCommand()->select('id')->from('event_group')->where('name=:name',array(':name'=>'Treatment events'))->queryRow();
			$this->insert('event_type', array('class_name' => 'OphTrLaser', 'name' => 'Laser','event_group_id' => $group['id']));
		}
		// select the event_type id for this event type name
		$event_type = $this->dbConnection->createCommand()->select('id')->from('event_type')->where('class_name=:class_name', array(':class_name'=>'OphTrLaser'))->queryRow();

		// --- ELEMENT TYPE ENTRIES ---

		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'Site',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'Site','class_name' => 'Element_OphTrLaser_Site', 'event_type_id' => $event_type['id'], 'display_order' => 1, 'required' => true));
		}
		
		
		// create an element_type entry for this element type name if one doesn't already exist
		if ($treatment_element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'Treatment',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$treatment_id = $treatment_element_type->id;
		} else {
			$this->insert('element_type', array('name' => 'Treatment','class_name' => 'Element_OphTrLaser_Treatment', 'event_type_id' => $event_type['id'], 'display_order' => 2, 'required' => true));
			$treatment_id = $this->dbConnection->lastInsertID;
		}
		
		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'Anterior Segment',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'Anterior Segment','class_name' => 'Element_OphTrLaser_AnteriorSegment', 'event_type_id' => $event_type['id'], 'display_order' => 3, 'parent_element_type_id' => $treatment_id, 'default' => false, 'required' => false));
		}
		
		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'Posterior Pole',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'Posterior Pole','class_name' => 'Element_OphTrLaser_PosteriorPole', 'event_type_id' => $event_type['id'], 'display_order' => 4, 'parent_element_type_id' => $treatment_id, 'default' => false, 'required' => false));
		}
		
		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'Fundus',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'Fundus','class_name' => 'Element_OphTrLaser_Fundus', 'event_type_id' => $event_type['id'], 'display_order' => 5, 'parent_element_type_id' => $treatment_id, 'default' => false, 'required' => false));
		}
		
		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'Comments',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'Comments','class_name' => 'Element_OphTrLaser_Comments', 'event_type_id' => $event_type['id'], 'display_order' => 6, 'required' => false, 'default' => false));
		}
		
		// element lookup table et_ophtrlaser_site_laser
		$this->createTable('et_ophtrlaser_site_laser', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'type' => 'varchar(128) COLLATE utf8_bin',
				'wavelength' => 'int(10) unsigned',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'site_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophtrlaser_site_laser_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophtrlaser_site_laser_cui_fk` (`created_user_id`)',
				'KEY `et_ophtrlaser_site_laser_site_fk` (`site_id`)',
				'CONSTRAINT `et_ophtrlaser_site_laser_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtrlaser_site_laser_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtrlaser_site_laser_site_fk` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		// create the table for this element type: et_modulename_elementtypename
		$this->createTable('et_ophtrlaser_site', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'site_id' => 'int(10) unsigned NOT NULL', // Site
				'laser_id' => 'int(10) unsigned NOT NULL', // Laser
				'surgeon_id' => 'int(10) unsigned NOT NULL', // Surgeon
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophtrlaser_site_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophtrlaser_site_cui_fk` (`created_user_id`)',
				'KEY `et_ophtrlaser_site_ev_fk` (`event_id`)',
				'KEY `et_ophtrlaser_site_site_fk` (`site_id`)',
				'KEY `et_ophtrlaser_site_laser_fk` (`laser_id`)',
				'KEY `et_ophtrlaser_site_surgeon_id_fk` (`surgeon_id`)',
				'CONSTRAINT `et_ophtrlaser_site_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtrlaser_site_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtrlaser_site_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophtrlaser_site_site_fk` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`)',
				'CONSTRAINT `et_ophtrlaser_site_laser_fk` FOREIGN KEY (`laser_id`) REFERENCES `et_ophtrlaser_site_laser` (`id`)',
				'CONSTRAINT `et_ophtrlaser_site_surgeon_id_fk` FOREIGN KEY (`surgeon_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');



		// create the table for this Treatment element
		$this->createTable('et_ophtrlaser_treatment', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL DEFAULT 3', // eye
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophtrlaser_treatment_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophtrlaser_treatment_cui_fk` (`created_user_id`)',
				'KEY `et_ophtrlaser_treatment_ev_fk` (`event_id`)',
				'KEY `et_ophtrlaser_treatment_eye_id_fk` (`eye_id`)',
				'CONSTRAINT `et_ophtrlaser_treatment_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtrlaser_treatment_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtrlaser_treatment_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophtrlaser_treatment_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');



		// create the table for this element type: et_modulename_elementtypename
		$this->createTable('et_ophtrlaser_anteriorseg', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'left_eyedraw' => 'varchar(4096) COLLATE utf8_bin NOT NULL', // Left Eyedraw
				'right_eyedraw' => 'varchar(4096) COLLATE utf8_bin NOT NULL', // Right Eyedraw
				'eye_id' => 'int(10) unsigned NOT NULL DEFAULT 3', // Eye
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophtrlaser_anteriorseg_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophtrlaser_anteriorseg_cui_fk` (`created_user_id`)',
				'KEY `et_ophtrlaser_anteriorseg_ev_fk` (`event_id`)',
				'KEY `et_ophtrlaser_anteriorseg_eye_id_fk` (`eye_id`)',
				'CONSTRAINT `et_ophtrlaser_anteriorseg_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtrlaser_anteriorseg_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtrlaser_anteriorseg_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophtrlaser_anteriorseg_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');



		// create the table for this element type: et_modulename_elementtypename
		$this->createTable('et_ophtrlaser_posteriorpo', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL DEFAULT 3', // Eye
				'left_eyedraw' => 'varchar(4096) COLLATE utf8_bin NOT NULL', // Left eyedraw
				'right_eyedraw' => 'varchar(4096) COLLATE utf8_bin NOT NULL', // Right eyedraw
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophtrlaser_posteriorpo_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophtrlaser_posteriorpo_cui_fk` (`created_user_id`)',
				'KEY `et_ophtrlaser_posteriorpo_ev_fk` (`event_id`)',
				'KEY `et_ophtrlaser_posteriorpo_eye_id_fk` (`eye_id`)',
				'CONSTRAINT `et_ophtrlaser_posteriorpo_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtrlaser_posteriorpo_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtrlaser_posteriorpo_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophtrlaser_posteriorpo_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');



		// create the table for this element type: et_modulename_elementtypename
		$this->createTable('et_ophtrlaser_fundus', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL DEFAULT 3', // Eye
				'left_eyedraw' => 'varchar(4096) COLLATE utf8_bin NOT NULL', // Left Eyedraw
				'right_eyedraw' => 'varchar(4096) COLLATE utf8_bin NOT NULL', // Right Eyedraw
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophtrlaser_fundus_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophtrlaser_fundus_cui_fk` (`created_user_id`)',
				'KEY `et_ophtrlaser_fundus_ev_fk` (`event_id`)',
				'KEY `et_ophtrlaser_fundus_eye_id_fk` (`eye_id`)',
				'CONSTRAINT `et_ophtrlaser_fundus_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtrlaser_fundus_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtrlaser_fundus_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophtrlaser_fundus_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');



		// create the table for this element type: et_modulename_elementtypename
		$this->createTable('et_ophtrlaser_comments', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'comments' => 'text DEFAULT \'\'', // Comments
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophtrlaser_comments_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophtrlaser_comments_cui_fk` (`created_user_id`)',
				'KEY `et_ophtrlaser_comments_ev_fk` (`event_id`)',
				'CONSTRAINT `et_ophtrlaser_comments_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtrlaser_comments_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophtrlaser_comments_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->createTable('ophtrlaser_laserprocedure', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'procedure_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtrlaser_laserprocedure_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtrlaser_laserprocedure_cui_fk` (`created_user_id`)',
				'KEY `ophtrlaser_laserprocedure_proc_fk` (`procedure_id`)',
				'CONSTRAINT `ophtrlaser_laserprocedure_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtrlaser_laserprocedure_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtrlaser_laserprocedure_proc_fk` FOREIGN KEY (`procedure_id`) REFERENCES `proc` (`id`)',
				), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		// insert the laser procedures
		foreach (self::$laser_proc_defs as $proc_def) {
			// check if the procedure exists, create it if it doesn't.
			if (!$proc = Procedure::model()->find('snomed_code = ' . $proc_def[3]) ) {
				$proc = new Procedure;
				$proc->term = $proc_def[0];
				$proc->short_format = $proc_def[1];
				$proc->default_duration = $proc_def[2];
				$proc->snomed_code = $proc_def[3];
				$proc->snomed_term = $proc_def[4];
				$proc->save();
			}
			
		}
		foreach (self::$laser_snomeds as $snomed) {
			if ($proc = Procedure::model()->find('snomed_code = ' . $snomed)) {
				$this->insert('ophtrlaser_laserprocedure', array('procedure_id' => $proc->id));
			}
			else {
				echo "WARNING: procedure with SNOMED " . $snomed . " is missing!";
			}
		}
		
		$this->createTable('ophtrlaser_laserprocedure_assignment', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'procedure_id' => 'int(10) unsigned NOT NULL',
				'treatment_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL',
				'display_order' => 'tinyint(3) unsigned',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophtrlaser_laserprocedure_assignment_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophtrlaser_laserprocedure_assignment_cui_fk` (`created_user_id`)',
				'KEY `ophtrlaser_laserprocedure_assignment_proc_fk` (`procedure_id`)',
				'KEY `ophtrlaser_laserprocedure_assignment_tr_fk` (`treatment_id`)',
				'KEY `ophtrlaser_laserprocedure_assignment_eye_id_fk` (`eye_id`)',
				'CONSTRAINT `ophtrlaser_laserprocedure_assignment_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtrlaser_laserprocedure_assignment_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophtrlaser_laserprocedure_assignment_proc_fk` FOREIGN KEY (`procedure_id`) REFERENCES `proc` (`id`)',
				'CONSTRAINT `ophtrlaser_laserprocedure_assignment_tr_fk` FOREIGN KEY (`treatment_id`) REFERENCES `et_ophtrlaser_treatment` (`id`)',
				'CONSTRAINT `ophtrlaser_laserprocedure_assignment_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
				), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

	}

	public function down() {
		// --- drop any element related tables ---
		// --- drop element tables ---
		
		$this->dropTable('et_ophtrlaser_site');

		$this->dropTable('et_ophtrlaser_site_laser');
		$this->dropTable('ophtrlaser_laserprocedure_assignment');
		$this->dropTable('et_ophtrlaser_treatment');
		$this->dropTable('et_ophtrlaser_anteriorseg');
		$this->dropTable('et_ophtrlaser_posteriorpo');
		$this->dropTable('et_ophtrlaser_fundus');
		$this->dropTable('et_ophtrlaser_comments');
		$this->dropTable('ophtrlaser_laserprocedure');
		
		// delete the added laser procedures
		//TODO: see if this can be an interactive thing to confirm if they should be removed.
		/*
		foreach (self::$laser_proc_defs as $proc_def) {
			if ($proc = Procedure::model()->find('snomed_code = ' . $proc_def[3]) ) {
				$proc->delete();
			}
		}
		*/
		
		// --- delete event entries ---
		$event_type = $this->dbConnection->createCommand()->select('id')->from('event_type')->where('class_name=:class_name', array(':class_name'=>'OphTrLaser'))->queryRow();

		foreach ($this->dbConnection->createCommand()->select('id')->from('event')->where('event_type_id=:event_type_id', array(':event_type_id'=>$event_type['id']))->queryAll() as $row) {
			$this->delete('audit', 'event_id='.$row['id']);
			$this->delete('event', 'id='.$row['id']);
		}
		
		// --- delete entries from element_type ---
		$this->update('element_type', array('parent_element_type_id' => null), 'event_type_id='.$event_type['id']);
		$this->delete('element_type', 'event_type_id='.$event_type['id']);

		// --- delete entries from event_type ---
		$this->delete('event_type', 'id='.$event_type['id']);

		// echo "m000000_000001_event_type_OphTrLaser does not support migration down.\n";
		// return false;
		echo "If you are removing this module you may also need to remove references to it in your configuration files\n";
		return true;
	}
}
?>