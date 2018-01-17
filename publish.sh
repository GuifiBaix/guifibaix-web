#!/bin/bash

# Publishes on http://guifibaix.github.io/guifibaix-web/

hyde gen
git subtree split --prefix=deploy --branch gh-pages
git push origin gh-pages

