
/* Module-specific javascript can be placed here */

$(document).ready(function() {
	$('#et_save').unbind('click').click(function() {
		if (!$(this).hasClass('inactive')) {
			disableButtons();

			
			return true;
		}
		return false;
	});

	$('#et_cancel').unbind('click').click(function() {
		if (!$(this).hasClass('inactive')) {
			disableButtons();

			if (m = window.location.href.match(/\/update\/[0-9]+/)) {
				window.location.href = window.location.href.replace('/update/','/view/');
			} else {
				window.location.href = baseUrl+'/patient/episodes/'+et_patient_id;
			}
		}
		return false;
	});

	$('#et_deleteevent').unbind('click').click(function() {
		if (!$(this).hasClass('inactive')) {
			disableButtons();
			return true;
		}
		return false;
	});

	$('#et_canceldelete').unbind('click').click(function() {
		if (!$(this).hasClass('inactive')) {
			disableButtons();

			if (m = window.location.href.match(/\/delete\/[0-9]+/)) {
				window.location.href = window.location.href.replace('/delete/','/view/');
			} else {
				window.location.href = baseUrl+'/patient/episodes/'+et_patient_id;
			}
		} 
		return false;
	});

	$('select.populate_textarea').unbind('change').change(function() {
		if ($(this).val() != '') {
			var cLass = $(this).parent().parent().parent().attr('class').match(/Element.*/);
			var el = $('#'+cLass+'_'+$(this).attr('id'));
			var currentText = el.text();
			var newText = $(this).children('option:selected').text();

			if (currentText.length == 0) {
				el.text(ucfirst(newText));
			} else {
				el.text(currentText+', '+newText);
			}
		}
	});
	
	// manage treatment changes
	$('#active_elements').delegate('input[name="Element_OphTrLaser_Treatment\[MultiSelectList_treatment_right_procedures\]"], ' + 
			'input[name="Element_OphTrLaser_Treatment\[MultiSelectList_treatment_left_procedures\]"]', 
			'change', function(e) {
		// work out what side we are on
		var side = $(this).closest('.eventDetail').attr('data-side');
		var physical_side = 'left';
		if (side == 'left') {
			physical_side = 'right';
		}
		
		// if there is at least one procedure
		if (proceduresForSide(side)) {
			// show the eyedraw for each active child element
			$('.Element_OphTrLaser_Site > .active_child_elements > .element').each(function() {
				//showSide($(this), physical_side);
			});
		}
		else {
			// hide the eyedraws on the active child elements
		}
		
		
	});
	
	// side adding and removing
	$(this).delegate('#event_content .side .activeForm a.removeSide', 'click', function(e) {
		
		// Update side field to indicate other side
		var side = $(this).closest('.side');
		
		var remove_physical_side = 'left';
		var show_physical_side = 'right';
		
		var eye_side = 1;
		if(side.attr('data-side') == 'left') {
			eye_side = 2; // Right
			remove_physical_side = 'right';
			show_physical_side = 'left';
		} 

		$(this).closest('.element').find('input.sideField').each(function() {
			$(this).val(eye_side);
		});
		
		// If other side is already inactive, then activate it (can't have both sides inactive)
		$(this).closest('.element').find('.side.'+show_physical_side).removeClass('inactive');
		
		// Make this side inactive
		$(this).closest('.element').find('.side.'+remove_physical_side).addClass('inactive');
		
		e.preventDefault();
	});

	$(this).delegate('#event_content .side .inactiveForm a', 'click', function(e) {
		var element = $(this).closest('.element'); 
		element.find('input.sideField').each(function() {
			$(this).val(3); // Both eyes
		});
		
		element.find('.side').removeClass('inactive');
		
		e.preventDefault();
	});
});

// check if there are procedures set for a side (the eye(data) side, not physical(display) side)
function proceduresForSide(side) {
	if ($('input[name="treatment_'+side+'_procedures\[\]"]').length) {
		return true;
	}
	return false;
}

// probably redundant
function showSide(el, pside) {
	if (el.find('input.sideField').val()) 
	el.find('input.sideField').each(function() {
		$(this).val(3); // Both eyes
	});
	
	el.find('.'+pside+' .side').removeClass('inactive');
} 

function hideSide(el, pside) {
	// may have to hide the element completely if the other side is not shown.
}

function OphTrLaser_AnteriorSegment_init() {
	
}

function ucfirst(str) { str += ''; var f = str.charAt(0).toUpperCase(); return f + str.substr(1); }

function eDparameterListener(_drawing) {
	if (_drawing.selectedDoodle != null) {
		// handle event
	}
}
