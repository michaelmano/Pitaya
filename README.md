# Pitaya
A Wordpress Starter theme
[!Demo][pitaya-demo]

## Table of Contents

- [Folder Structure](#folder-structure)
- [Development](#development)
- [Todo](#todo)


## Folder Structure.

```
Pitaya
_____________________________
|-- assets
|   |-- fonts
|   |   `-- idnex.php
|   |-- images
|   |   |-- admin-logo.svg
|   |   |-- favicons
|   |   `-- index.php
|   |-- index.php
|   |-- javascripts
|   |   |-- index.php
|   |   `-- site.js
|   `-- media
|       `-- index.php
|-- core
|   |-- assets
|   |   |-- index.php
|   |   |-- main.js
|   |   `-- style.css
|   |-- index.php
|   |-- pitaya-activation.php
|   |-- pitaya-functions.php
|   `-- pitaya-settings.php
|-- includes
|   |-- carousel.php
|   `-- index.php
|-- languages
|   `-- index.php
|-- resources
|   |-- fonts
|   |   `-- idnex.php
|   |-- images
|   |   |-- index.php
|   |   `-- screenshot.psd
|   |-- index.php
|   |-- javascripts
|   |   |-- index.php
|   |   |-- main.js
|   |   `-- vendors
|   |       |-- flickity.js
|   |       `-- macy.js
|   |-- media
|   |   `-- index.php
|   `-- stylesheets
|       |-- index.php
|       |-- partials
|       |   |-- _carousel.scss
|       |   |-- _global.scss
|       |   |-- _grid.scss
|       |   |-- index.php
|       |   |-- _macy.scss
|       |   |-- mixins
|       |   |   `-- index.php
|       |   |-- _normalize.scss
|       |   `-- _variables.scss
|       |-- style.scss
|       `-- vendors
|           `-- _flickity.scss
|-- templates
|   `-- index.php
|-- CHANGELOG.md
|-- footer.php
|-- front-page.php
|-- functions.php
|-- Gulpfile.js
|-- header.php
|-- index.html
|-- index.php
|-- LICENSE.md
|-- package.json
|-- README.md
|-- screenshot.png
`-- style.css
```

## Development

**If you wish to contribute please use the editorconfig extension for your editor, I have provided a .editorconfig file in the git.**

You will need to run npm install, If you have issues with devDependancies not being installed you can try npm install
`$npm install --only=dev`
Once the node_modules have been installed you can run `gulp` and this will watch all scss files inside of the assets/stylesheets directory, once you have finished development you can then run `gulp prodiction` and this will minimize the css and remove all comments and maps except for the wordpress header comments.

## TODO
* Init all files.

[pitaya-image]: https://www.michaelmano.com/pitaya.svg
[pitaya-demo]: http://codepen.io/michaelmano/details/ObNORo/
[pitaya-url]: https://www.michaelmano.com
