<div class="col-12">
    <div class="row mb-3">
        <label class="col-md-3 col-form-label" for="protocol">Protocol</label>
        <div class="col-md-9">
            <select id="protocol" name="protocol" class="form-select">
                @foreach ($datas['proto'] as $proto)
                    @if ($proto['value'] == $setting->emails->protocol)
                        <option selected="selected" value="{{ $proto['value'] }}">
                            {{ $proto['title'] }}</option>
                    @else
                        <option value="{{ $proto['value'] }}">{{ $proto['title'] }}
                        </option>
                    @endif
                @endforeach
            </select>
            @error('protocol')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-md-3 col-form-label" for="parameter"> Parameter</label>
        <div class="col-md-9">
            <input type="text" id="parameter" name="parameter" class="form-control"
                value="{{ $setting->emails->parameter }}">
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-md-3 col-form-label" for="hostname">Host Name</label>
        <div class="col-md-9">
            <input type="text" id="hostname" name="hostname" class="form-control"
                value="{{ $setting->emails->host_name }}">
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-md-3 col-form-label" for="username">User Name</label>
        <div class="col-md-9">
            <input type="text" id="username" name="username" class="form-control"
                value="{{ $setting->emails->host_name }}">
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-md-3 col-form-label" for="password">Password</label>
        <div class="col-md-9">
            <input type="password" id="password" name="password" class="form-control"
                value="{{ $setting->emails->password }}">
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-md-3 col-form-label" for="smtp_port">SMTP Port</label>
        <div class="col-md-9">
            <input type="text" id="smtp_port" name="smtp_port" class="form-control"
                value="{{ $setting->emails->smtp_port }}">
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-md-3 col-form-label" for="encryption">Mail Encryption</label>
        <div class="col-md-9">
            <input type="text" id="encryption" name="encryption" class="form-control"
                value="{{ $setting->emails->encryption }}">
        </div>
    </div>
</div>
