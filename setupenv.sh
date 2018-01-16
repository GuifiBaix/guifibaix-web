#!/bin/bash

source /usr/share/virtualenvwrapper/virtualenvwrapper.sh

mkvirtualenv -p$(which python2) -i hyde web-guifibaix

echo Entorno creado.
echo Para entrar: 'workon web-guifibaix'
echo Para salir: 'deactivate'


