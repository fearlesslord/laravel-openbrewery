# Web Application con Laravel

Questa è una web application sviluppata con Laravel, che offre un endpoint di login e un endpoint per la lista di birrerie (recuperate da [OpenBreweryDb](https://www.openbrewerydb.org/documentation/) tramite proxy). È presente anche una pagina dedicata (`breweries.blade.php`) che permette di testare l’applicazione tramite login, paginazione e visualizzazione dettagli di ogni birreria.
 Il progetto e' stato sviluppato con Docker e le versioni dei software utilizzati sono:
- PHP 8.3.16
- Laravel Framework 11.40.0
- Docker version 27.5.1
- Docker Compose version v2.25.0

# Istruzioni per installare il progetto con Docker

Queste istruzioni spiegano come clonare il repository, buildare l’immagine Docker e avviare l’applicazione Laravel usando Docker Compose.

---

## 1) Clonare il repository

Apri il tuo terminale e posizionati nella cartella in cui vuoi scaricare il progetto. Esegui:

```bash
git clone https://github.com/fearlesslord/laravel-openbrewery.git
cd laravel-openbrewery
```

---

## 2) Creare il file .env

Se non hai un file `.env`, copiane uno di esempio:

```bash
cp .env.example .env
```

Quindi modifica le variabili d’ambiente necessarie (ad es. `DB_CONNECTION`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, ecc.), tenendo presente che Docker gestirà i servizi esterni (MySQL, ecc.) se configurati.

---

## 3) Avviare Docker Compose

Assicurati di avere Docker e Docker Compose installati correttamente sul tuo sistema.

Poi, dalla radice del progetto (dove si trova il file `docker-compose.yml`), esegui i commandi:

```bash
docker-compose build
docker-compose up -d

docker-compose exec php composer install
docker-compose exec php php artisan key:generate
docker-compose exec php php artisan migrate
docker-compose exec php php artisan db:seed
```

---

##  Accedere all’applicazione

```arduino
http://localhost:8080
```

Se la rotta principale è `/`, vedrai la pagina `welcome.blade.php` (o un’eventuale homepage).

Se vuoi testare la pagina di test “breweries”, puoi visitare `http://localhost:8080/breweries-test` (a seconda delle tue rotte `web.php`).

---

- In `routes/api.php` si trovano le rotte API (`/api/login`, `/api/breweries`).
- In `resources/views/` ci sono la pagina di welcome (`welcome.blade.php`) e la pagina di test (`breweries.blade.php`).

---


## API documentation si trova nella cartella `docs/` 
- openapi.yaml - specifica OpenAPI 3.0, per visualizzare la documentazione si puo' usare Swagger UI https://editor.swagger.io/
- laravel-openbrewery.postman_collection.json - colezzione Postman per testare le API


## Rotte principali

### [POST] /api/login

**Descrizione**: Esegue il login dell’utente. Restituisce un token (via Sanctum o meccanismo simile).

**Body**:
```json
{
  "user": "root",
  "password": "password"
}
```

**Risposta (successo, status 200)**:
```json
{
  "message": "Login effettuato con successo",
  "data": {
    "token": "21|abcdefg..."
  }
}
```

**Errori**:
- **401** se credenziali non valide.
- **422** se mancano i campi richiesti (validazione fallita).

---

### [GET] /api/breweries

**Descrizione**: Ritorna la lista di birrerie, recuperandola da [OpenBreweryDb](https://www.openbrewerydb.org/documentation/).

**Autenticazione**: Richiede `Authorization: Bearer <token>` nell’header.

**Query Param**:
- `page` (integer, default=1)
- `per_page` (integer, default=10, max=200)

**Risposta (successo, status 200)**:
```json
{
  "message": "Birrerie recuperate con successo",
  "data": [
    {
      "id": "849d5961-83c5-4115-9ae4-c0e93c8d3a7f",
      "name": "5x5 Brewing Co.",
      "brewery_type": "planning"
      // ...
    }
    // ...
  ]
}
```

**Errori**:
- **401** se token assente o non valido.
- **422** se `per_page` o `page` non rispettano i criteri di validazione.
- **500** se si verificano problemi con l’API esterna o errori interni.

---

## Pagina di test (breweries.blade.php)

- **Percorso**: Ad esempio, `http://localhost:8080/breweries-test` 
- **Funzionalità**:
    - **Form di login**: inserimento user e password. Se valido, ottiene un token e lo memorizza.
    - **Sezione “Breweries List”**:
        - Possibilità di scegliere quante birrerie per pagina
        - Navigazione tramite **Prev / Next** e input “Pagina” per un salto diretto.
        - Cliccando su una birreria, si apre una sezione di dettaglio con `brewery_type`, `phone`, `website_url`, ecc.
---

## Come eseguire i test

### Test Feature (Pest)

1. **Installare le dipendenze**: Assicurati di aver eseguito `composer install` e, se necessario, `npm install` (se usi mix/vite).
2. **Configurare `.env.testing`** (o usa i default) con `DB_CONNECTION=sqlite` e `DB_DATABASE=:memory:` per un DB in memoria.
3. **Eseguire i test** con:
   ```bash
   php artisan test
   ```
   Oppure direttamente con Pest:
   ```bash
   ./vendor/bin/pest
   ```
4. Nella cartella `tests/Feature/` troverai file come:
    - `AuthTest.php`: test per `/api/login` (credenziali valide, invalide, validazione).
    - `BreweriesTest.php`: test per `/api/breweries` (token assente, token valido, parametri di validazione).
