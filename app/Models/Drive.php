<?php

namespace App\Models;

use App\Exceptions\Devices\UnableToMountDriveException;
use Adldap\Connections\Configuration;
use Adldap\Laravel\Facades\Adldap;
use Stevebauman\WinPerm\Exceptions\InvalidPathException;
use Stevebauman\WinPerm\Permission;

class Drive extends Model
{
    /**
     * The drives table.
     *
     * @var string
     */
    protected $table = 'drives';

    /**
     * The fillable drive attributes.
     *
     * @var array
     */
    protected $fillable = ['name', 'path'];

    /**
     * The base path of the drive.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Returns an array of permissions for the current drive.
     *
     * @param string|null $path
     *
     * @throws UnableToMountDriveException
     *
     * @return array|bool
     */
    public function accounts($path = null)
    {
        if ($this->isNetwork()) {
            $this->setBasePath($this->mount());
        } else {
            $this->setBasePath($this->path);
        }

        $path = $this->basePath.DIRECTORY_SEPARATOR.$path;

        try {
            return (new Permission($path))->check();
        } catch (InvalidPathException $e) {
            //
        }

        return false;
    }

    /**
     * Returns a list of all directories inside of the specified path.
     *
     * @param string|null $path
     * @param array       $without
     *
     * @throws UnableToMountDriveException
     *
     * @return array
     */
    public function items($path = null, array $without = ['.', '..', '.DS_Store', '.TemporaryItems'])
    {
        if ($this->isNetwork()) {
            $this->setBasePath($this->mount());
        } else {
            $this->setBasePath($this->path);
        }

        $path = $this->basePath.DIRECTORY_SEPARATOR.$path;

        $items = [];

        try {
            $items = scandir($path);
        } catch (\ErrorException $e) {
            //
        }

        return array_diff($items, $without);
    }

    /**
     * Mounts the current drive onto the server with
     * the specified path, username and password.
     *
     * Returns the resulting mounted path.
     *
     * @param string|null $username
     * @param string|null $password
     * @param string      $drive
     *
     * @throws UnableToMountDriveException
     *
     * @return string
     */
    public function mount($username = null, $password = null, $drive = 'Z')
    {
        $path = $this->path;

        $config = Adldap::getConfiguration();

        if ($config instanceof Configuration) {
            if (is_null($username)) {
                $username = $config->getAdminUsername();
            }

            if (is_null($password)) {
                $password = $config->getAdminPassword();
            }
        }

        $command = sprintf('net use %s: %s %s /user:%s /persistent:no', $drive, $path, $password, $username);

        system($command, $returned);

        if ($returned === 0) {
            // Mounting failed, throw exception.
            throw new UnableToMountDriveException(sprintf('Unable to mount drive at path: %s', $path));
        }

        return str_replace($path, sprintf('%s:\\', $drive), $path);
    }

    /**
     * Returns true / false if the current drive is a network drive.
     *
     * @return bool
     */
    public function isNetwork()
    {
        return $this->is_network;
    }

    /**
     * Sets the base path of the drive.
     *
     * @param string $path
     */
    public function setBasePath($path)
    {
        $this->basePath = $path;
    }
}
