<?php

namespace Services\Settings;
use Models;

class GateEntry{
	function saveMaterial($data)
	{
		foreach($data as $formId => $modules){
			$form = Models\Forms::find($formId);
			$form->gateEntryConfig()->delete();

			foreach($modules as $moduleID => $_)
				$form->gateEntryConfig()->create(['module_id' => $moduleID]);
		}
	}
}