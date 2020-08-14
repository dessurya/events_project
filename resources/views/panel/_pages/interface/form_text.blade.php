<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">Form Update Data {{ Str::title($find->name) }}</h3>
	</div>
	<form id="{{ $config['id'] }}" class="postData" method="post" action="{{ route($config['action']) }}">
		<input type="hidden" name="id" class="input" value="{{$find->id}}">
		<input type="hidden" name="type" class="input" value="{{$find->type}}">
		<div class="card-body">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>{{ Str::title($find->name) }}</label>
						<input required name="content" value="{{$find->content}}" type="text" class="form-control input">
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
	</form>
</div>