@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-md-8 offset-md-2 text-center">
			<form class="form-inline" action="{{ route('excel.import') }}" method="post" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="file" name="file" required>
				<div style="margin-top: 8px;">
					<button type="submit" class="btn btn-primary mb-2" style="margin-right: 16px;">Импорт</button>
					<a href="{{ route('excel.export') }}" class="btn btn-success mb-2">Экспорт</a>
					<button type="button" class="btn btn-success mb-2" style="margin-left: 16px;" data-toggle="modal" data-target="#AddWorkerModal">Добавить</button>
				</div>
			</form>
		</div>
	</div>
	@if($workers && count($workers))
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<table class="table">
					<thead>
						<tr>
							<th>Фамилия</th>
							<th>Имя</th>
							<th>Отчество</th>
							<th>Год рождения</th>
							<th>Должность</th>
							<th>Зп в год.</th>
						</tr>
					</thead>
					<tbody>
						@foreach($workers as $worker)
						<tr id="worker_{{ $worker->id }}" >
							<td>{{ $worker->last_name }}</td>
							<td>{{ $worker->first_name }}</td>
							<td>{{ $worker->patronymic }}</td>
							<td>{{ $worker->birth_year }}</td>
							<td>{{ $worker->post }}</td>
							<td>{{ $worker->wages_per_year }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<nav class="text-md-center">
					{{ $workers->links() }}
				</nav>
			</div>
		</div>
	@endif
@endsection