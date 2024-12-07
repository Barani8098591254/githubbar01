
    function confirmUserStatusChange(action,msg) {
        let actionText =  msg;
        let confirmMessage = `Are you sure you want to ${actionText} this user account?`;

        Swal.fire({
            title: `Confirm ${actionText}`,
            text: confirmMessage,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {


            if (result.isConfirmed) {
                location.href = action;
            } else {
                return false;
            }
        });
    }




    function confirmtfa(action,msg) {
        let actionText =  msg;
        let confirmMessage = `Are you sure you want to ${actionText} this user account?`;

        Swal.fire({
            title: `Confirm ${actionText}`,
            text: confirmMessage,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {


            if (result.isConfirmed) {
                location.href = action;
            } else {
                return false;
            }
        });
    }




  // IP BLOCK SWEET ALERT



  $(document).ready(function () {
    $(".reject-link").click(function (e) {
        e.preventDefault();
        var userId = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to reject the IP Address?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, reject it!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ URL::to('') }}/reject-ipaddress/" + userId;
            }
        });
    });
});



    $(document).ready(function () {
        $(".reject-link").click(function (e) {
            e.preventDefault();
            var userId = $(this).data("id");

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to reject the IP Address?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, reject it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ URL::to('') }}/reject-ipaddress/" + userId;
                }
            });
        });
    });
