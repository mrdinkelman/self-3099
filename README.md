# SELF-3099 Import CSV test task
![alt tag](https://img.shields.io/badge/build-passing-green.svg) 
![alt tag](https://img.shields.io/badge/state-waiting%20response-blue.svg)
![alt tag](https://img.shields.io/badge/version-1.0.0--alpha-orange.svg)
![alt tag](https://img.shields.io/badge/coverage-100%25-green.svg)


Hello, 
first of all thanks for visiting and please look at <https://github.com/mrdinkelman/self-3099/blob/master/vagrant/task/Candidate%20Development%20Test.docx>. This is my first Symfony solution after short learning basical Symfony concepts and ideas.

For implementation I use external lib **ddeboer/data-import** 

In this task used basical functionality of 'data-import' but with some improvements and tweaks. 
Details and general info available at [project github]: <https://github.com/ddeboer/data-import>

This test solution use Symfony 2.8, PHP 5.6+ and command line for calling and delivering import results.

![alt tag](/vagrant/Selection_210.png?raw=true "Preview")

### Usage

Before start, get all needed files with 'composer update' and don't forget to init database. 
Creating script located at https://github.com/mrdinkelman/self-3099/blob/master/vagrant/task/make_database.sql

Run Doctrine migration up
```sh
$ php app/console doctrine:migrations:execute 20160527165503 --up
```

In console, in project folder: 

```sh
$ php app/console import:products
```

or in test mode
```sh
$ php app/console import:products -t
```

More options (changing file) available with --help command.
Input test CSV located <https://github.com/mrdinkelman/self-3099/blob/master/vagrant/task/stock.csv>

### Base ideas
* All logic related to import process placed in /Services
* Console command just collect info and pass to service
* Potential encoding problem solved with external lib - ***neitanod/forceutf8*** https://github.com/neitanod/forceutf8
* Price & Stock rules can be easy tuned up in ProductData helper. Also, all names, fields and rules located here.
* Migrations script can be found in app/DoctrineMigrations (default Symfony creation path). For money column I choose DECIMAL data-type
* Discontinues items control - in values converters, idea if we have something in this field in source - return Datetime.


### Small tweaks and improvements, from /src/ImportBundle
* /Helper/ConsoleHelper with SymfonyStyle - easy organizing pretty output (colors, notes, titles and etc.) for results messages
* /Helper/DateTime extending default DateTime by adding __toString() method. It's needed because if you want replace DocrtineWriter to ConsoleTableWriter (see details in import lib, Workflow section) and call Workflow->process() you will get an Exception. Reason - import lib can't implement string representaion of \DateTime. Sure, we can use value converters for it, but I think that's more easy to use extending
* /Helper/IImport interface will help you with organizing your import rules
* /Filters - standard filter component from import lib don't provide reject reasons, I think, sometimes reject reasons may be useful for user. Extend your own filer from BaseFilter and then you can get reject reason. 
* Added ability to add FilterExceptions, this is not simple "false" - may be useful for handle critical errors like 'unsupported data-type'
* like default in lib, just put you /ItemConverts and /ValueConverter in same folders.
* Result and Workflow parent classes extened, it's needed for adding reject reasons processing

### Tests
* covered only files in ImportBundle

### Have a nice day ;)

and, sure small notes:
* vargrant installation and starting blank project with db, php version and etc - not implemented yet :(, main problem is tuning phpbrew. It can be possible with https://www.chef.io/ by additional request
* project growind and studing can be checked in history for 'develop' branch.
