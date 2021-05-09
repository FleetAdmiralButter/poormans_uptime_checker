# PoorMans Uptime Checker
The PoorMans Uptime Checker module lets you perform uptime checks against other hosts right from your own Drupal site, without the need to pay for subscription or other fees.

Simply specify a list of domains you want to watch, set up a Drush cronjob, and let PoorMans Uptime Checker alert you any time it detects an outage from a domain on the list.

# Use
Go to `/admin/config/development/pmuc` to specify a list of domains to watch.

Example:
```
https://www.example.com/
http://example.com/page
```

Then, set up a cronjob on your server to run `drush pmuc-check-all` at regular intervals. Once per minute is usually a good interval.

Check the page at `/admin/config/pmuc/status` to see the status of checked hosts.

# Warning and Disclaimer
PoorMans Uptime Checker obviously relies on your Drupal infrastructure to be functioning in order to perform uptime checks. If your Drupal site crashes or becomes unavailable, there's a good chance that PoorMans Uptime Checker won't be running or sending out alerts either.

PoorMans Uptime Checker is still in development and many features are missing, broken, or in need of rewriting. Please experiment at your own risk.

# TODO
1 - Integration with services such as Dead Man's Snitch to alert a user if PoorMans Uptime Checker stops working.
2 - Collect more information about downtime, such as headers and start/stop times.