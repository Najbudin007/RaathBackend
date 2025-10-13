@extends('admin.layouts.main')

@section('title')
    {{ Str::headline(request()->segment(2)) }}
@stop
@section('content')

    <form class="form-horizontal" role="form" id="testform" method="post" enctype="multipart/form-data"
        action="{{ route('admin.settings.update', $setting->id) }}">
        @method('PUT')
        {!! csrf_field() !!}
        <div class="card overflow-hidden" "="">
                                                <div class="card-body">

                                                    <h4 class="header-title mb-3">Site Settings</h4>

                                                    <form>
                                                        <div id="progressbarwizard">

                                                            <ul class="nav nav-pills nav-justified form-wizard-header mb-3" role="tablist">
                                                                <li class="nav-item" role="presentation">
                                                                    <a href="#account-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-1 active" aria-selected="true" role="tab">
                                                                        <span class="d-none d-sm-inline">General Setting</span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <a href="#profile-tab-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-1" aria-selected="false" tabindex="-1" role="tab">
                                                                        <span class="d-none d-sm-inline">Mail Setting</span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <a href="#finish-2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-1" aria-selected="false" tabindex="-1" role="tab">
                                                                        <span class="d-none d-sm-inline">Socail Setting</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        
                                                            <div class="tab-content b-0 mb-0">

                                                                <div id="bar" class="progress mb-3" style="height: 7px;">
                                                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 33.3333%;"></div>
                                                                </div>
                                                        
                                                                <div class="tab-pane active show" id="account-2" role="tabpanel">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            @include('admin.pages.settings.general')
                                                                        </div>
                                                                    </div>

                                                                    <ul class="list-inline wizard mb-0">
                                                                        <li class="next list-inline-item float-end">
                                                                            <a href="javascript:void(0);" class="btn btn-info">Add More Info <i class="ri-arrow-right-line ms-1"></i></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <div class="tab-pane" id="profile-tab-2" role="tabpanel">
                                                                    <div class="row">
                                                                        @include('admin.pages.settings.email')
                                                                    </div>
                                                                    <ul class="pager wizard mb-0 list-inline">
                                                                        <li class="previous list-inline-item disabled">
                                                                            <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back to Account</button>
                                                                        </li>
                                                                        <li class="next list-inline-item float-end">
                                                                            <button type="button" class="btn btn-info">Add More Info <i class="ri-arrow-right-line ms-1"></i></button>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <div class="tab-pane" id="finish-2" role="tabpanel">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                           @include('admin.pages.settings.social')
                                                                        </div>
                                                                    </div>
                                                                    <ul class="pager wizard mb-0 list-inline mt-1">
                                                                        <li class="previous list-inline-item disabled">
                                                                            <button type="button" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i> Back to Profile</button>
                                                                        </li>
                                                                        <li class="next list-inline-item float-end">
                                                                            <button type="submit" class="btn btn-info">Submit</button>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                            </div> <!-- tab-content -->
                                                        </div> <!-- end #progressbarwizard-->
                                                    </form>

                                                </div> <!-- end card-body -->
                                            </div>
                                            </form>
@endsection
@section('scripts')
    <script src="{{ asset('assets/vendor/jquery/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/demo.form-wizard.js') }}"></script>

    <script src="{{ asset('assets/vendor/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('assets/js/filepreview.js') }}"></script>
    <script>
        new showFilePreview([{
                inputSelector: "form .file-preview",
                imgContainer: "#post-img"
            },
            {
                inputSelector: "form .fav-preview",
                imgContainer: "#fav-img"
            }
        ]);
    </script>
    
    <script type="text/javascript">
        function removeSocialForm(id) {
            var element = document.getElementById("social_form_" + id);
            if (element) {
                element.remove();
            }

        }
        var count = '{{ count($setting->socials) }}';

        function addSocialForm() {
            var htmlForm = '<tr id="social_form_' + count +
                '"><td><input type="text" name="social[title][]" class="form-control" placeholder="facebook" required></td><td><input type="text" name="social[icon][]" class="form-control" placeholder="fa fa-users" required></td><td><input type="url" name="social[url][]" class="form-control" placeholder="https://facebook.com" required></td><td><button type="button" onclick="removeSocialForm(' +
                count + ')" class="btn btn-sm btn-danger"><i class=" ri-delete-bin-line"></i></button></td></tr>';
            $('#socialContainer').append(htmlForm)
            count++;
        }
    </script>
@endsection
