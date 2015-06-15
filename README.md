Wordpress Grunt Starter Theme
=============================

Boilerplate starter code for Wordpress projects. Uses Grunt and Sass, alongside Bower for package management. (rewrite)

##The Stack

* [NPM](https://npmjs.org/)
  * [grunt](http://gruntjs.com/)
    * [grunt-contrib-watch](https://github.com/gruntjs/grunt-contrib-watch)
    * [grunt-contrib-uglify](https://github.com/gruntjs/grunt-contrib-uglify)
    * [grunt-sass](https://www.npmjs.com/package/grunt-sass) (Faster than grunt-contrib-sass)
    * [grunt-wordpress-deploy](https://www.npmjs.com/package/grunt-wordpress-deploy)
    * [grunt-mysql-dump](https://www.npmjs.com/package/grunt-mysql-dump)
    * [grunt-bowercopy](https://www.npmjs.com/package/grunt-bowercopy)
* [jQuery](http://jquery.com/)
* [modernizr](http://modernizr.com/)
* [SASS](http://sass-lang.com/)
* [breakpoint](http://breakpoint-sass.com/)
* [normalize.css](http://necolas.github.com/normalize.css/)

##Installation 

1: Clone into your Wordpress theme directory.

```Shell
> cd {theme_directory}
> git clone https://github.com/stinoga/wordpress-boilerplate.git
```
From now on, all your work will be done in your wordpress-boilerplate directory.

2: Install dependent Node and Bower packagaes.

```Shell
> npm install && bower install
```

3: If your wordpress install is in git, move the gitignore to your root directory. You can also remove the git submodule for this theme. Run these from the root of your Wordpress install:

```Shell
> git rm --cached wp-content/themes/wordpress-boilerplate/
> rm -rf wp-content/themes/wordpress-boilerplate/.git
```

4: Pull the wordpress starter files from [this repository](https://github.com/stinoga/wordpress-starter) and drop them in the root folder of the site.

5: Code!

```Shell
> grunt
```

##Building

When you are ready to push live, run the build command to minify your files.

```Shell
> grunt build
```

##Thanks

Thanks to the folks at [Bearded](http://bearded.com/). I stole some some pieces from their excellent starter kit, [Stubble](https://github.com/beardedstudio/stubble?source=cc).