Wordpress Grunt Starter Theme
=============================

Wordpress Boilerplate for rapid development. Using Grunt, Sass, and an amazing little gem called [Wordpress Deploy](https://www.npmjs.com/package/grunt-wordpress-deploy) we can now deploy to staging and production with a single line of code!

We can get into the goodies ive packed into this Starter Theme in a minute, first lets get everything set up.

##The Stack

* [NPM](https://npmjs.org/)
  * [grunt](http://gruntjs.com/)
    * [grunt-contrib-watch](https://github.com/gruntjs/grunt-contrib-watch)
    * [grunt-contrib-uglify](https://github.com/gruntjs/grunt-contrib-uglify)
    * [grunt-sass](https://www.npmjs.com/package/grunt-sass) (Faster than grunt-contrib-sass)
    * [grunt-wordpress-deploy](https://www.npmjs.com/package/grunt-wordpress-deploy)
    * [grunt-mysql-dump](https://www.npmjs.com/package/grunt-mysql-dump)
    * [grunt-bowercopy](https://www.npmjs.com/package/grunt-bowercopy)


<!-- create new folder whereever you store your websites, and then 
    git clone https://github.com/Bardown26/WordPress.git
 -->

##Installation 

**1: Clone into your Wordpress theme directory.**

```Shell
> cd {theme_directory}
> git clone https://github.com/Bardown26/Grunt-Starter-Theme.git
> cd Grunt-Starter-Theme
```
From now on, all your work will be done in your Grunt-Starter-Theme directory.

**2: Install dependent Node and Bower packagaes.**

```Shell
> npm install
```

**3: Now, Lets add the files from [this repository](https://github.com/Bardown26/wordpress-starter.git) to our root.**

Navigate to project root.
```Shell
> cd {project root directory}
```

Add the repo folder.
```Shell
> git clone https://github.com/Bardown26/wordpress-starter.git
```

Move the files from the repo folder to the root.
```Shell
> mv wordpress-starter/* .
```

Get rid of that now empty folder.
```Shell
> rm -r -f wordpress-starter
```

**4: Setup your local db under local-config.php and add your staging db to the wp-config.php**

**5: Code!**
```Shell
> grunt
```
Note: *Make sure to add your proper localhost under the LIVE RELOAD section of the function.php for it to work* 


##Development

```Shell
> grunt watch
```

##Building

When you are ready to push live, run the build command to minify your files.

```Shell
> grunt build
```

#Theme Goodies

* [CMB2 Custom Meta Boxes](https://github.com/WebDevStudios/CMB2). I really love what these guys have done. It makes adding functionality to specific pages / posts / custom post types, anything really insanely easy and fast.
* [breakpoint](https://github.com/at-import/breakpoint)

##Thanks
