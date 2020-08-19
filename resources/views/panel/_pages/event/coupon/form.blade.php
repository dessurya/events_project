<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">{{ $config['title'] }}</h3>
	</div>
	<form id="{{ $config['id'] }}" class="postData" method="post" action="{{ route($config['action']) }}">
		<input type="hidden" name="id" class="input">
		<div class="card-body">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Title</label>
						<input readonly name="title" type="text" class="form-control input">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Max Coupon</label>
						<input readonly name="max_coupon" type="number" min="1" class="form-control input">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Website</label>
						<select readonly name="website_id" type="number" class="form-control input select">
							@foreach($website as $list)
							<option value="{{ $list->id }}">{{ $list->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Registration Start On : </label>
						<input readonly name="start_registration" type="date" class="form-control input date">
					</div>
				</div>
                <div class="col-sm-6">
					<div class="form-group">
						<label>Active Start On : </label>
						<input readonly name="start_active" type="date" class="form-control input date">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Registration End On : </label>
						<input readonly name="end_registration" type="date" class="form-control input date">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Active End On : </label>
						<input readonly name="end_active" type="date" class="form-control input date">
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label>Description</label>
						<textarea required name="description" type="file" class="summernote form-control input"></textarea>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label>Terms and Conditions</label>
						<textarea required name="terms_and_conditions" type="file" class="summernote form-control input"></textarea>
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