# Guida tecnica del portfolio Mario Tolvo

Documentazione dell'implementazione presente nel tema `mario_tolvo_portfolio`, verificata il 7 ottobre 2026. La guida generale `THEME_GUIDE.md` rimane separata e invariata. Questa guida descrive il codice attuale; le indicazioni di verifica non implicano che ogni scenario sia già stato collaudato nel browser.

## 1. Architettura e responsabilità

Il sito è un tema WordPress PHP con contenuti amministrabili tramite API ACF, disponibili nell'installazione anche attraverso Secure Custom Fields. Non è una SPA React. Bootstrap 5.3.3, installato localmente, fornisce griglia, utility e stili base; SCSS e JavaScript personalizzati definiscono il portfolio. Vite compila gli asset.

| Percorso | Responsabilità |
|---|---|
| `functions.php` | Supporti WordPress, menu e walker, caricamento asset, editor classico, configurazione JSON ACF |
| `inc/post-types.php` | Tipo contenuto progetto, categorie, tecnologie e termini iniziali |
| `inc/flexible-content.php` | Scelta dei template dei blocchi ACF |
| `inc/template-tags.php`, `inc/template-functions.php` | Helper per i template e integrazione WordPress |
| `inc/customizer.php`, `inc/custom-header.php` | Integrazione con le personalizzazioni WordPress |
| `acf-json/` | Definizioni dei gruppi di campi; i valori compilati si trovano nel database |
| `template-parts/blocks/` | Hero, competenze, testo/immagine, contatti, CTA e griglia progetti |
| `src/main.js` | Import degli stili e inizializzazione dei comportamenti |
| `src/components/` | Moduli JavaScript delle singole interazioni |
| `src/styles/` | SCSS sorgente |
| `assets/fonts/stray/` | Font locale dell'effetto scramble |
| `dist/assets/` | CSS, JavaScript e font compilati caricati sul sito |

PHP produce il contenuto e il markup, SCSS controlla la presentazione, JavaScript aggiunge interazioni. I contenuti editoriali non vanno inseriti negli asset compilati.

## 2. Template WordPress e contenuti

`header.php` apre il documento, include `wp_head()`, il viewport, lo skip link e l'header. `footer.php` include il footer e `wp_footer()`. Il footer attuale ha un contenitore informativo senza credit visibile.

`page.php` usa `template-parts/content-page.php`. Se esistono righe ACF in `content_blocks`, vengono renderizzati i blocchi flessibili nell'ordine impostato nell'amministrazione. In assenza di blocchi o delle API necessarie, la pagina usa `the_content()`. Il titolo standard della pagina è intenzionalmente omesso in questo partial: il titolo principale può arrivare dalla hero.

`single-progetto.php` gestisce il dettaglio progetto. `archive-progetto.php` gestisce l'archivio. I template `single.php`, `archive.php`, `index.php`, `search.php` e `404.php` gestiscono i contenuti standard e i fallback WordPress.

Il tema registra menu `menu-1`, sidebar `sidebar-1`, logo personalizzato, miniature, title-tag, markup HTML5, feed e altri supporti WordPress. L'editor a blocchi è disabilitato attraverso filtri in `functions.php`; il flusso editoriale usa editor classico e campi personalizzati.

### Blocchi flessibili

| Layout ACF | Template | Contenuto principale |
|---|---|---|
| `hero` | `hero.php` | Titolo, testo, immagine di sfondo, pulsanti e icone |
| `skills` | `skills.php` | Titolo ed elenco di immagini e nomi delle competenze |
| `text_image` | `text-image.php` | Titolo, descrizione, pulsante e immagine |
| `contact` | `contact.php` | Titolo, descrizione, recapiti e form |
| `cta_banner` | `cta-banner.php` | Richiamo all'azione |
| `projects_grid` | `projects-grid.php` | Progetti, filtri e link di approfondimento |

Le sezioni possono avere un `block_anchor`, normalizzato con `sanitize_title()`, per i link interni. `.flexible-block` ha `scroll-margin-top: 6rem` per lasciare spazio all'header quando si raggiunge una sezione.

## 3. Tutti i breakpoint Bootstrap

I valori sono quelli della dipendenza locale, in `node_modules/bootstrap/scss/_variables.scss`. Il tema non ridefinisce `$grid-breakpoints` o `$container-max-widths`.

| Nome | Soglia minima | Fascia prima della soglia successiva | `.container`: larghezza massima |
|---|---:|---|---:|
| `xs` | 0 | meno di 576px | fluida, 100% con padding |
| `sm` | 576px | da 576px a meno di 768px | 540px |
| `md` | 768px | da 768px a meno di 992px | 720px |
| `lg` | 992px | da 992px a meno di 1200px | 960px |
| `xl` | 1200px | da 1200px a meno di 1400px | 1140px |
| `xxl` | 1400px | da 1400px in su | 1320px |

Queste larghezze sono pixel CSS del viewport, non risoluzioni fisiche dello schermo. Il viewport dichiarato in `header.php` è `width=device-width, initial-scale=1`.

`xs` non appare nel nome delle classi: si scrive `col-12`, non `col-xs-12`. Una classe `col-md-6` si attiva da 768px e continua a valere a larghezze maggiori, finché un'altra regola la sostituisce. I nomi non identificano rigidamente telefono, tablet o computer: descrivono lo spazio disponibile.

### Come si scrivono le media query

```scss
.elemento {
  // Stile base, valido anche sugli schermi più piccoli.
  width: 100%;
}

@include media-breakpoint-up(lg) {
  .elemento { width: 50%; }
}
```

Il mixin Bootstrap genera `@media (min-width: 992px)`. Sono disponibili anche `media-breakpoint-down`, `media-breakpoint-between` e `media-breakpoint-only`, ma i componenti custom attuali usano `up(lg)`, oltre alla query esplicita della gallery.

Per `down(md)`, Bootstrap usa il limite inferiore alla soglia md (`max-width: 767.98px`). Non significa “fino alla fine della fascia md”. Per rappresentare la sola fascia md, usare `only(md)`.

### Media query personalizzate presenti

| File | Condizione | Effetto |
|---|---|---|
| `_navigation.scss` | `media-breakpoint-up(lg)` | Menu orizzontale e pulsante mobile nascosto |
| `_skills.scss` | `media-breakpoint-up(lg)` | Separatori adattati alle righe da quattro competenze |
| `_project-detail.scss` | `min-width: 768px` | Gallery a due colonne |
| `_hero.scss` | `prefers-reduced-motion: reduce` | Disattivazione delle animazioni hero |

`navigation.js` usa anche `window.innerWidth >= 992` per resettare lo stato del menu al passaggio al desktop. `scramble-buttons.js` controlla `prefers-reduced-motion`. La preferenza per il movimento ridotto non è un breakpoint di larghezza.

I CSS compilati contengono inoltre le media query generate da Bootstrap per griglia, container, utility e componenti, incluse quelle non utilizzate nei template.

## 4. Perché il tema è mobile first

La configurazione base è pensata per uno spazio ridotto: contenuti impilati, colonne spesso a larghezza piena, menu richiudibile e pulsanti hero verticali. Le regole `min-width` aggiungono le disposizioni più ampie quando esiste spazio sufficiente.

Non si parte da colonne desktop da restringere con una lunga serie di correzioni: si definisce prima una disposizione leggibile sul piccolo schermo e la si amplia. Questo riduce gli override necessari e mantiene chiaro il comportamento delle classi.

Mobile first non significa che tutto debba stare in una colonna: le competenze hanno due colonne già nella configurazione base. Non garantisce da solo prestazioni o assenza di overflow: testi lunghi, pulsanti e immagini devono comunque essere verificati.

```html
<div class="row g-4">
  <div class="col-12 col-md-6 col-xl-4">Progetto</div>
</div>
```

Qui il comportamento è: 100% sotto 768px, 50% da 768px a meno di 1200px, circa 33,33% da 1200px in su. La regola md resta attiva anche nella fascia lg, perché non esiste una classe lg che la sostituisca.

## 5. Griglia Bootstrap: container, righe e colonne

La struttura usuale è `.container > .row > .col-*`. Il container centra e limita il contenuto; la riga usa flexbox con wrapping; le colonne distribuiscono la larghezza.

Bootstrap divide la riga in 12 unità. `col-12` occupa 12/12 (100%), `col-6` 6/12 (50%), `col-4` 4/12 (33,33%), `col-5` 5/12 (41,67%), `col-7` 7/12 (58,33%) e `col-8` 8/12 (66,67%). Queste percentuali sono relative alla riga, non all'intera finestra.

`col` distribuisce automaticamente lo spazio. `row-cols-2` imposta due colonne per riga sui figli; `row-cols-lg-4` ne imposta quattro da 992px. `offset-lg-1` aggiunge un margine sinistro pari a 1/12 da lg: non è una colonna HTML vuota.

I gutter sono ottenuti con padding delle colonne e margini della riga, non con un semplice `gap` tra colonne percentuali. Usare `g-*`, `gx-*` o `gy-*` sulla griglia evita di sommare un gap extra alle larghezze che già riempiono la riga.

### Mappa dei layout effettivi

| Sezione | Classi/tecnica | Sotto 768px | 768–meno di 992px | 992–meno di 1200px | Da 1200px |
|---|---|---|---|---|---|
| Header: logo/menu | `col-12 col-lg-4` + `col-12 col-lg-8` | Impilati | Impilati | 4/12 + 8/12 | Come lg |
| Hero: contenuto | `col-12 col-lg-6` | Piena larghezza | Piena larghezza | Metà riga | Come lg |
| Competenze | `row-cols-2 row-cols-lg-4` | 2 colonne | 2 colonne | 4 colonne | 4 colonne |
| Testo/immagine | Due `col-12 col-lg-6` | Testo sopra immagine | Testo sopra immagine | Due metà affiancate | Come lg |
| Contatti | `col-12 col-lg-5` + `col-12 col-lg-6 offset-lg-1` | Impilati | Impilati | 5/12 + offset 1/12 + 6/12 | Come lg |
| Contenuto CTA | `col-12 col-lg-7` | Piena larghezza | Piena larghezza | 7/12 | Come lg |
| Progetti nel blocco homepage | `col-12 col-md-6 col-xl-4` | 1 colonna | 2 colonne | 2 colonne | 3 colonne |
| Archivio progetti | `col-12 col-lg-6` | 1 colonna | 1 colonna | 2 colonne | 2 colonne |
| Dettaglio: testo/sidebar | `col-lg-7` + `col-lg-4`, riga `justify-content-between` | Impilati | Impilati | 7/12 + 4/12 | Come lg |
| Gallery progetto | Colonne CSS | 1 colonna | 2 colonne | 2 colonne | 2 colonne |

Nel dettaglio progetto le colonne hanno solo il suffisso lg: sotto la soglia la regola base di `.row > *` le mantiene a larghezza piena. Lo spazio tra 7/12 e 4/12 viene distribuito dalla riga.

I pulsanti hero usano `flex-column flex-sm-row`: sono verticali sotto 576px e orizzontali da 576px. Questo cambiamento è indipendente dalla larghezza del blocco hero, che si dimezza solo da 992px.

## 6. Spaziature e utility

La scala Bootstrap attuale è:

| Suffisso | rem | px con base 16px |
|---|---:|---:|
| `0` | 0 | 0 |
| `1` | 0,25 | 4 |
| `2` | 0,5 | 8 |
| `3` | 1 | 16 |
| `4` | 1,5 | 24 |
| `5` | 3 | 48 |

`m` significa margin, `p` padding; `t` sopra, `b` sotto, `s` inizio, `e` fine, `x` entrambi i lati orizzontali e `y` entrambi i lati verticali. `mb-4` applica 24px sotto; `py-5` applica 48px sopra e sotto. `g-4` imposta gutter orizzontali e verticali di 24px; `gap-3` è uno spazio di 16px tra elementi flex/grid.

Molte sezioni hanno `py-5` sul wrapper e `py-lg-5` sul container interno. Sotto 992px il padding verticale è quello esterno; da 992px si aggiunge anche quello interno. Non è una sostituzione, perché sono due elementi distinti.

Le competenze usano `g-4 g-lg-5`: gutter di 24px sotto lg e 48px da lg. Le utility responsive adottano gli stessi breakpoint delle colonne. `d-lg-none` nasconde un elemento da lg; non prima.

`_utilities.scss` genera classi `u-m*` e `u-p*` da 0 a 100 basate su variabili `--afterclass-space-N`: il numero non equivale automaticamente a pixel. Occorre definire la relativa variabile CSS per ottenere un valore valido. Include anche `u-pt-240` (240px) e min-height in vh per 25, 50, 70, 75 e 100.

La scala Bootstrap standard termina a 5: `py-lg-6`, presente nel dettaglio progetto, non ha una definizione nella configurazione corrente. Questa guida segnala il comportamento attuale senza modificare il layout.

## 7. Tipografia fluida e specificità

In `_base.scss`, `html` ha `font-size: 16px`. Un rem vale quindi 16px nella configurazione del tema. I titoli usano Sora, il testo il font stack Segoe UI/Roboto/Helvetica Neue/Arial. Sora viene caricato da Google Fonts; Stray è locale e usato nell'effetto scramble.

| Selettore | `font-size` | Minimo | Massimo |
|---|---|---:|---:|
| `h1`, `.page-title`, `.entry-title` | `clamp(2rem, 1.5rem + 2.2vw, 3.25rem)` | 32px | 52px |
| `h2` | `clamp(1.6rem, 1.3rem + 1.4vw, 2.25rem)` | 25,6px | 36px |
| `h3` | `clamp(1.3rem, 1.1rem + .85vw, 1.75rem)` | 20,8px | 28px |
| `h4` | `clamp(1.1rem, 1rem + .6vw, 1.35rem)` | 17,6px | 21,6px |
| `h5`, `h6` | `clamp(1rem, .95rem + .3vw, 1.1rem)` | 16px | 17,6px |

`clamp(minimo, preferito, massimo)` limita una misura fluida. `vw` è l'1% della larghezza del viewport; `rem` dipende dal font-size dell'elemento html, non da quello del genitore. A 800px, l'h1 vale `24 + 17,6 = 41,6px`. Raggiunge il minimo intorno a 364px e il massimo intorno a 1273px.

La dimensione del font non coincide con l'altezza della scatola o dei glifi: la line-height dei titoli è 1,2, e più righe aumentano l'altezza totale.

Le classi Bootstrap `display-*` sono state rimosse dagli heading dei blocchi hero, competenze, contatti, testo/immagine e CTA. Prima `.display-4` prevaleva su `h1` e portava il titolo a 56px da 1200px, con una formula fluida sotto quella soglia. Bootstrap continua a definire queste classi nel CSS; non sono più applicate a quei titoli.

Restano classi tipografiche `.h1`, `.h3`, `.h4`, `.h5`, per esempio sul titolo del blocco progetti e delle card. Sono classi Bootstrap distinte dai tag HTML e possono prevalere sui clamp per specificità. Un `h2.h1` mantiene la semantica h2, ma assume la dimensione della classe h1. Non tutti i titoli del sito seguono dunque soltanto la tabella dei tag.

Per diagnosticare una dimensione: selezionare l'elemento negli strumenti sviluppatore, leggere `Computed > font-size`, controllare la regola vincente e il font-size di html. Le regole barrate non sono quelle applicate.

## 8. Progetti, campi e tassonomie

Il tipo contenuto `progetto` è pubblico, ha archivio e slug `progetti`, supporta titolo e immagine in evidenza ed è esposto alla REST API. Le categorie `categoria_progetto` sono gerarchiche; le tecnologie `tecnologia` sono non gerarchiche, analoghe ai tag. I relativi slug sono `categorie-progetti` e `tecnologie`.

`inc/post-types.php` inserisce i termini iniziali mancanti senza duplicare quelli esistenti. Al cambio di tema rigenera le rewrite rules.

I principali campi di `acf-json/group_projects.json` sono:

| Campo | Uso |
|---|---|
| `project_client`, `project_year`, `project_role` | Metadati del progetto; l'anno è un date picker restituito come anno |
| `project_site_url`, `project_status` | URL e stato: online, offline o in sviluppo |
| `project_short_description` | Descrizione card, massimo 160 caratteri nel field group |
| `project_hero_image` | Immagine principale, con fallback alla featured image |
| `project_description` | Descrizione estesa WYSIWYG |
| `project_contribution` | Repeater delle attività svolte |
| `project_challenge`, `project_solution`, `project_results` | Racconto del caso studio |
| `project_gallery` | Repeater di immagine e didascalia |
| `project_links` | Repeater di testo e URL |

Le tassonomie si assegnano nei box WordPress dedicati: non sono campi ACF. I JSON descrivono la struttura dei campi e non contengono tutti i contenuti dei progetti.

### Query e card

Il blocco homepage carica tutti i progetti pubblicati con ordine casuale, ma mostra inizialmente tre card quando il filtro è inizializzato. L'archivio carica tutti i progetti pubblicati dal più recente, senza paginazione. `posts_per_page: -1` implica che tutti vengono caricati, anche se alcuni sono nascosti dal filtro.

Le card usano hero ACF, poi immagine in evidenza, poi placeholder. L'area immagine ha rapporto 4:3 e `object-fit: cover`, quindi può tagliare parte dell'immagine. Nel blocco homepage si mostrano fino a quattro tecnologie scelte casualmente; nell'archivio vengono mostrate tutte quelle assegnate. I dati di filtro contengono comunque tutti i termini del progetto.

### Filtri e pulsante di espansione

I termini non vuoti vengono raccolti prima dalle categorie, poi dalle tecnologie. Il limite attuale di 20 riguarda la somma delle due tassonomie, oltre al pulsante “Tutti”; è uguale su mobile e desktop. Non è stato implementato il limite mobile di sei tecnologie proposto in conversazione.

`projects-filter.js` nasconde i termini oltre i primi 20 e abilita “Mostra tutte”, che diventa “Mostra meno” durante l'espansione. Il pulsante usa `aria-expanded`. Un termine selezionato resta visibile anche richiudendo l'elenco: in quel caso si possono vedere più di 20 termini.

Si possono selezionare più filtri. La logica è OR: basta che un progetto corrisponda a uno dei termini selezionati. “Tutti” azzera la selezione; nel blocco homepage ripristina le tre card iniziali, mentre nell'archivio ripristina tutti i progetti. Il valore del filtro unisce tassonomia e slug (`tecnologia:react`) per evitare collisioni tra termini omonimi.

Il filtraggio è nel browser, senza richieste AJAX e senza aggiornamento dell'URL. Senza JavaScript l'elenco dei termini rimane completo e il pulsante di espansione resta nascosto.

## 9. Gallery a mosaico

La gallery del dettaglio non usa più righe e colonne Bootstrap. Il wrapper `.project-detail__gallery-grid` usa `column-count: 1`, poi `column-count: 2` da 768px, con `column-gap: 1.5rem`.

Le figure sono `inline-block`, larghe 100%, con `break-inside: avoid` e margine inferiore di 1,5rem. L'immagine ha larghezza 100% e altezza automatica; foto e didascalia rimangono insieme. Le diverse altezze non producono i vuoti di una griglia organizzata per righe.

È un mosaico basato su colonne CSS, senza libreria JavaScript: l'ordine visivo scorre dall'alto verso il basso nella prima colonna e poi nella successiva. Non è un algoritmo che posiziona ogni immagine nella colonna più corta. Considerare questo ordine quando si dispongono screenshot con una sequenza narrativa.

L'immagine principale del progetto ha invece altezza massima 48rem e `object-fit: cover`. Immagini hero e gallery sono gestite tramite `wp_get_attachment_image()` con le dimensioni WordPress richieste dal template.

## 10. Navigazione, animazioni e interazioni

L'header è `fixed-top`, trasparente con una superficie sfumata e leggermente sfocata, z-index 1030. Il logo ha altezza massima 56px. Il menu usa il walker custom di `functions.php` e il menu assegnato alla posizione Primary.

Sotto 992px il menu è nascosto finché il pulsante non aggiunge `.is-open`; da 992px viene mostrato in orizzontale. `navigation.js` sincronizza `aria-expanded` e azzera lo stato mobile quando la finestra arriva a 992px.

`navigation-contrast.js` legge `data-header-theme="light"` o `"dark"` sulle sezioni: produce testo nero su sezioni chiare e bianco su sezioni scure, anche con una divisione del colore quando un link attraversa un confine. Aggiorna su scroll e resize tramite requestAnimationFrame, con ResizeObserver dove disponibile.

La hero anima lo sfondo e l'ingresso delle parole, del sottotitolo, dei pulsanti e delle icone. L'immagine di sfondo usa cover: può essere ritagliata in modo diverso tra telefono e desktop. Le icone hero sono 28×28px e rese bianche con un filtro CSS.

`scramble-buttons.js` aggiunge l'effetto di sostituzione temporanea delle lettere ai pulsanti `.js-scramble-button`, con un'etichetta accessibile stabile. Tiene conto della preferenza per il movimento ridotto.

Le competenze mostrano inizialmente quattro elementi: in due righe su mobile e una riga da lg. `skills-toggle.js` espande o richiude gli elementi successivi usando `hidden` e `aria-expanded`. Il numero iniziale resta quattro a tutte le larghezze.

Bootstrap è importato come SCSS, ma `src/main.js` non importa il JavaScript Bootstrap. Il menu mobile è quindi gestito dal codice custom, non da Bootstrap Collapse. Il walker produce anche attributi dropdown Bootstrap per eventuali sottomenu: il relativo comportamento non è automaticamente fornito da questa build e va verificato prima di usare menu annidati.

## 11. Contatti

Il blocco contatti legge l'ID del form ACF e verifica che il post sia di tipo `wpcf7_contact_form` prima di usare lo shortcode Contact Form 7. Invio, validazione e gestione delle email dipendono dal plugin e dalla sua configurazione, non dal JavaScript del tema.

Gli input e la textarea occupano tutta la larghezza disponibile. La textarea ha altezza minima 10rem e si ridimensiona verticalmente; il submit è largo 100%. `contact-form.js` ricava il testo delle label, lo usa come placeholder e aria-label se mancanti, e rimuove o nasconde il testo visivo della label. Il codice riguarda i tipi di campo selezionati nel modulo, non tutti i controlli HTML possibili.

## 12. Colori e organizzazione SCSS

`src/styles/main.scss` importa, in ordine, variabili del tema, Bootstrap, base, utility, componenti e layout. Le variabili definite prima di Bootstrap personalizzano la palette Bootstrap. I CSS custom successivi possono sovrascriverne i risultati.

`abstracts/_variables.scss` contiene i token Sass `$theme-*` e gli override `$primary`, `$secondary`, ecc. `_base.scss` dichiara anche le variabili CSS `--theme-*`. Sono due sistemi distinti, con alcuni valori differenti: modificare un token Sass non aggiorna automaticamente il corrispondente token CSS. Alcuni componenti usano direttamente bianco e nero.

I nomi come `.project-detail__gallery-grid` e `.project-card__media` identificano elementi del componente; le utility Bootstrap aggiungono struttura e spaziatura. Per modificare la presentazione lavorare sullo SCSS sorgente, non su `dist/assets/main.css`.

## 13. Build e caricamento degli asset

Eseguire dalla directory del tema:

```powershell
npm ci
npm run dev
npm run build
```

`npm ci` installa le dipendenze del lockfile; `dev` avvia Vite sulla porta 5173 con host `0.0.0.0`; `build` genera gli asset di produzione. La configurazione usa `base: './'`, entry `src/main.js`, cartella `dist` e nomi stabili `main.css` e `main.js`. `emptyOutDir: true` ricrea il contenuto della cartella di build.

`functions.php` carica `dist/assets/main.css` e `main.js` se presenti e usa `filemtime()` come versione per invalidare la cache. Se manca il CSS compilato, carica `style.css`, che non va considerato equivalente a tutta la build. Il codice di enqueue non collega automaticamente WordPress al server Vite: avviare `dev` da solo non sostituisce gli asset serviti dalla pagina WordPress.

Per le modifiche PHP non serve ricompilare. Per le modifiche SCSS o JavaScript eseguire `npm run build`. Gli avvisi di deprecazione Sass/Bootstrap osservati durante la build sono distinti dagli errori che impediscono la compilazione.

Il tema include anche `compile:rtl`, che usa rtlcss su `style.css`: non è una pipeline RTL automatica per `dist/assets/main.css`.

## 14. Accessibilità, immagini e manutenzione

Il tema include struttura semantica, skip link, stato del menu con aria-expanded, stato dei filtri con aria-pressed, testi accessibili per le animazioni e supporto reduced motion. Questi meccanismi non equivalgono a una certificazione di accessibilità: vanno verificati con tastiera, focus, contrasto e tecnologie assistive.

Le immagini WordPress possono includere srcset e sizes generati dal core. Gli alt dipendono dai metadati della Media Library e dagli eventuali override del template: compilarli con descrizioni pertinenti. Per i mockup dimostrativi dichiararne la natura nella didascalia.

Il PHP usa funzioni di escaping quali `esc_html()`, `esc_attr()` ed `esc_url()`, e `wp_kses_post()` per i contenuti ricchi. Quando si aggiunge un campo, applicare l'escaping adatto al punto di output.

Per aggiungere un blocco: definire il layout nel gruppo ACF, creare il partial PHP, collegarlo in `inc/flexible-content.php`, aggiungere eventuale SCSS a `main.scss` e inizializzare eventuale JavaScript in `main.js`. Per aggiungere un breakpoint custom, controllare anche le soglie JavaScript correlate; la soglia 992 del menu è scritta esplicitamente nel modulo JS.

## 15. Verifiche responsive consigliate

Controllare almeno 320px, 375px, 575/576px, 767/768px, 991/992px, 1199/1200px e 1399/1400px, oltre a larghezze intermedie. Le coppie attorno alle soglie rendono visibili i cambi di layout.

Verificare:

- Assenza di scroll orizzontale con titoli lunghi, nomi tecnologia e pulsanti.
- Menu chiuso/aperto su mobile e passaggio al desktop e ritorno.
- Hero con sfondo ritagliato, pulsanti verticali/orizzontali e testo su più righe.
- Competenze prima e dopo l'espansione.
- Filtri oltre il ventesimo, selezione multipla, “Mostra meno” e “Tutti”.
- Differenza tra griglia homepage e archivio progetti.
- Gallery con immagini alte, basse e didascalie lunghe.
- Form, messaggi di validazione e navigazione da tastiera.
- Zoom del browser e preferenza per il movimento ridotto.

Per verificare il codice senza confondere sorgente e risultato, controllare le classi nel template, le regole applicate in Computed e gli asset effettivamente caricati dalla pagina. Dopo una modifica SCSS/JS compilare e ricaricare la pagina; se il risultato sembra vecchio, controllare la cache e il file CSS richiesto.