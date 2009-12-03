# Langify

Langify is a module for kohanaphp v3.

It allows you to import kohana i18n files into a db, have your visitors translating it, and then export it back as i18n files.

##Requirements
* Kohanaphp v3
* Sprig (http://github.com/shadowhand/sprig)

##Install
* Place the module into your module folder
* Add the module to your bootstrap.php file
* Move tmedia folder to your kohana root folder.
* Import the database.sql file into your database.

##Get Started

* Import a i18n file using the import function, you need to enter the password defined in config file.
* Edit the language.
* Export your finnished translated strings into useable i18n files.