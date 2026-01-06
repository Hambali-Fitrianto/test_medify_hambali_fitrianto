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
                // Rata tengah & vertikal untuk Foto (Idx 1) dan View (Idx 8)
                // Idx 8 karena ada tambahan kolom Kategori
                { className: "text-center align-middle", targets: [1, 8] }, 
                
                // Rata vertikal tengah untuk semua
                { className: "align-middle", targets: '_all' },             
                
                // Rata kanan untuk kolom Harga (Sekarang di index 5 dan 6)
                { className: "text-end", targets: [5, 6] }                  
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
        
        // Ambil data filter dari input
        var filter_kode = $('#filter-kode').val();
        var filter_nama = $('#filter-nama').val();
        var filter_harga_min = $('#filter-harga-min').val();
        var filter_harga_max = $('#filter-harga-max').val();
        
        // Kosongkan tabel sebelum isi ulang
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
                    var imgHtml = '<span class="text-muted small">-</span>';
                    if (item.foto) {
                        imgHtml = `<img src="${uploadsUrl}/${item.foto}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border:1px solid #dee2e6;">`;
                    }

                    // --- 3. Logic Tampilan Kategori (BARU) ---
                    var kategoriHtml = '<span class="text-muted small">-</span>';
                    // Cek apakah ada data kategori yang terhubung
                    if (item.categories && item.categories.length > 0) {
                        kategoriHtml = '';
                        // Loop setiap kategori untuk dibuatkan badge
                        item.categories.forEach(function(cat) {
                            kategoriHtml += `<span class="badge bg-info text-dark me-1 mb-1">${cat.nama}</span>`;
                        });
                    }
                    // ------------------------------------------

                    // --- 4. Logic Tombol View ---
                    var urlView = "{{url('master-items/view/')}}/" + item.kode;
                    var btnHtml = `<a href="${urlView}" class="btn btn-primary btn-sm">View</a>`;

                    // --- 5. Susun Array Data (URUTAN WAJIB SAMA DENGAN HEADER TABEL HTML) ---
                    // Urutan: Kode | Foto | Nama | KATEGORI | Jenis | H.Beli | H.Jual | Supplier | View
                    var array_temp = [
                        item.kode,                                                  // Col 0: Kode
                        imgHtml,                                                    // Col 1: Foto
                        item.nama,                                                  // Col 2: Nama
                        kategoriHtml,                                               // Col 3: KATEGORI (NEW)
                        item.jenis,                                                 // Col 4: Jenis
                        'Rp ' + parseInt(item.harga_beli).toLocaleString('id-ID'),  // Col 5: H.Beli
                        'Rp ' + harga_jual.toLocaleString('id-ID'),                 // Col 6: H.Jual
                        item.supplier,                                              // Col 7: Supplier
                        btnHtml                                                     // Col 8: View
                    ];

                    // Tambahkan baris ke DataTable
                    dataTableObj.row.add(array_temp);
                });

                // Render ulang tabel setelah semua data masuk
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