<?php

namespace App\Http\Presenters\Device;

use App\Http\Presenters\Presenter;
use App\Models\Computer;
use App\Models\ComputerHardDisk;
use Khill\Lavacharts\Configs\DataTable;
use Khill\Lavacharts\Laravel\LavachartsFacade as Lava;
use Orchestra\Html\Table\Grid as TableGrid;

class ComputerDiskPresenter extends Presenter
{
    /**
     * Displays the specified computers disks.
     *
     * @param Computer $computer
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function disks(Computer $computer)
    {
        return $this->table->of('computers.disks', function (TableGrid $table) use ($computer) {
            $table->rows($computer->disks->all());

            $table->attributes('class', 'table table-hover');

            $table->column('name', function ($column) {
                $column->label = 'Name';
            });

            $table->column('size', function ($column) {
                $column->label = 'Size';
                $column->value = function (ComputerHardDisk $disk) {
                    return $disk->getSizeReadable();
                };
            });

            $table->column('used', function ($column) {
                $column->label = 'Used';
                $column->value = function (ComputerHardDisk $disk) {
                    return $disk->getPercentUsedProgressBar();
                };
            });
        });
    }

    /**
     * Returns a new line chart of the specified computers disks.
     *
     * @param Computer $computer
     *
     * @return \Khill\Lavacharts\Charts\LineChart|false
     */
    public function diskGraph(Computer $computer)
    {
        if ($computer->disks->count() > 0) {
            /** @var DataTable $disks */
            $disks = Lava::DataTable();

            $disks->addDateColumn('Date');

            $rows = [];

            $i = 0;

            foreach ($computer->disks as $disk) {
                $i++;

                $disks->addNumberColumn($disk->name);

                foreach ($disk->records as $record) {
                    $rows[] = [
                        0   => $record->created_at,
                        $i  => $record->free,
                    ];
                }
            }

            $disks->addRows($rows);

            return Lava::LineChart('Disks')->dataTable($disks);
        }

        return false;
    }
}
