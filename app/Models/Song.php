<?php

namespace App\Models;

use App\Contracts\Nameable;
use App\Events\Song\SongCreated;
use App\Events\Song\SongDeleted;
use App\Events\Song\SongDeleting;
use App\Events\Song\SongUpdated;
use App\Pivots\ArtistSong;
use ElasticScoutDriverPlus\CustomSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Contracts\Auditable;

class Song extends Model implements Auditable, Nameable
{
    use CustomSearch, HasFactory, Searchable;
    use \OwenIt\Auditing\Auditable;

    /**
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * The event map for the model.
     *
     * Allows for object-based events for native Eloquent events.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => SongCreated::class,
        'deleted' => SongDeleted::class,
        'deleting' => SongDeleting::class,
        'updated' => SongUpdated::class,
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'song';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'song_id';

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        if (empty($this->title)) {
            return $this->song_id;
        }

        return $this->title;
    }

    /**
     * Get the themes that use this song.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function themes()
    {
        return $this->hasMany('App\Models\Theme', 'song_id', 'song_id');
    }

    /**
     * Get the artists included in the performance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function artists()
    {
        return $this->belongsToMany('App\Models\Artist', 'artist_song', 'song_id', 'artist_id')->using(ArtistSong::class)->withPivot('as');
    }
}
