<form id="registration" action="{{ route('azn.event.registration') }}" method="post" data-form="find">
    <input type="hidden" name="id" class="input">
    <input type="hidden" name="event_type" class="input" value="{{ $data->event_id }}">
    <input type="hidden" name="event_id"  class="input" value="{{ $data->id }}">
    <div class="form-group">
        <label for="inputWebsite">Website</label>
        <select required name="website" class="form-control input" id="inputWebsite" placeholder="Website">
        @foreach($MasterWebsite as $row)
        <option value="{{ $row->name }}">{{ $row->name }}</option>
        @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="inputUsername">Username</label>
        <input required type="text" name="username" class="form-control input" id="inputUsername" placeholder="Username">
    </div>
    <div id="otherInput" style="display:none;">
        <div class="form-group">
            <label for="inputBank">Bank</label>
            <select readonly name="bank" class="form-control input" id="inputBank" placeholder="Bank">
            @foreach($MasterBank as $row)
            <option value="{{ $row->name }}">{{ $row->name }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="inputNoRek">Nomer Rekening</label>
            <input readonly type="text" name="no_rek" class="form-control input" id="inputNoRek" placeholder="Nomer Rekening">
        </div>
        <div class="form-group">
            <label for="inputNamaRek">Rekening Atas Nama</label>
            <input readonly type="text" name="nama_rek" class="form-control input" id="inputNamaRek" placeholder="Rekening Atas Nama">
        </div>
        <div class="form-group">
            <label for="inputName">Name</label>
            <input readonly type="text" name="name" class="form-control input" id="inputName" placeholder="Name">
        </div>
        <div class="form-group">
            <label for="inputNoHp">No Hp</label>
            <input readonly type="text" name="no_hp" class="form-control input" id="inputNoHp" placeholder="No Hp">
        </div>
        <div class="form-group">
            <label for="inputAlamat">Alamat</label>
            <input readonly type="text" name="alamat" class="form-control input" id="inputAlamat" placeholder="Alamat">
        </div>
    </div>
    
    <div class="form-group">
        <button class="btn btn-block btn-outline-success">Submit</button>
    </div>
</form>