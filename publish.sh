#!/bin/bash

git subtree split --prefix=deploy --branch gh-pages
git push origin gh-pages

