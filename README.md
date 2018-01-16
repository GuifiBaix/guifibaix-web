guifibaix-web
=============

Official GuifiBaix website

This site uses hyde static page generator.
Debian package for `hyde` is old, use a virtualenv instead.
This will create a proper environment named 'web-guifibaix':

	./setupenv.sh

When working on 'master' branch remember to run:

	hyde gen -r

before commiting in order to have ensure deploy/ is up-to-date with content/

To view locally in http://localhost:8000

	hyde serve

To publish on github.io use:

	./publish.sh

To publish on http://guifibaix.coop:

	./production.sh

Publishing requires:

	sudo apt-get install git-ftp

