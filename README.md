dakEventsPlugin - event management for symfony
==============================================

## <a name="overview">Overview</a> ##


dakEventsPlugin is a fullfledged multi-user event management software
for the [Symfony framework] [sf] v. 1.4.


It contains modules for a frontend application and a backend application. 
The frontend also includes an api module, so that, if enabled, third parties
can pull out events from specific arrangers, locations, festivals and/or categories.

  [sf]: http://www.symfony-project.org/
  [sfdoc]: http://www.symfony-project.org/

## <a name="about">About</a> ##
-----

This plugin is a pluginification of the test project
[kvarteret_symfony_events](https://github.com/eoma/kvarteret_symfony_events)

What is kvarteret? See [kvarteret.no](http://kvarteret.no/)

## <a name="installation">Installation</a> ##

### <a name="dependencies">Dependencies</a> ###

In addition to symfony 1.4, this project forces you to use 
[Doctrine 1.2] [dt] as ORM for symfony (if you don't know what 
Doctrine is, you're already using it in symfony). Please see
[symfony's tutorials][sfdoc].

It is assumed that you already have setup a symfony project with
a backend application and a frontend application.

It also requires you to use:

*   [sfDoctrineGuardPlugin][]
*   [sfDoctrineNestedSetPlugin][]
*   [sfCKEditorPlugin][] (depends on CKEditor, user flag --stability=beta)
*   [HTMLPurifier][]
*   [sfImageTransformPlugin][]
*   [sfImageTransformExtraPlugin][]

  [sfDoctrineGuardPlugin]: http://www.symfony-project.org/plugins/sfDoctrineGuardPlugin
  [sfDoctrineNestedSetPlugin]: http://www.symfony-project.org/plugins/sfDoctrineNestedSetPlugin
  [sfCKEditorPlugin]: http://www.symfony-project.org/plugins/sfCKEditorPlugin
  [HTMLPurifier]: http://htmlpurifier.org
  [sfImageTransformPlugin]: http://www.symfony-project.org/plugins/sfImageTransformPlugin
  [sfImageTransformExtraPlugin]: http://www.symfony-project.org/plugins/sfImageTransformExtraPlugin

Install them from stock using symfony's

    php symfony plugin:install <nameOfPlugin>

or use their bleeding edge versions on git or svn. Install them 
before you install this plugin.

HTMLPurifier should be installed in the projects lib/vendor/ directory under
the name htmlpurifier.

After that, add the following section to your project's config/autoload.yml.

    # Autoload mechanism for HTMLPurifier
      htmlpurifier:
        name:       htmlpurifier
        path:       %SF_LIB_DIR%/vendor/htmlpurifier/library
        recursive:  on

If the autoload.yml file doesn't exist, create it and put in

    autoload:
    # Autoload mechanism for HTMLPurifier
      htmlpurifier:
        name:       htmlpurifier
        path:       %SF_LIB_DIR%/vendor/htmlpurifier/library
        recursive:  on

  [dt]: http://www.doctrine-project.org/

### <a name="plugin-installation">Plugin installation</a> ###

Currently you have to use the [git version on github][gh].
If you either use the download option or the git version, 
it has to be installed in your symfony project's plugins directory, 
as all other symfony plugins.

For git, go to your plugins directory and issue the command

    git clone https://github.com/eoma/dakEventsPlugin dakEventsPlugin

Then edit your config/ProjectConfiguration.class.php and add

    $this->enablePlugins('dakEventsPlugin');

at the end of the setup method.

You must then create the folder thumbs and uploads in the web/ directory and set them to
be writable by the web server. (you can use chmod a+rwx web/thumbs and chmod a+rwx web/uploads,
although not recommended as it gives everyone write permission).

  [gh]: https://github.com/eoma/dakEventsPlugin/

### <a name="project-setup">Setup in a project</a> ###

#### <a name="project-frontend">Frontend</a> ####

Recommended modules for use in a frontend application:

*   dakApi
*   dakEvent
*   dakFestival
*   dakArranger
*   dakCategory
*   dakLocation
*   sfImageTransformator

It's recommended that you enable every module as they link to each other.
You cam omit the dakApi module, for the moment.

They register the (relative) path /api, /event, /festival and so forth.

They can be referenced through the path name dak_event, dak_api, dak_festival
and so forth. Have a look at 
[config/routing.yml](https://github.com/eoma/dakEventsPlugin/tree/master/config/routing.yml)

Add each of these to the enabled_modules for the all environment in the frontend application's
settings.yml

      #Enabled modules
      enabled_modules:
      - dakEvent
      - dakFestival
      - dakArranger
      - dakCategory
      - dakLocation
      - sfImageTransformator

If you want to use internationalisation (i18n) you can set, in frontend's config/settings.yml:

        # Default charset
        charset: utf-8

        # Default culture
        default_culture: en

        # Enable internationalization of interface
        i18n: true

        # Standard helpers
        standard_helpers: [Partial, Cache, I18N]

Change culture to your own taste. (eg. no for norwegian, fr for french, etc.)

#### <a name="project-backend">Backend</a> ####

Recommended modules for use in backend application:

*   dakEventAdmin
*   dakFestivalAdmin
*   dakArrangerAdmin
*   dakCategoryAdmin
*   dakLocationAdmin
*   sfImageTransformator

Additional (not complete) modules:

*   dakLocationReservationAdmin

See [frontend](#project-frontend) on how to enable these modules.

Each of these modules can be referenced through the routes dak_event_admin,
dak_festival_admin, dak_arranger_admin and so forth.

Each of these modules use a bit of javascript, jQuery, so it has 
to be defined in the backend's view.yml or layout.php

It's recommended that you set the backend to be secure by default, but you've probably
did that already, as it's assumed you've install the plugin [sfDoctrineGuardPlugin][].
