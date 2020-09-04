<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">{{ $config['title'] }}</h3>
	</div>
	<form id="{{ $config['id'] }}" class="postData" method="post" action="{{ route($config['action']) }}">
		<input type="hidden" name="id" class="input">
		<div class="card-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Text</label>
						<input readonly name="text" type="text" class="form-control input">
					</div>
				</div>
                <div class="col-sm-6">
					<div class="form-group">
						<label>Url</label>
						<input readonly name="url" type="text" class="form-control input">
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label>Picture</label>
						<input name="picture" type="file" class="form-control input file" accept=".png,.jpg,jpeg,.gif">
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group" style="border: .5px solid gray; border-radius: 6px;">
						<img class="img-fluid picture" src="" style="display: none;">
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button disabled type="submit" class="btn btn-primary">Submit</button>
		</div>
	</form>
</div>