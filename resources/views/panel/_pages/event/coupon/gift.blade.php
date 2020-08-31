<div class="card">
  <div class="card-header">
    <h3 class="card-title">Gift List <strong>-</strong></h3>
    <div class="card-tools">
      <ul class="pagination pagination-sm float-right">
        <li class="page-item">
          <a 
              onclick="preparePostData('.preparePostData.giftList')"
              class="page-link preparePostData giftList"
              data-id=""
              title="refresh"
              href="{{ route('panel.event.coupon.gift') }}"><i class="fas fa-sync-alt"></i></a>
        </li>
        <li class="page-item">
          <a 
              onclick="prepareGiftCoupon('.prepareGiftCoupon.giftList','.preparePostData.giftList')" 
              class="page-link prepareGiftCoupon giftList"
              data-id=""
              title="Add Points"
              href="{{ route('panel.event.coupon.gifted') }}"><i class="fas fa-save"></i></a>
        </li>
      </ul>
    </div>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Confirm At</th>
          <th>Website</th>
          <th>Username</th>
          <th>Name</th>
          <th>Have Coupon</th>
          <th></th>
        </tr>
      </thead>
      <tbody><tr><td colspan="6" class="text-center">-</td></tr></tbody>
    </table>
  </div>
</div>