# Deploying Moodle on Elastic Beanstalk
Configurations to deploy a moodle envioronment with two instances for HA with an external database and autoscale to 4 instances.

## Cache recomendations
The nfs mount (Elastic File System) is a bad choice to store de application cache. It have a 5 seconds latency at least, very poor performance. To solve this issue is recomended to use a memcached node from Elasticache and configure it in moodle: Administration -> Plugins -> Caching -> Cache Stores.

## Domain name
I set up a CNAME alias pointing to the [Elastic Beanstalk environment URL](http://docs.aws.amazon.com/Route53/latest/DeveloperGuide/routing-to-beanstalk-environment.html#routing-to-beanstalk-environment-create-alias-procedure) on Route 53.

## Configuration files
Modify the configuration files in the .ebextensions folder with the IDs of your [default VPC and subnets](https://console.aws.amazon.com/vpc/home#subnets:filter=default), and [your public IP address](https://www.google.com/search?q=what+is+my+ip).

 - `.ebextensions/efs-create.config` creates an EFS file system and mount points in each Availability Zone / subnet in your VPC. Identify your default VPC and subnet IDs in the [VPC console](https://console.aws.amazon.com/vpc/home#subnets:filter=default). If you have not used the console before, use the region selector to select the same region that you chose for your environment.
 - `.ebextensions/efs-mount.config` mount EFS on instances.
 - `.ebextensions/cronjob.config` cron job needed for moodle (https://docs.moodle.org/33/en/Cron)
 - `.ebextensions/securitygroups.config` Elastic Load Balancer configurationssecurity groups, ssh whitelist, http and https ELB ports
 - `.ebextensions/configuration.config` Environment variables, php.ini options, deploy modes, autoscaling setttings, notifications, health checks, ELB configurations.
 - `config.php` To replace the database, user, password values in the config.php we use the enviornment variables, check the syntax in config.php.  

# Backup
Now that you've gone through all the trouble of installing your site, you will want to back up the data in RDS and EFS that your site depends on. See the following topics for instructions.

 - [DB Instance Backups](http://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/Overview.BackingUpAndRestoringAmazonRDSInstances.html)
 - [Back Up an EFS File System](http://docs.aws.amazon.com/efs/latest/ug/efs-backup.html)

# Documentation used
Documentation used: [Deploying a High-Availability WordPress Website with an External Amazon RDS Database to Elastic Beanstalk](https://docs.aws.amazon.com/elasticbeanstalk/latest/dg/php-hawordpress-tutorial.html).