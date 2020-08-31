<h5 class="text-center">Coupon</h5>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Website</th>
                <th>Username</th>
                <th>Name</th>
                <th>Have Coupon</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participants as $participant)
            <tr>
                <td>{{ $participant->participants_website }}</td>
                <td>{{ $participant->participants_username }}</td>
                <td>{{ $participant->participants_name }}</td>
                <td>{{ $participant->have_coupon }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>