<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LinkNikitosAssets extends Command
{
    protected $signature = 'nikitos:link-assets';

    protected $description = 'Crea public/nikitos como enlace simbólico a la carpeta Nikitos/ en la raíz del proyecto (si usás assets fuera de public/).';

    public function handle(): int
    {
        $source = base_path('Nikitos');
        $link = public_path('nikitos');

        if (is_dir($link) && ! is_link($link)) {
            $this->info('Ya existe la carpeta public/nikitos (contenido versionado). No se creó enlace.');

            return 0;
        }

        if (! is_dir($source)) {
            $this->error('No existe Nikitos/ en la raíz. Los PNG del sitio deben estar en public/nikitos/ (minúsculas) y subirse al repo con git.');

            return 1;
        }

        if (file_exists($link)) {
            if (is_link($link)) {
                @unlink($link);
            } else {
                $this->error('public/nikitos ya existe y no es un enlace simbólico.');

                return 1;
            }
        }

        if (! @symlink('../Nikitos', $link)) {
            $this->error('No se pudo crear el enlace simbólico. En Windows puede requerir modo administrador o Developer Mode para symlinks.');

            return 1;
        }

        $this->info('Listo: public/nikitos → ../Nikitos');

        return 0;
    }
}
