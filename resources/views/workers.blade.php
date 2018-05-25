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
@endsection