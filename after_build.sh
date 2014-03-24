    #!/bin/bash
PHP=php

echo 'Download the composer.phar file, so the vendors can be installed from the distributed composer.json.'
if [ ! -f composer.phar ]
    then
        curl -s -O http://getcomposer.org/composer.phar
fi

echo 'Update composer.phar.'
$PHP composer.phar self-update

echo 'Install the needed vendors for this application.'
$PHP composer.phar install

echo 'Dump the optimized autoloader classmap for performance reasons.'
$PHP composer.phar dump-autoload --optimize
