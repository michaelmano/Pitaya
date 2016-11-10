# Pitaya
A Wordpress Starter theme

## Table of Contents

- [Folder Structure](#folder-structure)
- [Development](#development)
- [Todo](#todo)


## Folder Structure.

```
pitaya/
├── assets/
│   ├── fonts/
│   ├── images/
│   ├── javascripts/
│   ├── media/
│   └── stylesheets/
|       ├── partials/
|       |   ├── mixins/
|       |   ├── _grid.scss
|       |   ├── _normalize.scss
|       |   └── _variables.scss
|       └── style.scss
├── core/
│   ├── .../
|   └── .../
├── includes/
│   ├── .../
|   └── .../
├── languages/
│   ├── .../
|   └── .../
├── templates/
|   └── .../
├── .editorconfig
├── .gitignore
├── CHANGELOG.md
├── Gulpfile.js
├── package.json
├── README.md
└── style.css
```

## Development

**If you wish to contribute please use the editorconfig extension for your editor, I have provided a .editorconfig file in the git.**

You will need to run npm install, If you have issues with devDependancies not being installed you can try npm install
`$npm install --only=dev`
Once the node_modules have been installed you can run `npm gulp` and this will watch all scss files inside of the assets/stylesheets directory, once you have finished development you can then run `$npm gulp prodiction` and this will minimize the css and remove all comments and maps except for the wordpress header comments.

## TODO
* Init all files.

[pitaya-image]: https://www.michaelmano.com/pitaya.svg
[pitaya-url]: https://www.michaelmano.com