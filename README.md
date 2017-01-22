DomainDrivenDesign-demo
=======================

Install
-------

If you have docker and docker-compose installed on your machine, installation should be as easy as:

```bash
./bin/start-containers
```

If you don't, do not hesitate to ask us to provide an alternative.

Commands
--------

* `./bin/composer` is a wrapper for the composer tool located inside the php container
* `./bin/destroy-containers` destroy every containers and network.
* `./bin/open-in-browser` opens the project homepage to your default browser. This is mainly useful because the port may vary between runs
* `./bin/phpunit` runs PHPUnit including environment variable defined in the `.env` file
* `./bin/start-containers` (re)build every containers, run them and prepare the application. This should be used every time you switch to another branch.
