@if(count($participants) > 0)
<h5 class="text-center mb-30">Leaderboard</h5>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Website</th>
                <th>Username</th>
                <th>Rank</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participants as $participant)
            <tr>
                <td>{{ $participant->participants_website }}</td>
                <td>
                    @if($participants_username_status_id == 2 and $participant->participants_rank_board <= 3)
                    {{ Str::limit($participant->participants_username, 5, '***') }}
                    @else
                    {{ $participant->participants_username }}
                    @endif
                </td>
                <td>{{ $participant->participants_rank_board }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif