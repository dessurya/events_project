<h5 class="text-center">Leaderboard</h5>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Rank</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participants as $participant)
            <tr>
                <td>{{ $participant->participants_username }}</td>
                <td>{{ $participant->participants_name }}</td>
                <td>{{ $participant->participants_rank_board }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>