<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Icon</th>
            <th>Url</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="socialContainer">
        @if ($setting->socials)
            @foreach ($setting->socials as $k => $social)
                <tr id="social_form_{{ $k }}">
                    <td>
                        <input type="text" name="social[title][]" class="form-control" value="{{ $social->title }}"
                            placeholder="facebook" required>
                    </td>
                    <td>
                        <input type="text" name="social[icon][]" class="form-control" value="{{ $social->icon }}"
                            placeholder="fa fa-users" required>
                    </td>
                    <td>
                        <input type="url" name="social[url][]" class="form-control" value="{{ $social->url }}"
                            placeholder="facebook.com" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="removeSocialForm({{ $k }})"><i class="ri-delete-bin-line"></i></button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr id="social_form_0">
                <td>
                    <input type="text" name="social[title][]" class="form-control" placeholder="facebook" required>
                </td>
                <td>
                    <input type="text" name="social[icon][]" class="form-control" placeholder="fa fa-users" required>
                </td>
                <td>
                    <input type="url" name="social[url][]" class="form-control" placeholder="https://facebook.com" required>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeSocialForm(0)"><i
                            class="ri-delete-bin-line"></i></button>
                </td>
            </tr>
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-right">
                {{-- <span class="text-muted">For Social Icon - <a href="https://fontawesome.com/v5/search?m=free"
                        target="_blank">click here</a></span> --}}
                <button type="button" class="btn btn-sm btn-info" onclick="addSocialForm()">Add More Social
                    Link</button>
            </td>
        </tr>
    </tfoot>
</table>
