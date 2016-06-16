# SELF-3099 Import CSV test task
![alt tag](https://img.shields.io/badge/build-passing-green.svg) 
![alt tag](https://img.shields.io/badge/state-waiting%20response-blue.svg)
![alt tag](https://img.shields.io/badge/version-1.0.0--alpha-orange.svg)
![alt tag](https://img.shields.io/badge/coverage-100%25-green.svg)


Hello, this is short info about SELF-3099 Import task.
First of all, please look at <https://github.com/mrdinkelman/self-3099/blob/master/vagrant/task/Candidate%20Development%20Test.docx>

For implementation I use external lib **ddeboer/data-import** 

In this task used basical functionality of 'data-import' but with some improvements and tweaks. 
Details and general info available at [project github]: <https://github.com/ddeboer/data-import>

This test solution use Symfony 2.8, PHP 5.6+ and command line for calling and delivering import results.

![alt tag](/vagrant/Selection_210.png?raw=true "Preview")

### Usage

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

### Short description


### Small tweaks and improvements, from /src/ImportBundle
* /Helper/ConsoleHelper with SymfonyStyle - easy organizing pretty output (colors, notes, titles and etc.)
* /Helper/DateTime extending default DateTime for adding __toString() method. It's needed because if you want add ConsoleWriter to process and then run it with DateTime values you will get Exception, that import lib can not implement string representaion of DateTime. Sure, we can use value converters, but I think that's more easy to use with DateTime values
* /Helper/IImport interface will help you with organizing your import rules
* /Filters - standard filter component from import lib don't provide reject reasons, I think, sometimes reject reasons may be useful for user. Extend your own filer from BaseFilter and then you can get reject reason. 
* like default in lib, just put you /ItemConverts and /ValueConverter in same folders.
* Result and Workflow parent classes extened, it's needed for adding reject reasons processing

### Tests

