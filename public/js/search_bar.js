document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('search');
    const searchBtn = document.getElementById('search_button');
    const filterBtn = document.getElementById('filter_button');
    const sugestions = document.getElementById('sugestions');
    const filtrarCategoria =  document.getElementById('Categories'); 
    const ordem = document.getElementById('ordem');
    const location = document.getElementById('location');
    const minSalary = document.getElementById('min-salary');
    const maxSalary = document.getElementById('max-salary');
    const workModel = document.getElementById('work_model');


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

    if(location) location.addEventListener('change', updateFiltro);

    if(minSalary) minSalary.addEventListener('input', adiarUpdate); // chama a função logo ao colocarmos input
    if(maxSalary) maxSalary.addEventListener('input', adiarUpdate);

    if(workModel) workModel.addEventListener('change',updateFiltro);

    let timeout = null;

    function adiarUpdate() {
        if (timeout) {
            clearTimeout(timeout);
        }

        // Inicia uma nova contagem de 800ms (quase 1 segundo)
        timeout = setTimeout(() => {
            updateFiltro();
        }, 1000); // conto 1 s antes de correr a função update filtro
    }
    
    function updateFiltro(){
        //pegar no url atual na parte q e guardar na query ou ent n meter nd
        const query = new URLSearchParams(window.location.search).get('q') || '';

        const type = new URLSearchParams(window.location.search).get('type') || document.getElementById("search_type").value;;
        
        const sort = document.querySelector('select[name="ordem"]').value;

        const local =  document.querySelector('select[name="location"]').value;
        
        if (type=="search_employer"){
            window.location.href = `/employers/search?q=${encodeURIComponent(query)}&type=${type}&ordem=${sort}&location=${local}`;
        }
        else {
            const model = document.querySelector('select[name="work_model"]').value;
            const valorMax = maxSalary.value;
            const valorMin = minSalary.value;
            const categoryId = document.querySelector('select[name="Categories"]').value;
            window.location.href = `/jobposts/search?q=${encodeURIComponent(query)}&type=${type}&category_id=${categoryId}&ordem=${sort}&location=${local}&min_salary=${valorMin}&max_salary=${valorMax}&work_model=${model}`;    
            }
        }


    searchInput.addEventListener('input', function() {
        pesquisa = this.value.trim();       // tirar espaços do nosso input
        const type = document.getElementById("search_type").value;
        

        if(pesquisa.length < 2){    // n apresenta as sugestões
            sugestions.style.display = 'none';
            sugestions.innerHTML = '';
            return;

        }
        fetchSuggestions(pesquisa, type);
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
