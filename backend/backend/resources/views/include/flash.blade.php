    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            background: '#d4edda',  
            showConfirmButton: false,
            timer: 3000
        })
    </script>
@endif

    @if(session('warning'))
    <script>
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: "{{ session('warning') }}",
          background: '#f8d7da',   
          color: '#721c24',        
          showConfirmButton: false,
          timer: 3000
        })
    </script>
@endif

    <script>



function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this category!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}


function confirmDeleteFeature(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this store feature!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-feature-form-' + id).submit();
        }
    })
}



function confirmDeleteFlashdeal(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this flash deal!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-flash-form-' + id).submit();
        }
    })
}




function confirmFaqDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this FAQ'S!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-faq-form-' + id).submit();
        }
    })
}


function confirmProductBrandDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this product brand!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-productbrand-form-' + id).submit();
        }
    })
}


function confirmDeleteBlog(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this blog!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-blog-form-' + id).submit();
        }
    })
}



function confirmDeleteShop(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this shop collection!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-shop-form-' + id).submit();
        }
    })
}



function confirmDeleteTestimonial(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this Testimonial!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-testimonial-form-' + id).submit();
        }
    })
}

function confirmDeleteTeam(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this About Team!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-team-form-' + id).submit();
        }
    })
}


function confirmDeleteAboutJourny(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this About Journey!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-aboutjourney-form-' + id).submit();
        }
    })
}


function confirmDeleteAboutValue(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this About Value!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-aboutvalue-form-' + id).submit();
        }
    })
}








function confirmDeleteSubcategory(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will delete the subcategory!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-subcategory-form-' + id).submit();
        }
    });
}


function confirmVendorDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to delete this vendor ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-subcategory-form-' + id).submit();
        }
    });
}


function confirmDeleteRole(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will delete the Role!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-role-form-' + id).submit();
        }
    });
}


function confirmDeleteProduct(id) {
    Swal.fire({
        title: 'Are you want to this delete ?',
        text: "This will delete the product!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-product-form-' + id).submit();
        }
    });
}



function confirmDeleteBanner(id) {
    Swal.fire({
        title: 'Are you want to this delete ?',
        text: "This will delete the slider!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-banner-form-' + id).submit();
        }
    });
}


function confirmDeleteVendorProduct(id) {
    Swal.fire({
        title: 'Are you want to this delete ?',
        text: "This will delete the product!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-vendorproduct-form-' + id).submit();
        }
    });
}

function confirmPermissionDelete(id) {
    Swal.fire({
        title: 'Are you want to this delete ?',
        text: "This will delete this permission!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-permission-form-' + id).submit();
        }
    });
}


      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- sortablejs -->
    <script
      src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
      integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ="
      crossorigin="anonymous"
    ></script>
    <!-- sortablejs -->
    <script>
      const connectedSortables = document.querySelectorAll('.connectedSortable');
      connectedSortables.forEach((connectedSortable) => {
        let sortable = new Sortable(connectedSortable, {
          group: 'shared',
          handle: '.card-header',
        });
      });

      const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
      cardHeaders.forEach((cardHeader) => {
        cardHeader.style.cursor = 'move';
      });
    </script>
    <!-- apexcharts -->
    <script
      src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
      integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
      crossorigin="anonymous"
    ></script>

    <!-- jsvectormap -->
    <script
      src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
      integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
      integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY="
      crossorigin="anonymous"
    ></script>


    <script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.confirm-action').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const message = this.getAttribute('data-message');
            const href = this.getAttribute('href');
            const action = this.getAttribute('data-action');

            Swal.fire({
                title: 'Please Confirm',
                text: message,
                icon: action === 'block' ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonText: action === 'block' ? 'Yes, Block it!' : 'Yes, Activate!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: action === 'block' ? '#d33' : '#198754',
                cancelButtonColor: '#6c757d',
                reverseButtons: true,
                background: '#fff',
                customClass: {
                    popup: 'shadow-lg rounded-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });
    });
});
</script>