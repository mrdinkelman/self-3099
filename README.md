# SELF-3099 Import CSV test task
![alt tag](https://img.shields.io/badge/build-passing-green.svg) 
![alt tag](https://img.shields.io/badge/state-waiting%20response-blue.svg)
![alt tag](https://img.shields.io/badge/version-1.0.0--alpha-orange.svg)
![alt tag](https://img.shields.io/badge/coverage-100%25-green.svg)


Hello, this is short info about SELF-3099 Import task.
First of all, please look at [original technical task]: <https://github.com/mrdinkelman/self-3099/blob/master/vagrant/task/Candidate%20Development%20Test.docx>

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
Input test CSV located [here]:<https://github.com/mrdinkelman/self-3099/blob/master/vagrant/task/stock.csv>
