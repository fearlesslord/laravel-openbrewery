/********************************************
 * SELEZIONE DEGLI ELEMENTI DAL DOM
 ********************************************/
const loginForm = document.getElementById('loginForm');
const statusMessage = document.getElementById('statusMessage');
const breweriesSection = document.getElementById('breweriesSection');
const breweriesList = document.getElementById('breweriesList');
const prevPageBtn = document.getElementById('prevPage');
const nextPageBtn = document.getElementById('nextPage');
const perPageSelector = document.getElementById('perPageSelector');

// Sezione dettaglio
const breweryDetailSection = document.getElementById('breweryDetailSection');
const breweryDetailDiv = document.getElementById('breweryDetail');
const closeDetailBtn = document.getElementById('closeDetail');

// Selettore pagina numerica
const pageSelector = document.getElementById('pageSelector');

/********************************************
 * VARIABILI GLOBALI
 ********************************************/
let token = '';
let currentPage = 1;
// Numero di elementi per pagina preso dal <select id="perPageSelector">
let perPage = parseInt(perPageSelector.value, 10);

/********************************************
 * LOGIN
 ********************************************/
loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    statusMessage.textContent = '';
    statusMessage.style.color = 'red';

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    try {
        // Chiamata POST a /api/login
        // La risposta attesa: { "data": { "token": "..." }, "message": "..." }
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user: username, password: password })
        });

        const data = await response.json();

        if (!response.ok) {
            // Se ad esempio 401 / 422 / 500
            statusMessage.textContent = data.message || 'Login failed';
            return;
        }

        // Se la risposta è OK
        token = data.data?.token;
        statusMessage.textContent = data.message || 'Login effettuato con successo';
        statusMessage.style.color = 'green';

        // Mostriamo la sezione breweries e avviamo la prima fetch
        breweriesSection.style.display = 'block';
        fetchBreweries();

    } catch (error) {
        statusMessage.textContent = error.message;
    }
});

/********************************************
 * RECUPERO BIRRERIE (API BREWERIES)
 ********************************************/
async function fetchBreweries() {
    statusMessage.textContent = '';
    statusMessage.style.color = 'red';

    try {
        // Chiamata GET a /api/breweries?page=X&per_page=Y con Authorization Bearer
        const response = await fetch(`/api/breweries?page=${currentPage}&per_page=${perPage}`, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });

        const data = await response.json();

        if (!response.ok) {
            // Se ad esempio 401 / 422 / 500
            statusMessage.textContent = data.message || 'Errore nel recupero delle birrerie';
            return;
        }

        // data: { "message": "...", "data": [ ... ] }
        renderList(data.data);

    } catch (error) {
        statusMessage.textContent = error.message;
    }
}

/********************************************
 * RENDERING LISTA BIRRERIE
 ********************************************/
function renderList(breweries) {
    breweriesList.innerHTML = '';

    breweries.forEach(brew => {
        const li = document.createElement('li');
        // Mostriamo nome e city
        const cityInfo = brew.city ? ` - ${brew.city}` : '';
        li.textContent = brew.name + cityInfo;

        // Al click su <li>, mostriamo i dettagli
        li.addEventListener('click', () => {
            showBreweryDetail(brew);
        });

        breweriesList.appendChild(li);
    });
}

/********************************************
 * MOSTRA DETTAGLI DI UNA BIRRERIA
 ********************************************/
function showBreweryDetail(brew) {
    // Creiamo un HTML basico con i campi che ti interessano
    let detailHtml = `
        <h3>${brew.name ?? ''}</h3>
        <p><strong>Tipo:</strong> ${brew.brewery_type ?? ''}</p>
        <p><strong>Indirizzo:</strong> ${brew.street ?? ''}, ${brew.city ?? ''}, ${brew.state ?? ''}, ${brew.country ?? ''}</p>
        <p><strong>Telefono:</strong> ${brew.phone ?? ''}</p>
    `;

    // Aggiungiamo il link website, se c'è
    if (brew.website_url) {
        detailHtml += `
            <p><strong>Sito web:</strong>
               <a href="${brew.website_url}" target="_blank">${brew.website_url}</a>
            </p>`;
    }

    breweryDetailDiv.innerHTML = detailHtml;
    breweryDetailSection.style.display = 'block';
}

/********************************************
 * CHIUDI DETTAGLI
 ********************************************/
closeDetailBtn.addEventListener('click', () => {
    breweryDetailSection.style.display = 'none';
});

/********************************************
 * PAGINAZIONE: PREV E NEXT
 ********************************************/
prevPageBtn.addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        pageSelector.value = currentPage;  // Aggiorniamo l'input pagina
        fetchBreweries();
    }
});

nextPageBtn.addEventListener('click', () => {
    currentPage++;
    pageSelector.value = currentPage;  // Aggiorniamo l'input
    fetchBreweries();
});

/********************************************
 * SCELTA QUANTE BIRRERIE PER PAGINA
 ********************************************/
perPageSelector.addEventListener('change', () => {
    perPage = parseInt(perPageSelector.value, 10);
    currentPage = 1;
    pageSelector.value = currentPage; // Resettiamo la pagina a 1
    fetchBreweries();
});

/********************************************
 * SCELTA PAGINA DIRETTA
 ********************************************/
pageSelector.addEventListener('change', () => {
    const userPage = parseInt(pageSelector.value, 10);
    if (userPage >= 1) {
        currentPage = userPage;
        fetchBreweries();
    } else {
        // Se è invalido, ripristiniamo la pagina attuale
        pageSelector.value = currentPage;
    }
});
