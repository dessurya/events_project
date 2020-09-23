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
              onclick="prepareAddPoint('.prepareAddPoint.leaderboard','.preparePostData.leaderboard')" 
              class="page-link prepareAddPoint leaderboard"
              data-id=""
              title="Add Points"
              href="{{ route('panel.event.tournament.leaderboardAddPoint') }}"><i class="fas fa-save"></i></a>
        </li>
        <li class="page-item">
          <a 
              onclick="prepareGenerateRank('.prepareGenerateRank.leaderboard','.preparePostData.leaderboard')" 
              class="page-link prepareGenerateRank leaderboard"
              data-id=""
              title="Generate Ranks"
              href="{{ route('panel.event.tournament.leaderboardGenerateRank') }}">Generate Ranks</a>
        </li>
      </ul>
    </div>
  </div>
  <div class="card-body p-0">
      
    <div class="container mt-3">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Import Participants</h3>
        </div>
        <div class="card-body p-0">
          <div class="container p-2">
            <div id="importWrapper" class="row">
              <div id="errorReport" class="col-md-12">
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <a class="btn btn-warning btn-block" href="{{ asset('asset/import_excel_template.xlsx') }}" download>Download Format Import</a>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <button onclick="render({'target':'#importWrapper #errorReport','content':null})" class="btn btn-default btn-block">Clear Error Report</button>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <button disabled onclick="clickTarget('#importExcelFile')" class="btn btn-success btn-block">Upload Import data</button>
                  <input id="importExcelFile" type="file" accept=".xls, .xlsx" style="display:none;" data-id="">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container mt-3">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Add Participants</h3>
        </div>
        <div class="card-body p-0">
          <div class="container p-2">
            <form id="leaderboardAddPerticipants" method="post" action="{{ route('panel.event.tournament.inputaddparticipants') }}">
              <input type="hidden" name="id" class="input">
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Website</label>
                    <select disabled name="website" class="form-control input"></select>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Username</label>
                    <input disabled name="username" type="text" class="form-control input">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Turnover Point</label>
                    <input disabled name="point" type="text" class="form-control input">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <button disabled type="submit" class="btn btn-primary btn-block">Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <table id="render" class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Website</th>
          <th>Username</th>
          <th>Name</th>
          <th>Point</th>
          <th>Rank</th>
          <th width="150px"></th>
        </tr>
      </thead>
      <tbody><tr><td colspan="7" class="text-center">-</td></tr></tbody>
    </table>
    
  </div>
</div>