document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('search');
    const searchBtn = document.getElementById('search_button');
    const filterBtn = document.getElementById('filter_button');

    function search() {
        const query = searchInput.value.trim();
        const type = document.getElementById("search_type").value;
        if (query.length >= 0) {
            if (type=="search_employer"){
                window.location.href = `/employers/search?q=${encodeURIComponent(query)}&type=${type}`;
            }
            else window.location.href = `/jobposts/search?q=${encodeURIComponent(query)}&type=${type}`;
        }
    }

    searchInput.addEventListener('keypress', function (e) { // ao pressionar enter tb pesquisa
        if (e.key === 'Enter') {
            search();
        }
    });
    searchBtn.addEventListener('click', search);

    if (filterBtn) {
        filterBtn.addEventListener('click', function () {
            const query = new URLSearchParams(window.location.search).get('q') || '';
            const type = 'search_jobpost';
            const categoryId = document.querySelector('select[name="Categories"]').value;

            window.location.href =`/jobposts/search?q=${encodeURIComponent(query)}&type=${type}&category_id=${categoryId}`;
        });
    }

});
