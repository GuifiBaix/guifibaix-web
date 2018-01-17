#!/bin/bash

# Publishes on http://guifibaix.github.io/guifibaix-web/

# Just in case something is missing to be generated
hyde gen

# Merge changes done on deploy/ into the subtree branch in gh-pages
git subtree split --prefix=deploy --branch gh-pages

# Push gh-pages into github
git push origin gh-pages

