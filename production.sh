#!/bin/bash

# Publishes on http://guifibaix.coop
# sudo apt-get install git-ftp

(git checkout gh-pages && git ftp push ftp://guifibaix.coop/ -u guifibaixcoop@vviudez.com -v -p && false ) || git checkout master


