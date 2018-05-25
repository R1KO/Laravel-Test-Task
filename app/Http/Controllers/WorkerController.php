<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Worker;

class WorkerController extends Controller
{
	const WORKERS_TO_PAGE = 20;

	public function view()
	{
		$workers = Worker::paginate(self::WORKERS_TO_PAGE);
		return view('workers', ['workers' => $workers]);
	}

	public function import(Request $request)
	{
		
		
		return redirect()->route('view');
	}

	public function export()
	{
		
		
		return redirect()->route('view');
	}

	public function create(Request $request)
	{
		
		
		return redirect()->route('view');
	}

	public function store(Worker $worker, Request $request)
	{
		
		
		return redirect()->route('view');
	}

	public function delete(Worker $worker)
	{
		
		
		return redirect()->route('view');
	}
}
