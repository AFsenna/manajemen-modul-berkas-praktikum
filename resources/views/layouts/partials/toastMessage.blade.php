@if (Session::has('pesan'))
    @if (Session::get('jenis') == 'error')
        <script>
            $(document).ready(function() {
                iziToast.error({
                    title: `Error :(`,
                    message: `{{ session('pesan') }}`,
                    position: 'topRight'
                });
            })
        </script>
    @elseif (Session::get('jenis') == "warning")
        <script>
            $(document).ready(function() {
                iziToast.warning({
                    title: 'Warning !',
                    message: `{{ session('pesan') }}`,
                    position: 'topRight'
                });
            })
        </script>
    @elseif (Session::get('jenis') == "show")
        <script>
            $(document).ready(function() {
                iziToast.show({
                    title: 'Show',
                    message: `{{ session('pesan') }}`,
                    position: 'bottomRight'
                });
            })
        </script>
    @elseif (Session::get('jenis') == "success")
        <script>
            $(document).ready(function() {
                iziToast.success({
                    title: 'Berhasil',
                    message: `{{ session('pesan') }}`,
                    position: 'bottomRight'
                });
            })
        </script>
    @endif
@endif
