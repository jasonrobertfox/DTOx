#DTOx
Tired of toxic, tedious code? Create quality DTOs with DTOx!

##Usage
Checkout the main documentation for more info: [http://jrobertfox.github.com/DTOx](http://jrobertfox.github.com/DTOx)

    dtox react dto 'SludgeCo\Acid\BurnyDTO' string:name int:burnLevel

    dtox react dto-unit 'SludgeCo\Acid\BurnyDTO' "Red Acid:name" 10:burnLevel

##Use Online
Checkout the [web interface](http://dtox.pagodabox.com) to build your DTOs interactively.

##Development Requirements
- [Composer](http://getcomposer.org/)
- PHP 5.3.14+
- [Apache Ant](http://ant.apache.org/)

##Development

Clone the repo:

    git clone git@github.com:jrobertfox/DTOx.git

Bootstrap the application:

    cd build-deploy
    ant bootstrap

Run a full build all the time:

    cd build-deploy
    ant build:full
