#!/usr/bin/env bash
# Prioriza PHP 8.2 (Homebrew keg-only) en esta sesión de terminal.
# Uso:   source bin/use-php-8.2.sh
# Luego: php -v   → debe mostrar 8.2.x
#
# Ruta típica Apple Silicon (Homebrew): /opt/homebrew/opt/php@8.2/bin
# Intel: /usr/local/opt/php@8.2/bin

if [[ -x /opt/homebrew/opt/php@8.2/bin/php ]]; then
  export PATH="/opt/homebrew/opt/php@8.2/bin:/opt/homebrew/opt/php@8.2/sbin:$PATH"
elif [[ -x /usr/local/opt/php@8.2/bin/php ]]; then
  export PATH="/usr/local/opt/php@8.2/bin:/usr/local/opt/php@8.2/sbin:$PATH"
else
  echo "No se encontró php@8.2 de Homebrew. Instalá con: brew install php@8.2" >&2
  return 1 2>/dev/null || exit 1
fi
