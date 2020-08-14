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
              title="refresh"
              href="{{ route('panel.event.tournament.leaderboard') }}"><i class="fas fa-sync-alt"></i></a>
        </li>
        <li class="page-item">
          <a 
              onclick="prepareGenerateRank('.prepareGenerateRank.leaderboard','.preparePostData.leaderboard')" 
              class="page-link prepareGenerateRank leaderboard"
              data-id=""
              title="Generate Ranks"
              href="{{ route('panel.event.tournament.leaderboardGenerateRank') }}"><i class="fas fa-medal"></i></a>
        </li>
        <li class="page-item">
          <a 
              onclick="prepareAddPoint('.prepareAddPoint.leaderboard','.preparePostData.leaderboard')" 
              class="page-link prepareAddPoint leaderboard"
              data-id=""
              title="Add Points"
              href="{{ route('panel.event.tournament.leaderboardAddPoint') }}"><i class="fas fa-save"></i></a>
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
          <th width="150px"></th>
        </tr>
      </thead>
      <tbody><tr><td colspan="6" class="text-center">-</td></tr></tbody>
    </table>
  </div>
</div>