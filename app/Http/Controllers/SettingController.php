<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{

	function listSettings()
	{
		$settings = Setting::all();
		return view('adm.settings.list',  compact('settings'));
	}

	public function update(Request $request)
	{
		foreach (Setting::all() as $key => $setting) {
			$setting->value = 0;
			$setting->save();
		}

		if ($request->config!=null) {
		
			foreach ($request->config as $key => $value) {
				$setting = Setting::find($value);
				$setting->value = 1;
				$setting->save();
			}
		}

		$success = 'Configuración actualizada';
		return back()->with('success', $success);
	}
}
