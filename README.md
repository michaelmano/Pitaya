# Pitaya
![][pitaya-image]

#### A Wordpress Starter theme
[Demo][pitaya-demo]

## Table of Contents

- [Folder Structure](#folder-structure)
- [Development](#development)
- [Todo](#todo)


## Folder Structure.

```
The below is as follows:

- Assets is for compiled and site resources.
- Core is for the theme core functionality that adds onto the functions.php
- Includes is for any theme partials like the carousel.
- Resources is for development whith unminified code and original files. ** Might update this later to be in assets.
- Templates is for wordpress page templates e.g. page-contact.php

Pitaya/
_____________________________
|-- assets/
|   |-- fonts/
|   |-- images/
|   |   `-- favicons/
|   |-- javascripts/
|   `-- media/
|-- core/
|   |-- assets/
|   |-- pitaya-activation.php
|   |-- pitaya-functions.php
|   `-- pitaya-settings.php
|-- includes/
|-- resources/
|   |-- fonts/
|   |-- images/
|   |-- javascripts/
|   |   |-- vendors/
|   |   `-- main.js
|   |-- media/
|   `-- stylesheets/
|       |-- partials/
|       |-- vendors/
|       `-- style.scss
|-- templates/
|-- CHANGELOG.md
|-- footer.php
|-- front-page.php
|-- functions.php
|-- Gulpfile.js
|-- header.php
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

[pitaya-image]: https://michaelmano.com/Pitaya.svg
[pitaya-demo]: http://codepen.io/michaelmano/details/ObNORo/
[pitaya-url]: https://www.michaelmano.com