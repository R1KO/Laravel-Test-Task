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
		
	<form action="{{ route('worker.add') }}" method="post" accept-charset="UTF-8">
        {{ csrf_field() }}
		<!-- Modal -->
		<div class="modal fade" id="AddWorkerModal" tabindex="-1" role="dialog" aria-labelledby="AddWorkerModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Добавить работника</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="last_name">Фамилия</label>
							<input type="text" class="form-control" id="last_name" name="last_name">
						</div>
						<div class="form-group">
							<label for="first_name">Имя</label>
							<input type="text" class="form-control" id="first_name" name="first_name">
						</div>
						<div class="form-group">
							<label for="patronymic">Отчество</label>
							<input type="text" class="form-control" id="patronymic" name="patronymic">
						</div>
						<div class="form-group">
							<label for="birth_year">Год рождения</label>
							<input type="text" class="form-control" id="birth_year" name="birth_year">
						</div>
						<div class="form-group">
							<label for="post">Должность</label>
							<input type="text" class="form-control" id="post" name="post">
						</div>
						<div class="form-group">
							<label for="wages_per_year">Зп в год.</label>
							<input type="text" class="form-control" id="wages_per_year" name="wages_per_year">
						</div>
					</div>
					<div class="modal-footer" style="display: block;">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
						<button type="submit" class="btn btn-success float-right">Добавить</button>
					</div>
				</div>
			</div>
		</div>
	</form>
@endsection