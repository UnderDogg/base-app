<?php

namespace App\Http\Controllers\Computer;

use App\Http\Controllers\Controller;
use App\Jobs\Computer\CreateStatus;
use App\Models\Computer;
use App\Policies\ComputerPolicy;

class ComputerStatusController extends Controller
{
    /**
     * @var Computer
     */
    protected $computer;

    /**
     * Constructor.
     *
     * @param Computer $computer
     */
    public function __construct(Computer $computer)
    {
        $this->computer = $computer;
    }

    /**
     * Returns the computers status graph information.
     *
     * @param int|string $id
     *
     * @return mixed
     */
    public function hourly($id)
    {
        if (ComputerPolicy::show(auth()->user())) {
            $computer = $this->computer->findOrFail($id);

            return $computer
                ->statuses()
                ->hourly()
                ->pluck('online', 'created_at');
        }

        $this->unauthorized();
    }

    /**
     * Checks the specified computers online status.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function check($id)
    {
        if (ComputerPolicy::show(auth()->user())) {
            $computer = $this->computer->findOrFail($id);

            if ($this->dispatch(new CreateStatus($computer))) {
                flash()->success('Success!', 'Successfully updated status.');

                return redirect()->back();
            }

            flash()->error('Error!', 'There was an issue updating this computers status. Please try again.');

            return redirect()->back();
        }

        $this->unauthorized();
    }
}
