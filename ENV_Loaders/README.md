# Loading a .env vs PHP Array 

Various frameworks and/or PHP projects choose to load information using a .env file. 

This also happens to be one of the first things a framework does to initiate
and this process happens every time your website is loaded by some one.

When I develop a project, I like to obsess about each moment in its life cycle
and see what action does to speed and memory use. 

So I ran AB tests
``` 
ab  -c 100 -n 10000 http://127.0.0.1/experiments/ENV_Loaders/index.php?test={n}
```

###Tests

```$xslt
1. No Includes
2. Composer Loaded
3. ENV set with PHP Array
4. .env Loaded with Symfony's Dotenv Component
5. .env Loaded with vlucas/phpdotenv Component
```

Please note that I include Composer in my tests because it is hard to live without it
in today's real world. I find it does not hinder speed and memory to outweigh the benefits.
I have even included some popular packages (Guzzle, Twig, Carbon, etc) to show that Composer
does not load these files without initializing them and do little to the test results.



###Test 1 Just the base server info

Loading the index file, that does nothing but output html and base stats

```$xslt
HTML transferred:       5788978 bytes
Requests per second:    1560.20 [#/sec] (mean)
Time per request:       64.094 [ms] (mean)
Time per request:       0.641 [ms] (mean, across all concurrent requests)

Load Time: 0.0008
Memory Usage: 387.69 kb
Total Files: 1
```



###Test 2 just Composer

Loading the index file, Composer autoload included

```$xslt
HTML transferred:       17438644 bytes
Requests per second:    1125.89 [#/sec] (mean)
Time per request:       88.819 [ms] (mean)
Time per request:       0.888 [ms] (mean, across all concurrent requests)
Transfer rate:          2313.19 [Kbytes/sec] received

Load Time is 0.0013
Memory Usage 394.28 kb
Total Files: 15
```


###Test 3 using PHP $_ENV['VAR'] = "SOMETHING"

Loading the index file, Composer autoload included, PHP Based Array of Environment Settings

```$xslt
HTML transferred:       18008656 bytes
Requests per second:    1160.05 [#/sec] (mean)
Time per request:       86.203 [ms] (mean)
Time per request:       0.862 [ms] (mean, across all concurrent requests)
Transfer rate:          2447.96 [Kbytes/sec] received


Load Time is 0.0017
Memory Usage 396.89 kb
Total Files: 16
```


###Test 4 using symfony/dotenv

Now loading the .env file with 50 variables using Symfony

```$xslt
HTML transferred:       18178812 bytes
Requests per second:    658.47 [#/sec] (mean)
Time per request:       151.868 [ms] (mean)
Time per request:       1.519 [ms] (mean, across all concurrent requests)
Transfer rate:          1400.45 [Kbytes/sec] received



Load Time is 0.0039
Memory Usage 422.56 kb
Total Files: 16
```


###Test 5 using vlucas/phpdotenv

Now loading the .env file with 50 variables using vlucas/phpdotenv

```$xslt
HTML transferred:       33918824 bytes
Requests per second:    501.51 [#/sec] (mean)
Time per request:       199.398 [ms] (mean)
Time per request:       1.994 [ms] (mean, across all concurrent requests)
Transfer rate:          1837.50 [Kbytes/sec] received

Load Time is 0.0039
Memory Usage 501.47 kb
Total Files: 32
```
