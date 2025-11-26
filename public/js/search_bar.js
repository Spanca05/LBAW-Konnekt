document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('search');
    const searchBtn = document.getElementById('search_button');

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

});
