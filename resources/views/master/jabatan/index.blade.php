<x-app-layout title="Master - Jabatan">
    <h1 class="h3 mb-4 text-gray-800">Jabatan</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Jabatan</h6>
            <div>
                <a href="{{ route('master.jabatan.create') }}" class="btn btn-primary"><i
                        class="fas fa-plus-circle fa-fw"></i>
                    Tambah Jabatan</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="userDataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('costum-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    @endpush
    @push('costum-js')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Datatable
        $(function () {
            var table = $('#userDataTable').DataTable({
                processing: false,
                serverSide: true,
                pageLength: 5,
                lengthMenu: [5, 10, 20, 50, 100, 200, 500],
                ajax: "{{ route('master.jabatan.datatable') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'slug', name: 'slug'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });

        // Delete Jabatan
        function deleteJabatan(jabatan) {
            Swal.fire({
                title: `Apa kamu yakin untuk menghapus Jabatan ${jabatan}?`,
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`destroyJabatan-${jabatan}`).submit()
                }
            })
        }
    </script>
    @endpush
</x-app-layout>
