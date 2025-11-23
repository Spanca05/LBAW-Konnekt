document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('search');
    const searchBtn = document.getElementById('search_button');

    function search() {
        const query = searchInput.value.trim();
        if (query.length > 0) {
            window.location.href = `/jobposts/search?q=${encodeURIComponent(query)}`;
        }
    }

    searchInput.addEventListener('keypress', function (e) { // ao pressionar enter tb pesquisa
        if (e.key === 'Enter') {
            search();
        }
    });
    searchBtn.addEventListener('click', search);

});
