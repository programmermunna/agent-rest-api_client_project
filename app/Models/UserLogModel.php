<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Agent\Agent;

class UserLogModel extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = [
    //     'deleted_at',
    // ];

    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activity_log';

    public $timestamps = true;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public static function getCasuserName($id, $type)
    {
        $casuser = $type::find($id);

        if ($casuser) {
            return $casuser->name ?? $casuser->username;
        }

        return 'N/A';
    }

    public function getIp()
    {
        if (isset(json_decode($this->properties)->ip)) {
            return json_decode($this->properties)->ip;
        }

        return 'N/A';
    }

    public function getTarget()
    {
        if (isset(json_decode($this->properties)->target)) {
            return json_decode($this->properties)->target;
        }

        return 'N/A';
    }

    public function getActivity()
    {
        if (isset(json_decode($this->properties)->activity)) {
            return json_decode($this->properties)->activity;
        }

        return 'N/A';
    }

    public function getProperty(string $propertyName)
    {
        if (isset(json_decode($this->properties)->{$propertyName})) {
            return json_decode($this->properties)->{$propertyName};
        }

        return 'N/A';
    }

    //@todo generalise the log to include all model.
    /**
     * Log an Activity to a database
     *
     * @param String $logName
     * @param $causer
     * @param $performedOn
     * @param array $properties
     * @param String $description
     */
    public static function logMemberActivity(String $logName, $causer, $performedOn, array $properties, String $description)
    {

        $userAgent = new Agent();
        $userPlatform = null;
        if ($userAgent->isMobile()) {
            $userPlatform = "(Mobile) Brand name: {$userAgent->device()}. Model: {$userAgent->deviceType()}";
            $performedOn->update([
                'device' => $userPlatform,
            ]);
        }
        if ($userAgent->isDesktop()) {
            $userPlatform = "{$userAgent->browser()}";
            $performedOn->update([
                'device' => $userPlatform,
            ]);
        }

        if (!isset($properties['device'])) {
            if (!is_null($userPlatform)) {
                $properties['device'] = $userPlatform;
                $performedOn->update([
                    'device' => $userPlatform,
                ]);
            }
            if (is_null($userPlatform)) {
                $properties['device'] = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
                $performedOn->update([
                    'device' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
                ]);
            }
        }
        if (!isset($properties['ip'])) {
            // $properties['ip'] = request()->ip ?? request()->getClientIp();
            $properties['ip'] = request()->ip();
        }

        activity($logName)->causedBy($causer)
            ->performedOn($performedOn)
            ->withProperties($properties)
            ->log($description);
    }
}
