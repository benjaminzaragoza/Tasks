Path:

``
/etc/supervisor/conf.d/tasks.benjaminzaragoza.scool.cat.conf
``

Contingut:

Local:
``
[program:laravel-worker-tasks.benjaminzaragoza-scool-cat]
process_name=%(program_name)s_%(process_num)02d
command=php /home/benjamin/Code/benjaminzaragoza/tasks/artisan queue:work redis--sleep=3 --tries=3
autorestart=true
user=benjamin
numprocs=8
redirect_stderr=true
stdout_logfile=/home/benjamin/Code/benjaminzaragoza/tasks/storage/logs/worker.log
``