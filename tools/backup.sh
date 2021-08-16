  #!/bin/bash

reldir=dirname "$0"
cd $reldir

rm -r ../data/*

php download_backup_lattes.php

NOW=$(date +"%Y-%m-%d")
FILE="backup.$NOW.zip"

zip -r ../backup/$FILE ../data