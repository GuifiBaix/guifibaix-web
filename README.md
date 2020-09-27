guifibaix-web
=============

Official GuifiBaix website

This site uses hyde static page generator.
Debian package for `hyde` is old, use a virtualenv instead.
This will create a proper environment named 'web-guifibaix':

	./setupenv.sh

Edits are done in `content/` and the web is generated at `deploy`.
`layout` contains the templates to wrap the content.

To view the web locally in http://localhost:8080

	hyde serve

When working on 'master' branch remember to run:

	hyde gen -r

before commiting in order to have ensure `deploy/` is up-to-date with `content/`

To publish testing preview on <http://guifibaix.github.io/guifibaix-web> use:

	./publish.sh

To publish on <http://guifibaix.coop>:

	./production.sh

This requires having a ssh key named `gbwebdeploy` copied on `~/.ssh/`.


