@extends('layouts.app')

@section('content')
	@if(count($errors) > 0)
	<div class="row">
		<div class="col-md-8 col-md-offset-2 text-center">
			<div class="alert alert-danger" role="alert">
				<ul>
					@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
	@endif
	@if (Session::has('flash_message'))
	<div class="row">
		<div class="col-md-8 offset-md-2 text-center">
			<div class="alert alert-success" role="alert">
				{!! session('flash_message') !!}
			</div>
		</div>
	</div>
	@endif
	<script type="text/javascript">
		$('div.alert').delay(2500).slideUp(200);
	</script>
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
                            <th>Действия</th>
						</tr>
					</thead>
					<tbody>
						@foreach($workers as $worker)
							<tr id="worker_{{ $worker->id }}" >
								<td name="last_name">{{ $worker->last_name }}</td>
								<td name="first_name">{{ $worker->first_name }}</td>
								<td name="patronymic">{{ $worker->patronymic }}</td>
								<td name="birth_year">{{ $worker->birth_year }}</td>
								<td name="post">{{ $worker->post }}</td>
								<td name="wages_per_year">{{ $worker->wages_per_year }}</td>

								<td style="text-align: center;">
									<div class="btn-group" style="display: inline-block;">
										<a class="open-EditWorker" data-id="{{ $worker->id }}"
											data-toggle="modal" href="#EditWorkerModal" title="Редактировать"><i class="fas fa-pencil-alt" style="color: black;"></i></a>
										<a class="open-DelWorker" data-id="{{ $worker->id }}"
											data-toggle="modal" href="#DelWorkerModal" title="Удалить"><i class="fas fa-trash-alt" style="color: black;"></i></a>
									</div>
								</td>
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
	
	<form action="{{ route('worker.delete', ['worker' => 0]) }}" id="form_delete_worker" method="post" accept-charset="UTF-8">
		{{ csrf_field() }}
		<input name="_method" type="hidden" value="DELETE">
		<!-- Modal -->
		<div class="modal fade" id="DelWorkerModal" tabindex="-1" role="dialog" aria-labelledby="DelWorkerModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Удалить работника</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						Вы действительно хотите удалить работника <b id="del_full_name"></b> ?
					</div>
					<div class="modal-footer" style="display: block;">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
						<button type="submit" class="btn btn-danger float-right">Удалить</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<script type="text/javascript">
		$(document).on("click", "a.open-DelWorker", function () {
			var nID = $(this).data('id');
		
			var action = '{{ route('worker.delete', ['worker' => 0]) }}';
		
			action = action.substr(0, action.lastIndexOf('/')+1);
		
			$('#form_delete_worker').attr('action', action+nID);
		
			var tds = $('#worker_'+nID).find("td");
		var last_name, first_name, patronymic;
		
		$(tds).each(function(i, elem) {
		if($(this).attr('name') == 'last_name') {
		last_name = $(this).html();
		}
		else if($(this).attr('name') == 'first_name') {
		first_name = $(this).html();
		}
		else if($(this).attr('name') == 'patronymic') {
		patronymic = $(this).html();
		}
		});
		
		var fullname = last_name + ' ' + first_name + ' ' + patronymic;
			$('#del_full_name').html(fullname);
		});
	</script>
	
	<form action="{{ route('worker.save', ['worker' => 0]) }}" id="form_save_worker" method="post" accept-charset="UTF-8">
		{{ csrf_field() }}
		<input name="_method" type="hidden" value="PUT">
		<!-- Modal -->
		<div class="modal fade" id="EditWorkerModal" tabindex="-1" role="dialog" aria-labelledby="EditWorkerModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Редактирование работника</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="last_name">Фамилия</label>
							<input type="text" class="form-control" id="edit_last_name" name="last_name">
						</div>
						<div class="form-group">
							<label for="first_name">Имя</label>
							<input type="text" class="form-control" id="edit_first_name" name="first_name">
						</div>
						<div class="form-group">
							<label for="patronymic">Отчество</label>
							<input type="text" class="form-control" id="edit_patronymic" name="patronymic">
						</div>
						<div class="form-group">
							<label for="birth_year">Год рождения</label>
							<input type="text" class="form-control" id="edit_birth_year" name="birth_year">
						</div>
						<div class="form-group">
							<label for="post">Должность</label>
							<input type="text" class="form-control" id="edit_post" name="post">
						</div>
						<div class="form-group">
							<label for="wages_per_year">Зп в год.</label>
							<input type="text" class="form-control" id="edit_wages_per_year" name="wages_per_year">
						</div>
					</div>
					<div class="modal-footer" style="display: block;">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
						<button type="submit" class="btn btn-success float-right">Сохранить</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<script type="text/javascript">
		$(document).on("click", "a.open-EditWorker", function () {
			var nID = $(this).data('id');
			var action = '{{ route('worker.save', ['worker' => 0]) }}';
			action = action.substr(0, action.lastIndexOf('/')+1);

			$('#form_save_worker').attr('action', action+nID);

			var tds = $('#worker_'+nID).find("td");
			var last_name, first_name, patronymic, birth_year, post, wages_per_year;
			$(tds).each(function(i, elem) {
				if($(this).attr('name') == 'last_name') {
					last_name = $(this).html();
				}
				else if($(this).attr('name') == 'first_name') {
					first_name = $(this).html();
				}
				else if($(this).attr('name') == 'patronymic') {
					patronymic = $(this).html();
				}
				else if($(this).attr('name') == 'birth_year') {
					birth_year = $(this).html();
				}
				else if($(this).attr('name') == 'post') {
					post = $(this).html();
				}
				else if($(this).attr('name') == 'wages_per_year') {
					wages_per_year = $(this).html();
				}
			});
		
			$('#edit_last_name').val(last_name);
			$('#edit_first_name').val(first_name);
			$('#edit_patronymic').val(patronymic);
			$('#edit_birth_year').val(birth_year);
			$('#edit_post').val(post);
			$('#edit_wages_per_year').val(wages_per_year);
		});
	</script>
@endsection