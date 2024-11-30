<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/toastr.js') }}"></script>
<script>
    @if(session()->has('success')) toastr.success('{{ session()->get('success') }}') @endif
    @if(session()->has('error')) toastr.error('{{ session()->get('error') }}') @endif
</script>
