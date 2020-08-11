<div class="card">
  <div class="card-header">
    <h3 class="card-title">Leaderboard <strong>-</strong></h3>
    <div class="card-tools">
      <ul class="pagination pagination-sm float-right">
        <li class="page-item">
          <a 
              onclick="preparePostData('.preparePostData.leaderboard')" 
              class="page-link preparePostData leaderboard"
              data-id=""
              href="{{ route('event.tournament.leaderboard') }}"><i class="fas fa-sync-alt"></i></a>
          </li>
      </ul>
    </div>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Username</th>
          <th>Name</th>
          <th>Point</th>
          <th>Rank</th>
        </tr>
      </thead>
      <tbody><tr><td colspan="5" class="text-center">-</td></tr></tbody>
    </table>
  </div>
</div>