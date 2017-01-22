DomainDrivenDesign-demo
=======================

Install
-------

If you have docker and docker-compose installed on your machine, installation should be as easy as:

```bash
./provisionning/start.sh
```

If you don't, do not hesitate to ask us to provide an alternative.

Commands
--------

* `./provisionning/browser.sh` opens the project homepage to your default browser. This is mainly useful because the port may vary between runs
* `./provisionning/composer.sh` is a wrapper for the composer tool located inside the php container
* `./provisionning/destroy.sh` destroy every containers and network.
* `./provisionning/start.sh` (re)build every containers, run them and prepare the application. This should be used every time you switch to another branch.
