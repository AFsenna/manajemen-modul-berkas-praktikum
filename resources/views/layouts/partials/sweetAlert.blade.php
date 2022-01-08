<script>
    function hapus(id) {
        swal({
                title: 'Apakah Anda Yakin ?',
                text: 'Jika terhapus, maka data tidak dapat di kembalikan !',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#form-delete-' + id).submit();
                } else {
                    swal("Cancelled", "Tidak jadi hapus data :)", "error");
                }
            });
    }

    function kirim() {
        swal({
            icon: "https://upload.wikimedia.org/wikipedia/commons/5/54/Ajux_loader.gif",
            buttons: false,
            closeOnClickOutside: false,
        });
    }

    function verif(id) {
        swal("Yakin sudah sesuai?", {
            buttons: ["Belum", "Ya"],
            confirmButtonText: 'Ya',
            showCancelButton: true,
            closeOnClickOutside: false,
        }).then((willVerif) => {
            if (willVerif) {
                $('#form-verif-' + id).submit();
                kirim();
            } else {
                swal("Cancelled", "Verifikasi Dibatalkan :)", "error");
            }
        })
    }

    function batalkan(id) {
        swal("Yakin ingin dibatalkan?", {
            buttons: ["Tidak", "Ya"],
            confirmButtonText: 'Ya',
            showCancelButton: true,
            closeOnClickOutside: false,
        }).then((willUndo) => {
            if (willUndo) {
                $('#form-undo-' + id).submit();
                kirim();
            } else {
                swal("Cancelled", "Tidak jadi Dibatalkan :)", "error");
            }
        })
    }
</script>
