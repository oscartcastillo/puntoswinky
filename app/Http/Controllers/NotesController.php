<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;

class NotesController extends Controller
{
	public function index(){
		$notes = \App\Note::all();
		return view('notes.index', compact('notes'));
	}

	public function destroy($id){
		Note::findOrFail($id)->delete();
		return redirect()->back();
	}
}
