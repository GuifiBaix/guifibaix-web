---
extends: false
---
#!/bin/bash

(
        cd $(dirname "$0")
        git fetch --all
        git diff
        git stash
        git rebase
)

