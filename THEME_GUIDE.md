# Guida per costruire un tema WordPress professionale

Questa guida serve come riferimento pratico per creare un tema WordPress strutturato, scalabile e facile da mantenere.

## 1. Obiettivo

Un tema professionale dovrebbe avere:
- una struttura chiara dei file;
- template separati per ogni tipo di contenuto;
- componenti riutilizzabili;
- stile organizzato con SCSS;
- accessibilità e SEO presenti fin dall'inizio;
- logica PHP pulita e leggibile.

---

## 2. Struttura del tema

Una struttura semplice ma efficace è questa:

```text
theme/
├── assets/
├── inc/
├── template-parts/
├── src/
│   ├── components/
│   ├── styles/
│   │   ├── abstracts/
│   │   ├── base/
│   │   ├── components/
│   │   ├── layouts/
│   │   └── main.scss
│   └── main.js
├── functions.php
├── header.php
├── footer.php
├── index.php
├── single.php
├── page.php
├── archive.php
├── search.php
└── style.css
```

### Regola generale
- `template-parts` = blocchi riutilizzabili
- `inc` = funzioni, helper, customizer, supporti
- `src/styles` = stile organizzato per responsabilità
- `src/components` = logica JS modulare

---

## 3. Struttura dei file Sass

### Base
Contiene regole fondamentali:
- reset / normalize
- tipografia base
- colori di base
- utility generiche

### Layouts
Contiene la struttura del layout:
- header
- footer
- content
- sidebar

### Components
Contiene i componenti riutilizzabili:
- nav
- buttons
- cards
- forms
- hero

### Utilities
Contiene classi helper come:
- spacing
- display
- text alignment
- responsive helpers

### Abstracts
Contiene variabili e mixin:
- colori
- spacing scale
- font stack
- breakpoints

---

## 4. Struttura PHP del tema

### `functions.php`
Qui vanno:
- registrazione menu
- supporti del tema
- enqueue di CSS/JS
- walker personalizzato
- hook per disabilitare Gutenberg se necessario
- require di file aggiuntivi in `inc/`

### `header.php`
Contiene:
- apertura del documento
- head
- header principale
- menu
- skip link

### `footer.php`
Contiene:
- chiusura del layout
- footer
- script di chiusura

### `template-parts`
Qui inserisci pezzi di markup riutilizzabili:
- `content.php`
- `content-page.php`
- `content-search.php`
- `content-none.php`

Questa scelta evita di duplicare il codice in più template.

---

## 5. Menu WordPress con walker

Per avere un controllo migliore sul markup del menu:
- usa `wp_nav_menu()`;
- crea un walker personalizzato;
- genera classi leggibili e coerenti con il tuo layout;
- usa una struttura semplice tipo `nav-item` e `nav-link`.

### Esempio concettuale
```php
wp_nav_menu(
    array(
        'theme_location' => 'menu-1',
        'menu_class'     => 'nav',
        'container'      => false,
        'walker'         => new My_Nav_Walker(),
    )
);
```

Questo è molto più professionale di un menu grezzo senza controllo.

---

## 6. Gutenberg e editor classico

Se il progetto non richiede l’editor a blocchi, puoi disabilitarlo in modo semplice:

```php
add_filter( 'use_block_editor_for_post', '__return_false', 10 );
add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );
add_filter( 'gutenberg_can_edit_post_type', '__return_false', 10 );
add_filter( 'use_widgets_block_editor', '__return_false' );
```

Questo aiuta a mantenere un flusso più controllato, soprattutto per temi custom.

---

## 7. ACF / SCF: regole da seguire

### Naming convention
Usa nomi chiari e coerenti:
- `hero_title`
- `hero_text`
- `hero_image`
- `cta_label`
- `cta_link`

Evita nomi generici come:
- `field1`
- `test`
- `img`

### Struttura scalabile
Organizza i campi per blocchi o sezioni:
- hero
- intro
- gallery
- cta
- testimonials

### Gestione dei dati
Ogni campo dovrebbe avere:
- un fallback sensato;
- una logica di visualizzazione chiara;
- un output separato dal template principale.

### ACF JSON
Se usi ACF JSON:
- salva i field group in JSON;
- tieni il file sotto controllo versione;
- usa un workflow condiviso con il team.

---

## 8. HTML professionale e accessibilità

Ogni template dovrebbe rispettare queste regole:
- usare la giusta gerarchia heading: h1 → h2 → h3;
- usare `alt` nelle immagini;
- usare link con testo significativo;
- usare tag semantici: `header`, `main`, `section`, `article`, `footer`;
- garantire navigazione via tastiera e focus chiaro.

### Esempio di struttura base
```html
<header>
  <nav></nav>
</header>

<main>
  <section>
    <article>
      <h1>Titolo</h1>
    </article>
  </section>
</main>

<footer></footer>
```

---

## 9. Bootstrap e CSS

### Usa Bootstrap come base
Bootstrap può essere usato per:
- griglia;
- spacing;
- componenti base;
- utility responsive.

### Ma fai override in modo pulito
Definisci variabili personalizzate per:
- colori;
- spacing;
- radius;
- font.

### Regola pratica
- usa Bootstrap per struttura e utility;
- usa il tuo CSS per componenti custom e branding.

---

## 10. SCSS e build

### Organizzazione SCSS
Usa una struttura chiara:
- `abstracts` per variabili e mixin;
- `base` per reset e utility;
- `layouts` per header/footer/content;
- `components` per componenti;
- `main.scss` come entry point.

### Build con Vite
Vite è perfetto per questo workflow:
- compila SCSS;
- gestisce JS modularmente;
- separa logica UI da markup.

### Regola pratica
- JS per comportamento;
- SCSS per stile;
- PHP per output del contenuto.

---

## 11. Checklist rapida per iniziare

Prima di considerare il tema “professionale”, verifica che ci siano:
- [ ] template separati per ogni tipo di contenuto
- [ ] partial riutilizzabili
- [ ] menu gestito con walker
- [ ] stile organizzato in SCSS
- [ ] variabili per palette e spacing
- [ ] heading corretti e semantica HTML
- [ ] immagini con alt
- [ ] accessibilità base
- [ ] logica ACF/SCF ordinata
- [ ] build con Vite funzionante

---

## 12. Metodo consigliato per replicarlo

Per replicare questo approccio in altri progetti:
1. partire da un tema base;
2. creare la struttura delle cartelle;
3. definire palette, spacing e tipografia;
4. impostare il menu con walker;
5. organizzare i template e i partial;
6. aggiungere ACF/SCF con una logica scalabile;
7. migliorare accessibilità e SEO;
8. mantenere lo stile in SCSS e il build con Vite.

Se segui questa struttura, il tuo tema diventa molto più facile da estendere e da mantenere.
