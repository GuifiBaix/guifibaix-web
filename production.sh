#!/bin/bash

# Publishes on http://guifibaix.coop
# sudo apt-get install git-ftp

(git checkout gh-pages && git ftp push ftp://guifibaix.coop --remote-root site/ -u guifibaixcoop@vviudez.com -v -P && false ) || git checkout master


