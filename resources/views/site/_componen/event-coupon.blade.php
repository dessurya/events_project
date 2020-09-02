<h5 class="text-center">Coupon</h5>
<form id="getCoupon" action="{{ route('site.get.coupon') }}" method="post">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="inputWebsite">Website</label>
                    <select required name="website" class="form-control input" id="inputWebsite" placeholder="Website">
                    @foreach($MasterWebsite as $row)
                    <option value="{{ $row->name }}">{{ $row->name }}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="inputUsername">Username</label>
                    <input required type="text" name="username" class="form-control input" id="inputUsername" placeholder="Username">
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <input type="hidden" name="event_id"  class="input" value="{{ $data->id }}">
                    <button class="btn btn-block btn-outline-success">Submit</button>
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