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
						<input required name="content" type="file" class="form-control input file" accept=".png">
					</div>
				</div>
				@if(!empty($find->content))
				<div class="col-sm-12">
					<div class="form-group" style="border: .5px solid gray; border-radius: 6px;">
						<img class="img-fluid" src="{{ asset($find->content) }}">
					</div>
				</div>
				@endif
			</div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
	</form>
</div>