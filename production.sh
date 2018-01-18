#!/bin/bash

# Publishes on http://guifibaix.coop


function die() { echo -e '\033[31;1m'"$@"'\033[0m' >&2; exit -1; }

key=~/.ssh/gbwebdeploy

[ -f "$key" ] || die "Necesitas instalar las claves $(basename $key) en $(dirname $key)"
(ssh-add -l | grep "$key" >/dev/null) || ssh-add "$key" || die Error cargando la clave gbwebdeploy

# Requires gbwebdeploy key pair to be on ~/.ssh
ssh -i ~/.ssh/gbwebdeploy vviudez@guifibaix.coop -p 2222

# Old way, for the record
# sudo apt-get install git-ftp
#(git checkout gh-pages && git ftp push ftp://guifibaix.coop --remote-root site/ -u guifibaixcoop@vviudez.com -v -P && false ) || git checkout master

