# Pitaya
![][pitaya-image]

#### A Wordpress Starter theme
[Demo][pitaya-demo]

## Table of Contents

- [Folder Structure](#folder-structure)
- [Development](#development)
  * [Installing](#installing)
  * [CSS/SASS Conventions](#csssass-conventions)
  * [Comment Conventions](#comment-conventions)
- [Todo](#todo)


## Folder Structure.

```
The below is as follows:

- Assets holds the files required for your website, including non compiled.
- Core is for the theme core functionality that adds onto the functions.php
- Includes is for any theme partials like the carousel.
- Templates is for wordpress page templates e.g. page-contact.php

Pitaya/
_____________________________
|-- assets/
|   |-- fonts/
|   |-- images/
|   |   `-- favicons/
|   |-- javascripts/
|   |-- stylesheets
|   |   `-- scss/
|   `-- media/
|-- core/
|   |-- assets/
|   |-- pitaya-activation.php
|   |-- pitaya-functions.php
|   `-- pitaya-settings.php
|-- includes/
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

### Installing
To take full advantage of this theme you will require [NODE][node-link] to be installed which is for the SCSS files and minifying the javascripts.

[![node-image]][node-link]

For a fresh project without Wordpress installed you can either download Wordpress manually and git clone or download the theme and extract it into the themes folder and then set up your database and then run through the Wordpress installer

OR `npm install wpauto` and when it asks for a custom theme type pitaya and you are done.


### CSS/SASS Conventions

This project uses the [BEM CSS][bem-link] naming convention which has a few rules which are easy to follow, widely used and considered best practice.

```
/* Block component */
.btn {}

/* Element that depends upon the block */
.btn__price {}

/* Modifier that changes the style of the block */
.btn--orange {}
.btn--big {}


<a class="btn btn--big btn--orange" href="https://css-tricks.com/bem-101/">
  <span class="btn__price">$9.99</span>
  <span class="btn__text">Subscribe</span>
</a>
```
You can read the article on CSS tricks [Here][bem-example]

### Comment Conventions.
I have set up a few snippets that will help with your commenting style also, These are set up for atom but can be easily changed for any editor.
You can [Download them here][snippets-link]

The shortcuts are:
- d+tab for a new div which will also add the ending comment in HTML/PHP
- mainc+tab for a Main Comment. this is at the top of the file in either CSS/SASS or HTML/PHP
- subc+tab for a Sub Comment. Either CSS/SASS or HTML/PHP
- comd+tab for a Comment Description. Either CSS/SASS or HTML/PHP


## TODO
* Init all files.


[snippets-link]: https://gist.github.com/michaelmano/00e91d1dd7fff80d6b39c88a7d3f7a73
[bem-example]: https://css-tricks.com/bem-101/
[bem-link]: http://getbem.com/
[node-link]: https://nodejs.org/en/download/
[node-image]: https://nodejs.org/static/images/logo-header.png
[pitaya-image]: https://michaelmano.com/Pitaya.svg
[pitaya-demo]: http://codepen.io/michaelmano/details/ObNORo/
[pitaya-url]: https://www.michaelmano.com