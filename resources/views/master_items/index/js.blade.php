<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    var start_date = '';
    var end_date = '';
    var data_per_fetch = 500;
    var data_fetched = 0;

    // Helper untuk URL gambar (Pastikan folder public/uploads ada)
    var uploadsUrl = "{{ asset('uploads') }}"; 

    $(document).ready(function() {
        $('#table').DataTable({
            searching: false,
            order: [[0, 'desc']], // Urutkan berdasarkan Kode (descending)
            columnDefs: [
                { className: "text-center", targets: [1, 7] }, // Rata tengah untuk kolom Foto (1) dan View (7)
                { className: "text-end", targets: [4, 5] }     // Rata kanan untuk kolom Harga
            ]
        });
        getData();
    });

    $('.btn-get-data').click(function() {
        getData();
    })

    function getData(){
        
        $('#loading-filter').show();
        var dataTableObj = $('#table').DataTable();
        
        // Ambil data filter
        var filter_kode = $('#filter-kode').val();
        var filter_nama = $('#filter-nama').val();
        var filter_harga_min = $('#filter-harga-min').val();
        var filter_harga_max = $('#filter-harga-max').val();
        
        // Kosongkan tabel
        dataTableObj.clear().draw();

        $.ajax({
            url: '{{url("master-items/search")}}', 
            dataType: 'json',
            tryCount: 0,
            retryLimit: 3,
            data: {
                kode: filter_kode,
                nama: filter_nama,
                hargamin: filter_harga_min,
                hargamax: filter_harga_max
            },
            success: function(results) {
                var data = results.data;

                $.each(data, function(index, item) {
                    
                    // --- 1. Hitung Harga Jual ---
                    var harga_jual = parseInt(item.harga_beli) + (parseInt(item.harga_beli) * parseInt(item.laba) / 100);
                    harga_jual = Math.round(harga_jual);

                    // --- 2. Logic Tampilan Foto ---
                    var imgHtml = '<span class="text-muted small">No Image</span>';
                    if (item.foto) {
                        // Membuat elemen gambar dengan path folder uploads
                        imgHtml = `<img src="${uploadsUrl}/${item.foto}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border:1px solid #ccc;">`;
                    }

                    // --- 3. Logic Tombol View ---
                    var urlView = "{{url('master-items/view/')}}/" + item.kode;
                    var btnHtml = `<a href="${urlView}" class="btn btn-primary btn-sm">View</a>`;

                    // --- 4. Susun Array Data (URUTAN WAJIB SAMA DENGAN <thead>) ---
                    // Urutan: Kode | Foto | Nama | Jenis | H.Beli | H.Jual | Supplier | View
                    var array_temp = [
                        item.kode,                                  // Col 0: Kode
                        imgHtml,                                    // Col 1: Foto (HTML Image)
                        item.nama,                                  // Col 2: Nama
                        item.jenis,                                 // Col 3: Jenis
                        'Rp ' + parseInt(item.harga_beli).toLocaleString('id-ID'), // Col 4: H.Beli
                        'Rp ' + harga_jual.toLocaleString('id-ID'),        // Col 5: H.Jual
                        item.supplier,                              // Col 6: Supplier
                        btnHtml                                     // Col 7: Tombol View
                    ];

                    // Tambahkan ke DataTable
                    dataTableObj.row.add(array_temp);
                });

                // Render tabel
                dataTableObj.draw();
                
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
            }
        })
    }
</script>