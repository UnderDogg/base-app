<?php

namespace App\Processors\ActiveDirectory;

use Adldap\Schemas\ActiveDirectory;
use Adldap\Models\User;
use Adldap\Contracts\Adldap;
use App\Jobs\ActiveDirectory\ImportUser;
use Illuminate\Http\Request;
use App\Http\Requests\ActiveDirectory\UserImportRequest;
use App\Http\Presenters\ActiveDirectory\UserPresenter;
use App\Processors\Processor;

class UserProcessor extends Processor
{
    /**
     * @var UserPresenter
     */
    protected $presenter;

    /**
     * @var Adldap
     */
    protected $adldap;

    /**
     * Constructor.
     *
     * @param UserPresenter $presenter
     * @parma Adldap        $adldap
     */
    public function __construct(UserPresenter $presenter, Adldap $adldap)
    {
        $this->presenter = $presenter;
        $this->adldap = $adldap;
    }

    /**
     * Displays all active directory users.
     *
     * @param Request $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('index', User::class);

        $search = $this->adldap->users()->search();

        if ($request->has('q')) {
            $query = $request->input('q');

            $search = $search
                ->orWhereContains(ActiveDirectory::COMMON_NAME, $query)
                ->orWhereContains(ActiveDirectory::DESCRIPTION, $query)
                ->orWhereContains(ActiveDirectory::OPERATING_SYSTEM, $query);
        }

        $all = $search
            ->whereHas(ActiveDirectory::EMAIL)
            ->sortBy(ActiveDirectory::COMMON_NAME, 'asc')->get();

        $users = $this->presenter->table($all->toArray());

        $navbar = $this->presenter->navbar();

        return view('pages.active-directory.users.index', compact('users', 'navbar'));
    }

    /**
     * Imports an active directory user.
     *
     * @param UserImportRequest $request
     *
     * @return bool|mixed
     */
    public function store(UserImportRequest $request)
    {
        $this->authorize('store', User::class);

        $user = $this->adldap->search()->findByDn($request->input('dn'));

        if ($user instanceof User) {
            return $this->dispatch(new ImportUser($user));
        }

        return false;
    }
}
