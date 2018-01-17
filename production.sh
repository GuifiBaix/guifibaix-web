#!/bin/bash

# Publishes on http://guifibaix.coop

# Requires gbwebdeploy key pair to be on ~/.ssh

ssh -i ~/.ssh/gbwebdeploy vviudez@guifibaix.coop -p 2222

# Old way, for the record
# sudo apt-get install git-ftp

#(git checkout gh-pages && git ftp push ftp://guifibaix.coop --remote-root site/ -u guifibaixcoop@vviudez.com -v -P && false ) || git checkout master

