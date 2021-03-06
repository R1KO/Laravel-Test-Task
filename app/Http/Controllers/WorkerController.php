<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Worker;
use File;
use PhpOffice\PhpSpreadsheet\{Spreadsheet, Writer\Xlsx, IOFactory};

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
		$this->validate($request, array(
            'file'      => 'required'
        ));
		
		if($request->hasFile('file')) {
			$extension = $request->file->extension();

			if ($extension == "xlsx" || $extension == "xls") {
 
                $path = $request->file->getRealPath();
				
				$path = $request->file->getRealPath();
				
				$spreadsheet = IOFactory::load($path);
				
				$worksheet = $spreadsheet->getActiveSheet();

				$columns = [
							'last_name',
							'first_name',
							'patronymic',
							'birth_year',
							'post',
							'wages_per_year'
						];

				foreach ($worksheet->getRowIterator() as $row) {
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(FALSE);
					$i = 0;
					$tmp = [];
					foreach ($cellIterator as $cell) {
						$tmp[$columns[$i++]] = $cell->getValue();
					}
					$data[] = $tmp;
				}

				array_shift($data);

				Worker::insert($data);

				session()->flash('flash_message', 'Импорт прошел успешно!');
			}
		}
		
		return redirect()->route('view');
	}

	public function export()
	{
		$workers = Worker::all();

		$spreadsheet = new Spreadsheet();

		$spreadsheet->getProperties()->setCreator('R1KO')
			->setLastModifiedBy('R1KO')
			->setTitle('Office 2007 XLSX Test Document')
			->setSubject('Office 2007 XLSX Test Document')
			->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
			->setKeywords('office 2007 openxml php')
			->setCategory('Test result file');

		$sheet = $spreadsheet->getActiveSheet();

		$workers_array[] = ['Фамимлия',
							'Имя',
							'Отчество',
							'Год рождения',
							'Должность',
							'Зп в год.'];

		foreach($workers as $worker) {
			$tmp = $worker->toArray();
			unset($tmp['id']);
			$workers_array[] = array_values($tmp);
		}

		$spreadsheet->getActiveSheet()
			->fromArray(
				$workers_array,  // Массив
				NULL,
				'A1'         // Ячейка с которой начинается заполнение
			);

		$writer = new Xlsx($spreadsheet);
		$pathToFile = 'export.xlsx';
		$writer->save($pathToFile);

		return response()->download($pathToFile)->deleteFileAfterSend(true);
	}

	public function create(Request $request)
	{
		$this->validateParams($request);

		$worker = new Worker($request->all());
        $worker->save();
		
		session()->flash('flash_message', 'Работник <b>'.$request->last_name.' '.$request->first_name.' '.$request->patronymic.'</b> успешно добавлен!');

		return redirect()->route('view');
	}

	public function store(Worker $worker, Request $request)
	{
		$this->validateParams($request);
		$worker->fill($request->all());
        $worker->save();
		
		session()->flash('flash_message', 'Работник <b>'.$request->last_name.' '.$request->first_name.' '.$request->patronymic.'</b> успешно изменен!');

		return redirect()->route('view');
	}

	public function delete(Worker $worker)
	{
		session()->flash('flash_message', 'Работник <b>'.$worker->last_name.' '.$worker->first_name.' '.$worker->patronymic.'</b> успешно удален!');

		$worker->delete();

		return redirect()->route('view');
	}
	
	private function validateParams(Request $request)
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
	}
}
