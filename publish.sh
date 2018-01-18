#!/bin/bash

# Publishes on http://guifibaix.github.io/guifibaix-web/


function die() { echo -e '\033[31m'"$@"'\033[0m' >&2; exit -1; }


# Just in case something is missing to be generated
hyde gen

# Abort if any pending change in content or deploy
git diff HEAD --exit-code content deploy || die "Error: Per poder publicar, cal comitejar o apartar (git stash) els canvis d'adalt"

# Merge changes done on deploy/ into the subtree branch in gh-pages
git subtree split --prefix=deploy --branch gh-pages

# Push gh-pages into github
git push origin gh-pages

