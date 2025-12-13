document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('search');
    const searchBtn = document.getElementById('search_button');
    const filterBtn = document.getElementById('filter_button');
    const sugestions = document.getElementById('sugestions');
    const filtrarCategoria =  document.getElementById('Categories'); 
    const ordem = document.getElementById('ordem');

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
            sugestions.style.display = 'none';
        }
    });

    searchBtn.addEventListener('click', search);

    if (filtrarCategoria) {
        filtrarCategoria.addEventListener('change', updateFiltro);
    }

    if (ordem) {
        ordem.addEventListener('change', updateFiltro);
    }

    function updateFiltro(){
        const query = new URLSearchParams(window.location.search).get('q') || '';
            const type = 'search_jobpost';
            const categoryId = document.querySelector('select[name="Categories"]').value;
            const sort = document.querySelector('select[name="Categories"]').value;
            const sort = document.querySelector('select[name="ordem"]').value;
            window.location.href = `/jobposts/search?q=${encodeURIComponent(query)}&type=${type}&category_id=${categoryId}&sort=${sort}`;    
        }

    let timeout=null;

    searchInput.addEventListener('input', function() {
        pesquisa = this.value.trim();       // tirar espaços do nosso input
        const type = document.getElementById("search_type").value;
        
        clearTimeout(timeout);

        if(pesquisa.length < 2){    // n apresenta as sugestões
            sugestions.style.display = 'none';
            sugestions.innerHTML = '';
            return;

        }
        timeout = setTimeout(() => {
            fetchSuggestions(pesquisa, type);
        }, 300);
    });

    function fetchSuggestions(pesquisa,type){
        const url = `/api/search/suggestions?q=${encodeURIComponent(pesquisa)}&type=${type}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                mostrarSugestions(data);
            })
            .catch(error => console.error('Erro:', error));
    }



    function mostrarSugestions(data){
        if(data.length == 0 || !data){
            sugestions.style.display='none';
            return;
        }

        let lista = '<ul>';
        
        data.forEach(element => {     // para cada elemento da nossa data, ele vai pegar e colocar nas nossas sugestões com o respectivo link
            lista+=`<li> 
                        <a href= "${element.url}">${element.name}</a>
                    </li>`;
        });

        lista += '</ul>';


        sugestions.innerHTML = lista;
        sugestions.style.display='block';

    }

    document.addEventListener('click', function(event){     // desaparecem as sugestões ao clicar fora da barra
        if(!searchInput.contains(event.target) && !sugestions.contains(event.target)){
            sugestions.style.display='none';
        }
    });

});
