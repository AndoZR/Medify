<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    var dataTableObj = $('#table-kategori').DataTable({
        searching: false,
        order: [[0, 'desc']],
    });

    // Load data pertama kali
    getData();

    // Button filter
    $('.btn-get-data').click(function() {
        getData();
    });

    function getData(){
        $('#loading-filter').show();
        dataTableObj.clear().draw();

        var filter_kode = $('#filter-kode').val();
        var filter_nama = $('#filter-nama').val();

        $.ajax({
            url: '{{url("kategori-items/search")}}',
            dataType: 'json',
            tryCount: 0,
            retryLimit: 3,
            data: 'kode=' + filter_kode + '&nama=' + filter_nama,
            success: function(results) {
                var data = results.data;

                $.each(data, function(index, item) {
                    array_temp = [];

                    var kode = item.kode;

                    // Tombol view saja
                    var html = `<a href="{{url('kategori-items/view/')}}/` + kode + `" class="btn btn-primary btn-sm">View</a>`;

                    // masukkan data field ke array_temp
                    array_temp.push(item.kode);
                    array_temp.push(item.nama);
                    array_temp.push(html);

                    dataTableObj.row.add(array_temp).draw(true);
                });

                $('#loading-filter').hide();
            },
            error: function(xhr, textStatus, errorThrown) {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    $.ajax(this);
                    return;
                }
                alert('Terjadi kesalahan server, tidak dapat mengambil data');
                $('#loading-filter').hide();
                return;
            }
        });

    }
});
</script>
