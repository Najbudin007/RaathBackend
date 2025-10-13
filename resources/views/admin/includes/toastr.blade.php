<script type="text/javascript">
    // toast for laravel validation error
    @if ($errors->any())
        @env('local')
            @foreach ($errors->all() as $er)
                {{ logger()->error($er) }}
            @endforeach
        @endenv
        let errMsg = "{{ config('custom.msg.err') }} Invalid Data";
        toastr.error(errMsg)
    @endif

    @if (Session::has('flash-msg'))
        toastr.success("{{ Session::get('flash-msg') }}");
    @endif

    @if (Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif

    @if (Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif

    @if (Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
    @endif

    @if (Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
    @endif

    @if (Session::has('msg'))
        var type = "{{ Session::get('type') }}";

        switch (type) {
            case 'info':
                toastr.info("{{ Session::get('msg') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('msg') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('msg') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('msg') }}");
                break;
        }
    @endif
</script>
