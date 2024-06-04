ssh -t -t $SP_REMOTE_USER@$SP_REMOTE_HOST << EOF
    cd www/fitness-tracker.soapatrick.com
    php artisan down
    composer update
    php artisan icons:clear
    php artisan view:clear
    php artisan icons:cache
    php artisan up
    exit
EOF