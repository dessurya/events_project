<h5 class="text-center mb-40">Coupon</h5>
<form id="getCoupon" action="{{ route('site.get.coupon') }}" method="post">
    <div class="container mb-30">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                	<div>
	                    <label for="inputWebsite">Website</label>
                	</div>
                    <div>
	                    <select required name="website" class="form-control input" id="inputWebsite" style="width: 100%;">
		                    @foreach($MasterWebsite as $row)
		                    <option value="{{ $row->website->name }}">{{ $row->website->name }}</option>
		                    @endforeach
	                    </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                	<div>
                		<label for="inputUsername">Username</label>
                	</div>
                    <div>
	                    <input required type="text" name="username" class="form-control input" id="inputUsername" placeholder="Username">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <input type="hidden" name="event_id"  class="input" value="{{ $data->id }}">
                    <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="showCoupon" class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Website</th>
                <th>Username</th>
                <th>Name</th>
                <th>Coupon Code</th>
            </tr>
        </thead>
        <tbody>
            <tr><td colspan="5" class="text-center">Not Data Selected</td></tr>
        </tbody>
    </table>
</div>