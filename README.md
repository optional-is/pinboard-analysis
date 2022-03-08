# Pinboard Analysis
This will analyse your Pinboard backup to get some statsitcs about what sites are online and link-rot

## Step 1
![Pinboard Settings Bacups](https://optional.is/required/wp-content/uploads/2022/03/pinboard-settings-backup-1024x383.png)

Log into pinboard.in and go to setting and backups and download your backup as JSON

## Step 2
Rename the file to pinboard.json and put it into the same director as this file

## Step 3
Open the terminal.app and change to the directory that contains this file

## Step 4
Type 'php stats.php > output.csv' and let it run through all the URLs.

This write both to stdout and stderr. You will see the progress of each URL checked on stderr and strout will build-up the csv

When it is complete, it will output some basis stats to the screen.