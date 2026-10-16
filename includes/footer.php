

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>

/* SIDEBAR TOGGLE */

const menuToggle =
document.getElementById("menuToggle");

const sidebar =
document.getElementById("sidebar");

const overlay =
document.getElementById("sidebarOverlay");

if(menuToggle){

    menuToggle.addEventListener("click", () => {

        sidebar.classList.toggle("active");

        overlay.classList.toggle("active");

    });

}

if(overlay){

    overlay.addEventListener("click", () => {

        sidebar.classList.remove("active");

        overlay.classList.remove("active");

    });

}

</script>

<script>

/* DELETE CONFIRMATION */

document.addEventListener("DOMContentLoaded", function(){

    const deleteButtons =
    document.querySelectorAll(".delete-confirm");

    deleteButtons.forEach(button => {

        button.addEventListener("click", function(e){

            e.preventDefault();

            const link = this.href;

            Swal.fire({

                title:'Do you want to delete it?',

                text:'This action cannot be undone.',

                icon:'warning',

                showCancelButton:true,

                confirmButtonColor:'#ef4444',

                cancelButtonColor:'#64748b',

                confirmButtonText:'Yes, Delete',

                cancelButtonText:'Cancel',

                background:'#0f172a',

                color:'#ffffff'

            }).then((result) => {

                if(result.isConfirmed)
                {
                    window.location = link;
                }

            });

        });

    });

});

</script>
</body>
<script>

/* PAGE LOADER */

window.addEventListener("load", () => {

    const loader =
    document.getElementById("loader-wrapper");

    setTimeout(() => {

        loader.classList.add("loader-hide");

    }, 700);

});

</script>
<!-- SWEET ALERT -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>