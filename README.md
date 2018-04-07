# BMW-i3-Status
BMW i3 Status

PHP script to log into the USA BMW Connected Website, scrape info: SoC, Max SoC (SoH), Geolocation, etc and email the information. You can set it to run via cron on your server as often as you wish.

Instructions:
1.) Rename bmwi3status.txt to bmwi3status.php
2.) Add your username, password, and email address at minimum to execute correctly. Add Google Maps API key if you also want the physical address of the BMW i3.
3.) Upload it to an environment of your choice and run:

php bmwi3status.php

4.) Set up cron if you wish.
