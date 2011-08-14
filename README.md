# Affiliate Network Earnings
This PHP app scrapes data from the reporting pages of affiliate networks and sends it to clients as JSON data.

## Architecture Overview
A problem with scraping web apps is that the data sources change frequently and break everything. This system is set up in a modular fashion, resulting in 2 benefits:
* Fails gracefully if data source is unavailable
* Easy to add new data sources

The PHP back end performs the actual scraping. JSON data is rendered by jQuery code on the front end.

## Implmentation Specifics
Each affiliate network website has a class in the networks subdirectory. These classes inherit the abstract Network class in Network.php
To add a new Affiliate network, add the class file to the networks folder and add an entry in networks.json.

## Installation
* Copy the files to your web server.
* Edit the username and password variables in earnings.php to protect your information.
* Edit the networks array in earnings.php to contain the networks you want to scrape along with your credentials for each one.
* Load index.php in your browser to see the results.