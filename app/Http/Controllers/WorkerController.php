<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Worker;

class WorkerController extends Controller
{
	const WORKERS_TO_PAGE = 20;
	const REGEX = '/^[a-zA-Zа-яА-Я\'][a-zA-Zа-яА-Я-\' ]+[a-zA-Zа-яА-Я\']?$/u';
	const REGEX2 = '/^[a-zA-Zа-яА-Я]+$/ui';

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
		$this->validate($request, [
            'last_name' => [
                'required',
                'between:2,128',
                'regex:'.self::REGEX,
            ],
            'first_name' => [
                'required',
                'between:2,128',
                'regex:'.self::REGEX,
            ],
            'patronymic' => [
                'required',
                'between:2,128',
                'regex:'.self::REGEX2,
            ],
            'birth_year' => [
                'required',
                'min:1900',
                'numeric',
            ],
            'post' => [
                'required',
                'between:4,128',
            ],
            'wages_per_year' => [
                'required'
            ],
        ]);

		$worker = new Worker($request->all());
        $worker->save();

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
