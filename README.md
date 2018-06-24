# laravel-eypmanager

## work queue - systemd

```
root@shuvak:/etc/systemd/system# systemctl start laravelqueue@meteoapi
root@shuvak:/etc/systemd/system# systemctl status laravelqueue@meteoapi
● laravelqueue@meteoapi.service - Laravel queue worker meteoapi
   Loaded: loaded (/etc/systemd/system/laravelqueue@.service; disabled; vendor preset: enabled)
   Active: active (running) since Sun 2018-06-24 20:08:03 CEST; 1s ago
 Main PID: 11136 (php)
   CGroup: /system.slice/system-laravelqueue.slice/laravelqueue@meteoapi.service
           └─11136 /usr/bin/php /home/jprats/git/laravel-meteoapi/meteoapi/artisan queue:work --daemon --env=production

Jun 24 20:08:03 shuvak systemd[1]: Started Laravel queue worker meteoapi.
root@shuvak:/etc/systemd/system# systemctl enable laravelqueue@meteoapi
Created symlink from /etc/systemd/system/multi-user.target.wants/laravelqueue@meteoapi.service to /etc/systemd/system/laravelqueue@.service.
root@shuvak:/etc/systemd/system# cat laravelqueue@.service
[Unit]
Description=Laravel queue worker %i

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /home/jprats/git/laravel-%i/%i/artisan queue:work --daemon --env=production

[Install]
WantedBy=multi-user.target
root@shuvak:/etc/systemd/system#
```
