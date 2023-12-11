<div class="w-100 card mb-3 px-4 py-2">
    <table id="fileList" class="display">
        <thead>
            <tr>
                <th>Terakhir Diubah</th>
                <th>Nama Dokumen</th>
                <th>Katalog</th>
                <th>Tanggal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documents as $doc)
                <tr class="item-list">
                    <td>{{ $doc->updated_at }}</td>
                    <td class="item-title">{{ $doc->title }}</td>
                    <td class="katalog">{{ $doc->catalog }}</td>
                    <td class="doc-date">{{ $doc->doc_date }}</td>
                    <td>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                            data-bs-title="Lihat detail" class="text-primary mx-1"
                            href="{{ route('dashboard.show', $doc->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                <path
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                            </svg>
                        </a>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                            data-bs-title="Download" class="text-info"
                            href="{{ route('dashboard.download', $doc->drive_id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z" />
                            </svg>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search-input, #search-input-katalog, #search-input-year').on('input', function() {
            let searchTextTitle = $('#search-input').val().toLowerCase();
            let searchTextKatalog = $('#search-input-katalog').val().toLowerCase();
            let searchTextYear = $('#search-input-year').val();

            $('.item-list').each(function() {
                let title = $(this).find('.item-title').text().toLowerCase();
                let catalog = $(this).find('.katalog').text().toLowerCase();
                let year = $(this).find('.doc-date').text().split('-')[0];

                let showTitle = title.includes(searchTextTitle);
                let showKatalog = catalog.includes(searchTextKatalog);
                let showYear = year.includes(searchTextYear);

                if (showTitle && showKatalog && showYear) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
