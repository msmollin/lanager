<?php namespace Zeropingheroes\Lanager\Domain\Events;

use Laracasts\Presenter\PresentableTrait;
use Zeropingheroes\Lanager\Domain\BaseModel;

class Event extends BaseModel
{

    use PresentableTrait;

    protected $presenter = 'Zeropingheroes\Lanager\Domain\Events\EventPresenter';

    protected $fillable = ['name', 'description', 'start', 'end', 'signup_opens', 'signup_closes', 'event_type_id', 'published'];

    protected $nullable = ['description', 'signup_opens', 'signup_closes'];

    protected $optional = ['published'];

    /**
     * A single event belongs to a single event type
     * @return object Illuminate\Database\Eloquent\Relations\Relation
     */
    public function type()
    {
        return $this->belongsTo('Zeropingheroes\Lanager\Domain\EventTypes\EventType', 'event_type_id');
    }

    /**
     * A single event has many event signups
     * @return object Illuminate\Database\Eloquent\Relations\Relation
     */
    public function eventSignups()
    {
        return $this->hasMany('Zeropingheroes\Lanager\Domain\EventSignups\EventSignup');
    }

    /**
     * Check if the event is open for signups
     * @return boolean    True if event is open for signups, false otherwise
     */
    public function isOpenForSignups()
    {
        if (is_null($this->signup_opens)) {
            return false;
        }

        return (time() < strtotime($this->signup_closes) && time() > strtotime($this->signup_opens));
    }

    /**
     * Check if the event has a signup from a given user
     * @param  int $userId User's id in the database
     * @return boolean                True if event has a signup from the specified user, false otherwise
     */
    public function hasSignupFromUser($userId)
    {
        return ($this->eventSignups()->where('user_id', $userId)->count() > 0);
    }

    /**
     * Check if the event allows signups
     * @return boolean    True if event allows signups, false otherwise
     */
    public function allowsSignups()
    {
        return (!is_null($this->signup_opens));
    }

}