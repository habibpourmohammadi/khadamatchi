<script>
    $(document).ready(function() {

        let btnDelete = $(".btnDelete");

        btnDelete.click(function(e) {

            e.preventDefault();

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-success mx-3"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "ایا مطمعنید؟",
                text: "شما میخواهید آیتم مورد نظر را حذف کنید؟",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "بله، حذفش کن!",
                cancelButtonText: "لغوش کن",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('form').submit();
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire({
                        title: "لغو شد",
                        text: "عملیات حذف آیتم با موفقیت لغو شد!",
                        icon: "success",
                        confirmButtonText: 'باشه',
                    });
                }
            });
        });
    });
</script>
