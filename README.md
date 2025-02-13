***Tech Test***

*Spec:*

Objective:
Your assignment is to implement a URL shortening service.
Brief:
Create a URL shortening service where you enter a URL such as https://www.thisisalongdomain.com/with/some/parameters?and=here_too and it returns a short URL such as http://short.est/GeAi9K.
Tasks:
Two endpoints are required:
/encode - Encodes a URL to a shortened URL
/decode - Decodes a shortened URL to its original URL
Both endpoints should return JSON. There is no restriction on how your encode/decode algorithm should work. You just need to make sure that a URL can be encoded to a short URL and the short URL can be decoded to the original URL.
You do not need to persist short URLs if you don't need to you can keep them in memory. Provide detailed instructions on how to run your assignment in a separate markdown file or readme.
Cover all functionality with tests.

*Output*:

I put all my commits and code into this repo, including a laravel 11 install. Running `php artisan migrate` to populate/initiate the sqlite3 cache tables, followed by `php artisan server` should suffice to run the tests.

Uses redis for storing url's short term (1 day). This needs a little bit of installing, so I create a very simple bash script for this (install-redis.sh).

Tests and code are in the usual places. I did need to tweak bootstrap a little to load the api routes - that's in a commit of its' own for granularity, by which I mean it should be undoable using git if a sys-admin called foul.
