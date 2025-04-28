#!/bin/bash
sudo msgfmt -o /var/www/webscraping.local/locales/es_ES/LC_MESSAGES/messages.mo /var/www/webscraping.local/locales/es_ES/LC_MESSAGES/messages.po
sudo msgfmt -o /var/www/webscraping.local/locales/en_US/LC_MESSAGES/messages.mo /var/www/webscraping.local/locales/en_US/LC_MESSAGES/messages.po
echo "¡Archivos compilados con éxito! ✅"
