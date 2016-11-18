# Pitaya

[pitaya-image][pitaya-link]

#### A Wordpress Starter theme
[Demo][pitaya-demo]

## Table of Contents

- [Folder Structure](#folder-structure)
- [Development](#development)
  * [Installing](#installing)
  * * [CSS/SASS Conventions](#csssass-conventions)
  * [Comment Conventions](#comment-conventions)
  * [Gulp Setup](#gulp-setip)
  * [Javascript Functions](#javascript-functions)
  * [Theme Specific Functions](#theme-specific-functions)
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


### Gulp Setup
I have set gulp up so that when you run gulp it is in development mode and will watch the files:
```
const paths = {
  styles: {
    src: './assets/stylesheets/scss/',
    files: './assets/stylesheets/scss/style.scss',
    dest: './assets/stylesheets/'
  },
  scripts: {
    src: './assets/javascripts/',
    files: ['./assets/javascripts/core/*.js', './assets/javascripts/vendors/*.js','./assets/javascripts/main.js'],
    dest: './assets/javascripts/'
  },
  svgs: {
    src: './assets/images/icons/sprite/',
    files: ['./assets/images/icons/sprite/*.svg'],
    dest: './assets/images/icons/'
  }
}

```
**SASS/CSS**
All files in `stylesheets/scss` are watched but the function will only run on the assets/stylesheets/style.scss which is used to include files in certain orders.

**Javascript**
In that order. So the javascript files in the core will be combined first at the top of site.js and then its vendors and then its the main.js which you use to call functions so there are no issues on refrencing dependancies that are not included yet.

**SVGS**
All files inside of `assets/images/icons/sprite` are watched any any changes or additions will trigger the svgstore gulp function which combines all svgs so you can refrence them in the site like so `<svg class="icon--bars"><use xlink:href="#bars"></use></svg>` the #bars being the name of the file that you put into sprites. this is called a SVG Sprite which makes only 1 http request for all svgs compared to 50 which can cause issues with load times.

**Production**
Once you have finished development and wish to minify the files just run `gulp production` which will minify the css and remove comments and same goes for the javascripts.


### Javascript functions
The javascript files are set up so that all functions are written in `assets/javascripts/core/functions.js` and all vendors are in `assets/javascripts/vendors` and any initations of functions are put into `assets/javascripts/main.js`

### Theme Specific Functions
**assets/core/pitaya-activation.php**
This file sets up Wordpress on the themes first activation. Below are a list of functions it runs:

- wp_delete_post(1) **Deletes the post Hello World**
- wp_delete_post(2) **Deletes the page Sample Page**
- wp_delete_comment(1)  **Deletes the Hello Word Comment**
- update_option('image_default_link_type', 'file') **Changes default attachment type to file**
- update_option('image_default_align', 'none' ) **Changes the default image alignment**
- update_option('image_default_size', 'medium' ) **Changes the default image size to default**
- $pages[] **This one creates the pages listed in the $pages array in the menu_order that they are mentioned**
- $home & $blog **Changes the default home page to the homepage and blog page to the news page**
- $wp_rewrite->set_permalink_structure('/%postname%/') **Sets up the sites permalink structure**
- $menus **Creates the primary navigation and lists all pages mentioned in the array**

**Below are a list of PHP functions I have written for the Theme:**

```
pitaya_social_nav([
  'size'  =>  'small',
  'float' =>  'right'
]);

pitaya_google_analytics();

pitaya_gallery_shortcode();

pitaya_add_sidebar_meta();

pitaya_auto_child_page_menu();

```
**pitaya_social_nav()**
This function only has 2 arguments which are listed above. The size is the size of the icons that will show which you can change in the css and the float is the float of the UL container.
The socials are called from the theme settings page in the admin area, any socials that are filled in will be called. just make sure you have the icon in the sprites folder with the name of the social, e.g. facebook.svg so that #facebook will be used for the svg.

**pitaya_google_analytics()**
This one does not need to be used as its already in the header. it will pull the tracking code from the theme settings page.

**pitaya_gallery_shortcode()**
This is the same as above as it does not require to be called. It is a function that overrides the Wordpress gallery and also adds 2 settings to it so that now when creating a gallery it gives you the options of Masonry or Slider.

**pitaya_add_sidebar_meta()**
This is the same as above as it does not require to be called. Adds a metabox to the sidebar on all pages which you can add more to if you wish but as a standard it comes with Enable Sidebar - instead of creating multiple page templates just to include a sidebar it can be done this way.

**pitaya_auto_child_page_menu()**
This is the same as above as it does not require to be called. Adds all child pages to the menus and you can disable them showing in the menu from the sidebar meta mentioned above.

**Below are a list of Javascript functions I have written for the Theme:**
```
navigationSizeCheck(time);
deviceDetection();
```
**navigationSizeCheck(time)**
This function runs on page load and resize, The time argument is for how long it takes to add the class dropdown to the menu to stop jittering.
How the navigation works is not by viewport sizes or media queries but by checking the size of all items in the navigation. If the size is under the screen width it stays as the default menu, If not it adds the class dropdown to it and shows the navigation toggle. This saves time when the client wants to add more items to the menu or change page names as sometimes this is a pain when the media queries handing the menu are over the size of the menu and it does not kick in.

**deviceDetection()**
This one returns true when its a touch screen device. It can be used like so

`if(deviceDetection() === true) $('.header').addClass('device')`


## TODO
* Init all files.


[snippets-link]: https://gist.github.com/michaelmano/00e91d1dd7fff80d6b39c88a7d3f7a73
[bem-example]: https://css-tricks.com/bem-101/
[bem-link]: http://getbem.com/
[node-link]: https://nodejs.org/en/download/
[node-image]: https://nodejs.org/static/images/logo-header.png
[pitaya-image]: https://pitaya.michaelmano.com/wp-content/themes/Pitaya/assets/images/logo.svg
[pitaya-demo]: https://pitaya.michaelmano.com
[pitaya-url]: https://www.michaelmano.com
