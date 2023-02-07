<x-app-layout title="Master - All Absen">
    <h1 class="h3 mb-4 text-gray-800">All Absen</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Absen</h6>
        </div>
        <div class="card-body">
            <form id="formSearch">
                <div class="row mb-2">
                    <div class="col-2">
                        <label for="tanggal_awal">Tanggal Awal</label>
                        <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal">
                    </div>
                    <div class="col-2">
                        <label for="tanggal_akhir">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir">
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" id="btnSearch">Search</button>
                    <a href="#" class="btn btn-warning" id="btnReset">Restart</a>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" id="myAbsenDataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Absen</th>
                            <th>Status</th>
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
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        // Cek Validasi
        const formSearch = document.getElementById('formSearch');
        const tanggalAwal = document.getElementById('tanggal_awal');
        const tanggalAkhir = document.getElementById('tanggal_akhir');
        const btnSearch = document.getElementById('btnSearch');

        // String Error
        const stringInvalidFeedback = (error) => {
                    return `<div class="invalid-feedback">
                                ${error}
                            </div>`
                }

        // Remove Element Error
        const removeElement = () => {
            const invalidFeedback = document.querySelectorAll('.invalid-feedback');

            invalidFeedback.forEach((invalid) => {
                invalid.remove();
            });
        }

        // Jika Button Search diklick
        btnSearch.addEventListener('click', (event) => {
            event.preventDefault();

            const data = new URLSearchParams(new FormData(formSearch));

            // Ambil data menggunakan ajax
            axios.post(`{{ route('master.absen.filterAbsen') }}`, data,
            {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            }
            )
            .then(response => {
                removeElement();

                tanggalAwal.classList.remove('is-invalid');
                tanggalAkhir.classList.remove('is-invalid');

                // Hapus datatable awal
                $(function () {
                    $("#myAbsenDataTable").dataTable().fnDestroy();
                });
                // Create Datatable lagi
                const valueTanggalAwal = response.data.tanggal_awal;
                const valueTanggalAkhir = response.data.tanggal_akhir;
                $(function () {
                    var table = $('#myAbsenDataTable').DataTable({
                        processing: false,
                        serverSide: true,
                        pageLength: 5,
                        lengthMenu: [5, 10, 20, 50, 100, 200, 500],
                        ajax: `{{ url('master/get-allAbsens') }}?tanggal_awal=${valueTanggalAwal}&tanggal_akhir=${valueTanggalAkhir}`,
                        columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                            {data: 'tanggal', name: 'tanggal'},
                            {data: 'status', name: 'status'},
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                        ],
                    });
                });
            })
            .catch(error => {
                if(error.response.data.errors.tanggal_awal && error.response.data.errors.tanggal_akhir) {
                    removeElement();

                    tanggalAwal.classList.add('is-invalid');
                    tanggalAkhir.classList.add('is-invalid');

                    tanggalAwal.insertAdjacentHTML('afterend', stringInvalidFeedback(error.response.data.errors.tanggal_awal))
                    tanggalAkhir.insertAdjacentHTML('afterend', stringInvalidFeedback(error.response.data.errors.tanggal_akhir))
                } else if(error.response.data.errors.tanggal_awal) {
                    removeElement();

                    tanggalAkhir.classList.remove('is-invalid');

                    tanggalAwal.classList.add('is-invalid');
                    tanggalAwal.insertAdjacentHTML('afterend', stringInvalidFeedback(error.response.data.errors.tanggal_awal))
                } else if(error.response.data.errors.tanggal_akhir) {
                    removeElement();

                    tanggalAwal.classList.remove('is-invalid');

                    tanggalAkhir.classList.add('is-invalid');
                    tanggalAkhir.insertAdjacentHTML('afterend', stringInvalidFeedback(error.response.data.errors.tanggal_akhir))
                }
            });

        });

        // Datatable
        $(function () {
            var table = $('#myAbsenDataTable').DataTable({
                processing: false,
                serverSide: true,
                pageLength: 5,
                lengthMenu: [5, 10, 20, 50, 100, 200, 500],
                ajax: "{{ route('master.allAbsen.datatable') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'tanggal', name: 'tanggal'},
                    {data: 'status', name: 'status'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            const btnReset = document.getElementById('btnReset');
            btnReset.addEventListener('click', (event) => {
                event.preventDefault();
                $(function () {
                    $("#myAbsenDataTable").dataTable().fnDestroy();
                });

                $(function () {
                    var table = $('#myAbsenDataTable').DataTable({
                        processing: false,
                        serverSide: true,
                        pageLength: 5,
                        lengthMenu: [5, 10, 20, 50, 100, 200, 500],
                        ajax: "{{ route('master.allAbsen.datatable') }}",
                        columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                            {data: 'tanggal', name: 'tanggal'},
                            {data: 'status', name: 'status'},
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                        ],
                    });
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
