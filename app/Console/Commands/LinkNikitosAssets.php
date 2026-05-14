<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LinkNikitosAssets extends Command
{
    protected $signature = 'nikitos:link-assets';

    protected $description = 'Crea public/nikitos como enlace simbólico a la carpeta Nikitos/ del proyecto (assets Figma exportados).';

    public function handle(): int
    {
        $source = base_path('Nikitos');
        $link = public_path('nikitos');

        if (! is_dir($source)) {
            $this->error('No existe la carpeta Nikitos/ en la raíz del repositorio.');

            return 1;
        }

        if (file_exists($link)) {
            if (is_link($link)) {
                @unlink($link);
            } else {
                $this->error('public/nikitos ya existe y no es un enlace simbólico. Renombralo o eliminalo y volvé a ejecutar el comando.');

                return 1;
            }
        }

        if (! @symlink('../Nikitos', $link)) {
            $this->error('No se pudo crear el enlace simbólico. En Windows puede requerir modo administrador o activar Developer Mode para symlinks.');

            return 1;
        }

        $this->info('Listo: public/nikitos → ../Nikitos');

        return 0;
    }
}
